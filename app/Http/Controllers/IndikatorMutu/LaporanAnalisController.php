<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LaporanAnalisController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $periodeAktif = $this->getPeriodeAktif();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode mutu aktif belum disetting');
        }

        $bulan = $request->bulan ?? Carbon::parse($periodeAktif->tanggal_mulai)->month;
        $tahun = $request->tahun ?? Carbon::parse($periodeAktif->tanggal_mulai)->year;

        $kategoriIndikator = $request->filled('kategori_indikator')
            ? $request->kategori_indikator
            : null;

        $indikators = $this->getIndikator($user, $kategoriIndikator);
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun, $kategoriIndikator);

        $kategoriIndikatorList = DB::table('tbl_kamus_indikator')
            ->select('kategori_indikator')
            ->whereNotNull('kategori_indikator')
            ->distinct()
            ->orderBy('kategori_indikator')
            ->pluck('kategori_indikator');

        $selectedIndikatorId = $request->indikator_id;
        $selectedUnitId = $request->unit_id;

        if (!$selectedIndikatorId && $indikators->isNotEmpty()) {
            $firstIndikator = $indikators->first();
            $selectedIndikatorId = $firstIndikator->id;
            $selectedUnitId = $firstIndikator->unit_id;
        }

        $kalenderData = null;
        $selectedIndikator = null;

        if ($selectedIndikatorId) {

            $selectedIndikator = $indikators->firstWhere('id', $selectedIndikatorId);

            if ($selectedIndikator) {

                $query = DB::table('tbl_laporan_dan_analis')
                    ->select(
                        'id',
                        'tanggal_laporan',
                        'numerator',
                        'denominator',
                        'nilai',
                        'indikator_id',
                        'unit_id',
                        'kategori_indikator',
                        'nilai_validator',
                        'status_laporan',
                    )
                    ->where('indikator_id', $selectedIndikatorId)
                    ->whereMonth('tanggal_laporan', $bulan)
                    ->whereYear('tanggal_laporan', $tahun);

                if ($selectedUnitId) {
                    $query->where('unit_id', $selectedUnitId);
                }

                $dataPengisian = $query->get()
                    ->keyBy(function ($item) {
                        return Carbon::parse($item->tanggal_laporan)->format('Y-m-d');
                    });

                $startOfMonth = Carbon::create($tahun, $bulan, 1);

                $kalenderData = [
                    'daysInMonth' => $startOfMonth->daysInMonth,
                    'skip' => $startOfMonth->dayOfWeekIso - 1,
                    'dataPengisian' => $dataPengisian,
                    'bulanNama' => $startOfMonth->translatedFormat('F Y'),
                ];
            }
        }

        return view('menu.IndikatorMutu.laporan-analis.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
            'kategoriIndikatorList' => $kategoriIndikatorList,
            'kategoriIndikator' => $kategoriIndikator,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kalenderData' => $kalenderData,
            'selectedIndikator' => $selectedIndikator,
            'selectedIndikatorId' => $selectedIndikatorId,
            'selectedUnitId' => $selectedUnitId,
        ]);
    }

    private function getIndikator($user, $kategoriIndikator = null)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_periode_pengumpulan_data as f', 'f.id', '=', 'k.periode_pengumpulan_data_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->join('tbl_periode as p', fn($join) => $join->where('p.status', 'aktif'))
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.unit_id',
                'i.target_indikator',
                'p.tanggal_mulai',
                'p.tanggal_selesai',
                'f.nama_periode_pengumpulan_data',
                'u.nama_unit',
                'k.kategori_indikator',
                'i.target_min',
                'i.target_max',
                'i.arah_target',
            )
            ->where('i.status_indikator', 'aktif')
            ->when($kategoriIndikator, function ($q) use ($kategoriIndikator) {
                $q->whereRaw(
                    "LOWER(k.kategori_indikator) LIKE ?",
                    ['%' . strtolower($kategoriIndikator) . '%']
                );
            })
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )
            ->orderByRaw("
            CASE 
                WHEN k.kategori_indikator ILIKE '%Nasional%' THEN 1
                WHEN k.kategori_indikator ILIKE '%Prioritas RS%' THEN 2
                WHEN k.kategori_indikator ILIKE '%Prioritas Unit%' THEN 3
                ELSE 4
            END ASC
        ")
            ->orderBy('i.id')
            ->get();
    }

    private function getRekapBulanan($user, $bulan, $tahun, $kategoriIndikator = null)
    {
        $start = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $query = DB::table('tbl_laporan_dan_analis as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->whereBetween('l.tanggal_laporan', [$start, $end])
            ->where('i.status_indikator', 'aktif');

        if ($kategoriIndikator) {
            $query->whereRaw("LOWER(l.kategori_indikator) LIKE ?", ['%' . strtolower($kategoriIndikator) . '%']);
        }

        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('l.unit_id', $user->unit_id);
        }

        $rekap = $query
            ->select(
                'l.indikator_id',
                'l.unit_id',
                DB::raw('ROUND(AVG(l.nilai),2) as nilai_rekap'),
                DB::raw('ROUND(AVG(l.nilai_validator),2) as nilai_validator'),
                DB::raw('MAX(l.status_laporan) as status_laporan')
            )
            ->groupBy('l.indikator_id', 'l.unit_id')
            ->get()
            ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);

        return $rekap;
    }


    public function store(Request $request)
    {
        // Ambil indikator dulu (WAJIB di atas)
        $indikatorFull = DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->first();

        if (!$indikatorFull) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        $request->validate([
            'indikator_id' => 'required|exists:tbl_indikator,id',
            'tanggal_laporan' => 'required|date',
            'numerator' => 'required|numeric|min:0|lte:denominator',
            'denominator' => 'required|numeric|min:1',
            'file_laporan' => 'required|file|max:5120',
            'unit_id' => 'sometimes|exists:tbl_unit,id',
        ]);

        $periode = $this->getPeriodeAktif();
        if (!$periode) {
            return back()->with('error', 'Periode mutu aktif belum tersedia');
        }

        $tanggalLaporan = Carbon::parse($request->tanggal_laporan)->startOfDay();
        $now = now()->startOfDay();

        $periodeMulai = Carbon::parse($periode->tanggal_mulai)->startOfDay();
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai)->endOfDay();

        if ($tanggalLaporan->lt($periodeMulai) || $tanggalLaporan->gt($periodeSelesai)) {
            return back()->with('error', 'Tanggal laporan harus berada dalam periode mutu aktif');
        }

        $deadline = (int) $periode->deadline;

        $batasPengisian = $tanggalLaporan
            ->copy()
            ->addMonth()
            ->day(min($deadline, $tanggalLaporan->copy()->addMonth()->daysInMonth))
            ->endOfDay();

        // if ($now->gt($batasPengisian)) {
        // return back()->with('error', 'Batas waktu pengisian laporan telah lewat');
        // }

        $indikator = DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->where('i.id', $request->indikator_id)
            ->select('k.kategori_indikator', 'k.kategori_id')
            ->first();

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        $kategoriLower = strtolower($indikator->kategori_indikator);

        if (
            str_contains($kategoriLower, 'prioritas unit') ||
            str_contains($kategoriLower, 'prioritas rs')
        ) {

            $request->validate([
                'unit_id' => 'required|exists:tbl_unit,id',
            ]);
        }

        $nilai = ($request->numerator / $request->denominator) * 100;

        $tercapai = $this->hitungPencapaian(
            $nilai,
            $indikatorFull->arah_target,
            $indikatorFull->target_indikator,
            $indikatorFull->target_min,
            $indikatorFull->target_max
        );

        $pencapaian = $tercapai ? 'tercapai' : 'tidak-tercapai';

        $exists = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $request->indikator_id)
            ->whereDate('tanggal_laporan', $tanggalLaporan)
            ->when(
                str_contains($kategoriLower, 'prioritas unit') ||
                str_contains($kategoriLower, 'prioritas rs'),
                fn($q) => $q->where('unit_id', $request->unit_id)
            )
            ->exists();

        if ($exists) {
            return back()->with('error', 'Data laporan untuk tanggal tersebut sudah ada');
        }

        DB::table('tbl_laporan_dan_analis')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id ?? null,
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai' => round($nilai, 2),
            'target_saat_input' => $indikatorFull->target_indikator,
            'target_min_saat_input' => $indikatorFull->target_min,
            'target_max_saat_input' => $indikatorFull->target_max,
            'arah_target_saat_input' => $indikatorFull->arah_target,
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $request->tanggal_laporan,
            'file_laporan' => $request->file('file_laporan')
                ->store('laporan_indikator', 'public'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('laporan-analis.index', [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'kategori_indikator' => $request->kategori_indikator,
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
        ])->with('success', 'Data laporan berhasil disimpan');
    }

    public function getDetail($id)
    {
        $data = DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $data->id,
            'indikator_id' => $data->indikator_id ?? null,
            'tanggal_pengisian' => $data->created_at,
            'unit_id' => $data->unit_id ?? null,
            'numerator' => $data->numerator ?? 0,
            'denominator' => $data->denominator ?? 0,
            'nilai' => $data->nilai ?? 0,
            'pencapaian' => $data->pencapaian ?? null,
            'tanggal_laporan' => $data->tanggal_laporan ?? null,
            'file_laporan' => $data->file_laporan ?? null,
            'status_laporan' => $data->status_laporan ?? null,
            'kategori_indikator' => $data->kategori_indikator ?? null,
        ]);
    }



    private function getPeriodeAktif()
    {
        return cache()->remember('periode_aktif', 60, function () {
            return DB::table('tbl_periode')
                ->where('status', 'aktif')
                ->first();
        });
    }

    public function show($id)
    {
        $data = DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }


    public function update(Request $request, $id)
    {

        $data = DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return back()->with('error', 'Data laporan tidak ditemukan');
        }

        $indikatorFull = DB::table('tbl_indikator')
            ->where('id', $data->indikator_id)
            ->first();

        $request->validate([
            'numerator' => 'required|numeric|min:0|lte:denominator',
            'denominator' => 'required|numeric|min:1',
            'file_laporan' => 'nullable|file|max:5120',
        ]);


        $periode = $this->getPeriodeAktif();

        $deadline = (int) $periode->deadline;

        $tanggalLaporan = Carbon::parse($data->tanggal_laporan)->startOfDay();
        $batasPengisian = $tanggalLaporan
            ->copy()
            ->addMonth()
            ->day(min($deadline, $tanggalLaporan->copy()->addMonth()->daysInMonth))
            ->endOfDay();

        // if (now()->gt($batasPengisian)) {
        //     return back()->with('error', 'Data tidak bisa diubah karena melewati batas deadline');
        // }

        $nilai = ($request->numerator / $request->denominator) * 100;

        $tercapai = $this->hitungPencapaian(
            $nilai,
            $data->arah_target_saat_input,
            $data->target_saat_input,
            $data->target_min_saat_input,
            $data->target_max_saat_input
        );

        $pencapaian = $tercapai ? 'tercapai' : 'tidak-tercapai';

        $updateData = [
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai' => round($nilai, 2),
            'pencapaian' => $pencapaian,
            'updated_at' => now(),
        ];

        if ($request->hasFile('file_laporan')) {

            if ($data->file_laporan) {
                Storage::disk('public')->delete($data->file_laporan);
            }

            $updateData['file_laporan'] = $request
                ->file('file_laporan')
                ->store('laporan_indikator', 'public');
        }

        DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->update($updateData);

        return back()->with('success', 'Data laporan berhasil diperbarui');
    }

    private function hitungPencapaian($nilai, $arah, $target, $min, $max)
    {
        switch ($arah) {

            case 'lebih_besar':
                return $nilai >= $target;

            case 'lebih_kecil':
                return $nilai <= $target;

            case 'range':
                return $nilai >= $min && $nilai <= $max;

            default:
                return false;
        }
    }
}