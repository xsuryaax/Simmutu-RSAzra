<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Storage;

class ValidatorDataController extends Controller
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

        // Default indikator pertama
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

                $query = DB::table('tbl_laporan_validator')
                    ->select(
                        'id',
                        'tanggal_laporan',
                        'numerator',
                        'denominator',
                        'nilai_validator',
                        'indikator_id',
                        'unit_id',
                        'kategori_indikator'
                    )
                    ->where('indikator_id', $selectedIndikatorId)
                    ->whereMonth('tanggal_laporan', $bulan)
                    ->whereYear('tanggal_laporan', $tahun);

                // filter unit jika ada
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

        return view('menu.IndikatorMutu.laporan-validator.index', [
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
                'k.kategori_indikator'
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
            ->orderBy('i.id')
            ->get();
    }

    private function getRekapBulanan($user, $bulan, $tahun, $kategoriIndikator = null)
    {
        $query = DB::table('tbl_laporan_validator as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->where('i.status_indikator', 'aktif');

        // Filter berdasarkan kategori indikator dari kamus indikator
        if ($kategoriIndikator) {
            $query->whereRaw(
                "LOWER(k.kategori_indikator) LIKE ?",
                ['%' . strtolower($kategoriIndikator) . '%']
            );
        }

        // Filter unit jika bukan admin/unit khusus
        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('l.unit_id', $user->unit_id);
        }

        $rekap = $query
            ->select(
                'l.indikator_id',
                'l.unit_id',
                DB::raw('SUM(l.nilai_validator) as total_nilai'),
                DB::raw('COUNT(*) as jumlah_data')
            )
            ->groupBy('l.indikator_id', 'l.unit_id')
            ->get()
            ->map(function ($item) {

                $nilai = 0;
                if ($item->jumlah_data > 0) {
                    // Rata-rata semua nilai validator
                    $nilai = ($item->total_nilai / $item->jumlah_data);
                }

                $item->nilai_rekap = round($nilai, 2);
                return $item;
            })
            ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);

        return $rekap;
    }



    public function store(Request $request)
    {
        $request->validate([
            'tanggal_laporan' => 'required|date',
            'indikator_id' => 'required',
            'unit_id' => 'required',
            'numerator' => 'required|numeric',
            'denominator' => 'required|numeric',
            'file_laporan' => 'nullable|file|mimes:xlsx,xls,pdf',
        ]);

        DB::beginTransaction();

        try {

            // Hitung nilai validator
            $nilaiValidator = 0;
            if ($request->denominator > 0) {
                $nilaiValidator = ($request->numerator / $request->denominator) * 100;
            }

            $tanggal = Carbon::parse($request->tanggal_laporan);

            $laporanAnalis = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereMonth('tanggal_laporan', $tanggal->month)
                ->whereYear('tanggal_laporan', $tanggal->year)
                ->first();


            if (!$laporanAnalis) {
                return back()->with('error', 'Data analis belum tersedia');
            }

            // Hitung persentase kesesuaian
            $persentase = 0;
            if ($laporanAnalis->nilai > 0) {
                $persentase = ($nilaiValidator / $laporanAnalis->nilai) * 100;
            }

            $statusValidasi = $persentase >= 90 ? 'valid' : 'tidak-valid';

            // Upload file jika ada
            $filePath = null;
            if ($request->hasFile('file_laporan')) {
                $filePath = $request->file('file_laporan')
                    ->store('laporan_indikator', 'public');
            }

            $target = DB::table('tbl_indikator')
                ->where('id', $request->indikator_id)
                ->value('target_indikator');

            $pencapaian = $nilaiValidator >= $target ? 'tercapai' : 'tidak-tercapai';


            /*
            |-----------------------------------------
            | 1. INSERT ke tabel VALIDATOR
            |-----------------------------------------
            */
            DB::table('tbl_laporan_validator')->insert([
                'laporan_analis_id' => $laporanAnalis->id,
                'tanggal_laporan' => $request->tanggal_laporan,
                'indikator_id' => $request->indikator_id,
                'unit_id' => $request->unit_id,
                'numerator' => $request->numerator,
                'denominator' => $request->denominator,
                'nilai_validator' => $nilaiValidator,
                'pencapaian' => $pencapaian,
                'status_laporan' => $statusValidasi,
                'file_laporan' => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            /*
            |-----------------------------------------
            | 2. UPDATE tabel ANALIS (hanya 2 kolom)
            |-----------------------------------------
            */
            DB::table('tbl_laporan_dan_analis')
                ->where('id', $laporanAnalis->id)
                ->update([
                    'nilai_validator' => $nilaiValidator,
                    'status_laporan' => $statusValidasi,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return back()->with('success', 'Data berhasil divalidasi');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function detail($id)
    {
        $data = DB::table('tbl_laporan_validator')
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
            'nilai_validator' => $data->nilai_validator ?? 0,
            'pencapaian' => $data->pencapaian ?? null,
            'tanggal_laporan' => $data->tanggal_laporan ?? null,
            'file_laporan' => $data->file_laporan ?? null,
            'status_laporan' => $data->status_laporan ?? null,
            'kategori_indikator' => $data->kategori_indikator ?? null,
        ]);
    }



    private function getPeriodeAktif()
    {
        return DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();
    }


    public function show($id)
    {
        $data = DB::table('tbl_laporan_validator')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'file_laporan' => 'nullable|file|max:5120',
        ]);

        // Ambil data laporan validator
        $data = DB::table('tbl_laporan_validator')->where('id', $id)->first();

        if (!$data) {
            return back()->with('error', 'Data laporan tidak ditemukan');
        }

        // Hitung nilai baru
        $nilai = ($request->numerator / $request->denominator) * 100;

        // Ambil target indikator
        $target = DB::table('tbl_indikator')
            ->where('id', $data->indikator_id)
            ->value('target_indikator');

        // Tentukan pencapaian
        $pencapaian = $nilai >= $target ? 'tercapai' : 'tidak-tercapai';

        // Hitung status validasi terhadap laporan analis
        $laporanAnalis = DB::table('tbl_laporan_dan_analis')
            ->where('id', $data->laporan_analis_id)
            ->first();

        $statusValidasi = 'tidak-valid';
        if ($laporanAnalis && $laporanAnalis->nilai > 0) {
            $persentase = ($nilai / $laporanAnalis->nilai) * 100;
            $statusValidasi = $persentase >= 90 ? 'valid' : 'tidak-valid';
        }

        $updateData = [
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai_validator' => round($nilai, 2),
            'pencapaian' => $pencapaian,
            'status_laporan' => $statusValidasi,
            'updated_at' => now(),
        ];

        // Jika upload file baru
        if ($request->hasFile('file_laporan')) {
            if ($data->file_laporan) {
                Storage::disk('public')->delete($data->file_laporan);
            }
            $updateData['file_laporan'] = $request->file('file_laporan')->store('laporan_indikator', 'public');
        }

        // Update validator
        DB::table('tbl_laporan_validator')->where('id', $id)->update($updateData);

        // Update laporan analis
        if ($data->laporan_analis_id) {
            DB::table('tbl_laporan_dan_analis')
                ->where('id', $data->laporan_analis_id)
                ->update([
                    'nilai_validator' => round($nilai, 2),
                    'status_laporan' => $statusValidasi,
                    'updated_at' => now(),
                ]);
        }

        return back()->with('success', 'Data laporan berhasil diperbarui');
    }
}
