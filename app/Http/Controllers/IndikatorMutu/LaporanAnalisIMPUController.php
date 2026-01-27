<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAnalisIMPUController extends Controller
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

        $jenisIndikator = $request->jenis_indikator ?? 'prioritas unit';

        $indikators = $this->getIndikator($user, $jenisIndikator);
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun, $jenisIndikator);
        $laporan = $this->getLaporan($user, $periodeAktif, $jenisIndikator);

        $jenisIndikatorList = DB::table('tbl_kamus_indikator')
            ->select('jenis_indikator')
            ->whereNotNull('jenis_indikator')
            ->distinct()
            ->orderBy('jenis_indikator')
            ->pluck('jenis_indikator');

        return view('menu.IndikatorMutu.laporan-analis-impu.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'laporanHarian' => $laporan['grouped'],
            'paginate' => $laporan['paginator'],
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
            'jenisIndikatorList' => $jenisIndikatorList,
            'jenisIndikator' => $jenisIndikator,
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

    private function getLaporan($user, $periode, $jenisIndikator = null)
    {
        $jenisList = $jenisIndikator
            ? [strtolower($jenisIndikator)]
            : ['nasional', 'prioritas unit', 'prioritas rs'];

        $laporanAll = collect();

        foreach ($jenisList as $jenis) {
            $table = $this->getTabelLaporan($jenis);
            if (!$table)
                continue;

            $query = DB::table("$table as l")
                ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
                ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
                ->whereBetween('l.tanggal_laporan', [$periode->tanggal_mulai, $periode->tanggal_selesai])
                ->when(
                    in_array($jenis, ['prioritas unit', 'prioritas rs'])
                    && !in_array($user->unit_id, [1, 2]),
                    fn($q) => $q->where('l.unit_id', $user->unit_id)
                )
                ->orderBy('l.indikator_id')
                ->orderBy('l.tanggal_laporan', 'asc');

            $laporanJenis = $query->get();
            $laporanAll = $laporanAll->merge($laporanJenis);
        }

        return [
            'paginator' => $laporanAll,
            'grouped' => $laporanAll->groupBy('indikator_id'),
        ];
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
            'jenis_indikator' => 'required|string',
        ]);

        $periode = $this->getPeriodeAktif();
        if (!$periode) {
            return back()->with('error', 'Periode mutu aktif belum tersedia');
        }

        $tanggal = Carbon::parse($request->tanggal_laporan);
        if ($tanggal->lt($periode->tanggal_mulai) || $tanggal->gt($periode->tanggal_selesai)) {
            return back()->with('error', 'Tanggal laporan di luar periode mutu aktif');
        }

        $jenis = strtolower(trim($request->jenis_indikator));

        $tableMap = [
            'prioritas unit' => 'tbl_laporan_dan_analis_unit',
            'prioritas rs' => 'tbl_laporan_dan_analis_imprs',
            'nasional' => 'tbl_laporan_dan_analis_nasional',
        ];

        if (!isset($tableMap[$jenis])) {
            return back()->with('error', 'Jenis indikator tidak valid');
        }

        $tableTujuan = $tableMap[$jenis];

        if (in_array($jenis, ['prioritas unit', 'prioritas rs'])) {
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

        if (in_array($jenis, ['prioritas unit', 'prioritas rs'])) {
            $dataInsert['unit_id'] = $request->unit_id;
        }

        if ($jenis === 'prioritas rs') {
            $dataInsert['unit_id'] = $request->unit_id;

            $kategoriId = DB::table('tbl_indikator as i')
                ->leftJoin('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
                ->where('i.id', $request->indikator_id)
                ->value('k.kategori_id');

            $dataInsert['kategori_id'] = $kategoriId;
        }

        DB::table($tableTujuan)->insert($dataInsert);

        return back()->with('success', 'Data berhasil disimpan');
    }

    private function getPeriodeAktif()
    {
        return DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();
    }

    private function getTabelLaporan($jenis)
    {
        return match ($jenis) {
            'prioritas unit' => 'tbl_laporan_dan_analis_unit',
            'prioritas rs' => 'tbl_laporan_dan_analis_imprs',
            'nasional' => 'tbl_laporan_dan_analis_nasional',
            default => null,
        };
    }
}
