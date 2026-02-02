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
        $jenisIndikator = $request->filled('jenis_indikator')
            ? $request->jenis_indikator
            : null;

        $indikators = $this->getIndikator($user, $jenisIndikator);
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun, $jenisIndikator);

        $jenisIndikatorList = DB::table('tbl_kamus_indikator')
            ->select('jenis_indikator')
            ->whereNotNull('jenis_indikator')
            ->distinct()
            ->orderBy('jenis_indikator')
            ->pluck('jenis_indikator');

        // ✅ BARU: Jika tidak ada indikator yang dipilih, ambil indikator pertama
        $selectedIndikatorId = $request->indikator_id;
        $selectedUnitId = $request->unit_id;

        // Jika tidak ada indikator yang dipilih dan ada indikator di list
        if (!$selectedIndikatorId && $indikators->isNotEmpty()) {
            $firstIndikator = $indikators->first();
            $selectedIndikatorId = $firstIndikator->id;
            $selectedUnitId = $firstIndikator->unit_id;
        }

        // Data kalender
        $kalenderData = null;
        $selectedIndikator = null;

        if ($selectedIndikatorId) {
            $selectedIndikator = $indikators->firstWhere('id', $selectedIndikatorId);

            if ($selectedIndikator) {
                $jenisIndikatorKalender = strtolower($selectedIndikator->jenis_indikator);
                $table = $this->getTabelLaporan($jenisIndikatorKalender);

                if ($table) {
                    $query = DB::table($table)
                        ->select('tanggal_laporan', 'numerator', 'denominator', 'nilai', 'id')
                        ->where('indikator_id', $selectedIndikatorId)
                        ->whereMonth('tanggal_laporan', $bulan)
                        ->whereYear('tanggal_laporan', $tahun);

                    if (in_array($jenisIndikatorKalender, ['prioritas unit', 'prioritas rs'])) {
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
        }

        return view('menu.IndikatorMutu.laporan-analis.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
            'jenisIndikatorList' => $jenisIndikatorList,
            'jenisIndikator' => $jenisIndikator,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kalenderData' => $kalenderData,
            'selectedIndikator' => $selectedIndikator,
            'selectedIndikatorId' => $selectedIndikatorId,
            'selectedUnitId' => $selectedUnitId,
        ]);
    }

    private function getIndikator($user, $jenisIndikator = null)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data as f', 'f.id', '=', 'k.frekuensi_pengumpulan_data_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->join('tbl_periode as p', fn($join) => $join->where('p.status', 'aktif'))
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.unit_id',
                'i.target_indikator',
                'p.tanggal_mulai',
                'p.tanggal_selesai',
                'f.nama_frekuensi_pengumpulan_data',
                'u.nama_unit',
                'k.jenis_indikator'
            )
            ->where('i.status_indikator', 'aktif')
            ->when($jenisIndikator, function ($q) use ($jenisIndikator) {
                $q->whereRaw(
                    "LOWER(k.jenis_indikator) LIKE ?",
                    ['%' . strtolower($jenisIndikator) . '%']
                );
            })
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )
            ->orderBy('i.id')
            ->get();
    }

    private function getRekapBulanan($user, $bulan, $tahun, $jenisIndikator = null)
    {
        $rekap = collect();

        $jenisList = $jenisIndikator
            ? [strtolower($jenisIndikator)]
            : ['nasional', 'prioritas unit', 'prioritas rs'];

        foreach ($jenisList as $jenis) {
            $table = $this->getTabelLaporan($jenis);
            if (!$table)
                continue;

            if ($jenis === 'nasional') {
                $rekapJenis = DB::table("$table as l")
                    ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
                    ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
                    ->whereMonth('l.tanggal_laporan', $bulan)
                    ->whereYear('l.tanggal_laporan', $tahun)
                    ->where('i.status_indikator', 'aktif')
                    ->whereRaw("LOWER(k.jenis_indikator) LIKE ?", ['%nasional%'])
                    ->select(
                        'l.indikator_id',
                        'i.unit_id',
                        DB::raw('ROUND(AVG(l.nilai)::numeric,2) as nilai_rekap')
                    )
                    ->groupBy('l.indikator_id', 'i.unit_id')
                    ->get()
                    ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);

                $rekap = $rekap->merge($rekapJenis);
            } else {
                $query = DB::table("$table as l")
                    ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
                    ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
                    ->whereMonth('l.tanggal_laporan', $bulan)
                    ->whereYear('l.tanggal_laporan', $tahun)
                    ->where('i.status_indikator', 'aktif')
                    ->whereRaw("LOWER(k.jenis_indikator) LIKE ?", ['%' . $jenis . '%'])
                    ->when(
                        !in_array($user->unit_id, [1, 2]),
                        fn($q) => $q->where('l.unit_id', $user->unit_id)
                    )
                    ->select(
                        'l.indikator_id',
                        'l.unit_id',
                        DB::raw('ROUND(AVG(l.nilai)::numeric,2) as nilai_rekap')
                    )
                    ->groupBy('l.indikator_id', 'l.unit_id');

                $rekapJenis = $query->get()
                    ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);

                $rekap = $rekap->merge($rekapJenis);
            }
        }

        return $rekap;
    }

    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|exists:tbl_indikator,id',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'tanggal_laporan' => 'required|date',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $periode = $this->getPeriodeAktif();
        if (!$periode) {
            return back()->with('error', 'Periode mutu aktif belum tersedia');
        }

        $tanggal = Carbon::parse($request->tanggal_laporan);
        if ($tanggal->lt($periode->tanggal_mulai) || $tanggal->gt($periode->tanggal_selesai)) {
            return back()->with('error', 'Tanggal laporan di luar periode mutu aktif');
        }

        // ✅ PERBAIKAN: Ambil jenis indikator dari database
        $indikator = DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->where('i.id', $request->indikator_id)
            ->select('k.jenis_indikator', 'k.kategori_id')
            ->first();

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        $jenis = strtolower(trim($indikator->jenis_indikator));

        $tableMap = [
            'prioritas unit' => 'tbl_laporan_dan_analis_unit',
            'prioritas rs' => 'tbl_laporan_dan_analis_imprs',
            'nasional' => 'tbl_laporan_dan_analis_nasional',
        ];

        // Cari tabel yang sesuai menggunakan str_contains
        $tableTujuan = null;
        foreach ($tableMap as $key => $table) {
            if (str_contains($jenis, $key)) {
                $tableTujuan = $table;
                break;
            }
        }

        if (!$tableTujuan) {
            return back()->with('error', 'Jenis indikator tidak valid');
        }

        // Validasi unit_id untuk jenis tertentu
        if (str_contains($jenis, 'prioritas unit') || str_contains($jenis, 'prioritas rs')) {
            $request->validate([
                'unit_id' => 'required|exists:tbl_unit,id',
            ]);
        }

        $nilai = ($request->numerator / $request->denominator) * 100;
        $target = DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->value('target_indikator');

        $pencapaian = $nilai >= $target ? 'tercapai' : 'tidak-tercapai';

        $dataInsert = [
            'indikator_id' => $request->indikator_id,
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai' => round($nilai, 2),
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $tanggal,
            'file_laporan' => $request->file('file_laporan')->store('laporan_indikator', 'public'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (str_contains($jenis, 'prioritas unit') || str_contains($jenis, 'prioritas rs')) {
            $dataInsert['unit_id'] = $request->unit_id;
        }

        if (str_contains($jenis, 'prioritas rs')) {
            $dataInsert['kategori_id'] = $indikator->kategori_id;
        }

        DB::table($tableTujuan)->insert($dataInsert);

        // ✅ Redirect tanpa jenis_indikator agar filter tetap kosong
        return redirect()->route('laporan-analis.index', [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
        ])->with('success', 'Data berhasil disimpan');
    }

    public function getDetail($id)
    {
        // Cari di semua tabel laporan
        $tables = [
            'tbl_laporan_dan_analis_unit',
            'tbl_laporan_dan_analis_imprs',
            'tbl_laporan_dan_analis_nasional'
        ];

        foreach ($tables as $table) {
            $data = DB::table($table)
                ->where('id', $id)
                ->first();

            if ($data) {
                return response()->json([
                    'id' => $data->id,
                    'indikator_id' => $data->indikator_id,
                    'tanggal_pengisian' => $data->created_at,
                    'unit_id' => $data->unit_id ?? null,
                    'numerator' => $data->numerator,
                    'denominator' => $data->denominator,
                    'nilai' => $data->nilai,
                    'pencapaian' => $data->pencapaian,
                    'tanggal_laporan' => $data->tanggal_laporan,
                    'file_laporan' => $data->file_laporan,
                    'table' => $table
                ]);
            }
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    private function getPeriodeAktif()
    {
        return DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();
    }

    private function getTabelLaporan($jenis)
    {
        if (!$jenis)
            return null;

        $jenisLower = strtolower(trim($jenis));

        if (str_contains($jenisLower, 'prioritas unit')) {
            return 'tbl_laporan_dan_analis_unit';
        } elseif (str_contains($jenisLower, 'prioritas rs')) {
            return 'tbl_laporan_dan_analis_imprs';
        } elseif (str_contains($jenisLower, 'nasional')) {
            return 'tbl_laporan_dan_analis_nasional';
        }

        return null;
    }

    public function show($id)
    {
        $data = DB::table('laporan_indikator')
            ->where('id', $id)
            ->first();

        return response()->json($data);
    }
}