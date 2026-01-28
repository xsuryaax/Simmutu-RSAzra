<?php

namespace App\Http\Controllers;

use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        // 🔑 AMBIL SEKALI
        $indikators = $this->getIndikators();

        if (in_array($roleId, [1, 2])) {
            $indikatorsForChart = $indikators;
        } else {
            $indikatorsForChart = $indikators->where('unit_id', $user->unit_id);
        }

        $data = [
            'roleId' => $roleId,
            'pdsaTotal' => $this->getTotalPdsa(),
            'pdsaList' => collect(),

            'totalIndikator' => $indikators->count(),
            'indikators' => $indikators,
            'years' => $this->getYears(),

            ...$this->getStatistikUnit(),
            ...$this->getRecentIsi(),

            'indikatorsForChart' => $indikatorsForChart,
            'allDataJson' => json_encode($this->getUserChartData($indikators)),
            'indikatorNasionalList' => $this->getIndikatorNasional(),
            'nasionalYears' => $this->getNasionalYears(),
            'nasionalChartJson' => $this->getNasionalChartData(),
            'chartIMPRSJson' => $this->getIMPRSChartData(),
            'chartIMPRSYears' => $this->getYears(),
        ];

        // ambil PDSA notification
        $pdsaData = in_array($roleId, [1, 2])
            ? $this->getPdsaNotification() // admin → semua unit
            : $this->getPdsaNotification($user->unit_id); // user biasa → unit sendiri

        $data['pdsaTotal'] = $pdsaData['pdsaTotal'];
        $data['pdsaList'] = $pdsaData['pdsaList'];


        // tetap untuk admin tambah data tambahan
        if (in_array($roleId, [1, 2])) {
            $data['unitIndikatorMap'] = $this->getUnitIndikatorMap();
            $data['divisionData'] = $this->getDivisionData($indikators);
        }


        return view('admin.dashboard', $data);
    }


    private function getBaseData(): array
    {
        return [
            'totalIndikator' => DB::table('tbl_indikator')->count(),
            'indikators' => $this->getIndikators(),
            'years' => $this->getYears(),
        ];
    }

    private function getIndikators()
    {
        return DB::table('tbl_indikator')
            ->leftJoin('tbl_kamus_indikator', 'tbl_kamus_indikator.id', '=', 'tbl_indikator.kamus_indikator_id')
            ->select(
                'tbl_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.target_indikator',
                'tbl_indikator.unit_id',
                'tbl_kamus_indikator.frekuensi_pengumpulan_data_id as frekuensi_id'
            )
            ->orderBy('nama_indikator')
            ->where('tbl_kamus_indikator.jenis_indikator', 'LIKE', '%Prioritas Unit%')
            ->get();
    }

    private function getUnitIndikatorMap()
    {
        return DB::table('tbl_unit as u')
            ->join('tbl_indikator as i', 'i.unit_id', '=', 'u.id')
            ->select(
                'u.nama_unit',
                'i.id as indikator_id',
                'i.nama_indikator'
            )
            ->orderBy('u.nama_unit')
            ->orderBy('i.nama_indikator')
            ->get()
            ->groupBy('nama_unit');
    }

    private function getYears()
    {
        return DB::table('tbl_laporan_dan_analis_unit')
            ->selectRaw('DISTINCT EXTRACT(YEAR FROM tanggal_laporan) as tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');
    }

    private function getStatistikUnit(): array
    {
        $now = now();
        $bulanWajib = $now->copy()->subMonth()->month;
        $tahunWajib = $now->copy()->subMonth()->year;

        $units = DB::table('tbl_unit')->get();

        $semuaIndikator = DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as ki', 'ki.id', '=', 'i.kamus_indikator_id')
            ->where('ki.jenis_indikator', 'LIKE', '%Prioritas Unit%')
            ->select('i.id', 'i.nama_indikator', 'i.unit_id')
            ->get()
            ->groupBy('unit_id');

        $totalTerisiIds = DB::table('tbl_laporan_dan_analis_unit')
            ->whereMonth('tanggal_laporan', $bulanWajib)
            ->whereYear('tanggal_laporan', $tahunWajib)
            ->pluck('indikator_id')
            ->toArray();

        $unitsSudah = [];
        $unitsBelum = [];

        // Inisialisasi counter untuk Card
        $totalIndikatorSudah = 0;
        $totalIndikatorBelum = 0;

        foreach ($units as $unit) {
            $indikators = $semuaIndikator->get($unit->id, collect());
            if ($indikators->isEmpty()) continue;

            $sudah = [];
            $belum = [];

            foreach ($indikators as $ind) {
                if (in_array($ind->id, $totalTerisiIds)) {
                    $sudah[] = $ind->nama_indikator;
                    $totalIndikatorSudah++; // Tambah total akumulasi
                } else {
                    $belum[] = $ind->nama_indikator;
                    $totalIndikatorBelum++; // Tambah total akumulasi
                }
            }

            // Simpan data per unit untuk Modal
            if (count($sudah) > 0) {
                $uSudah = clone $unit;
                $uSudah->list_sudah = $sudah;
                $uSudah->total_indikator = count($indikators);
                $unitsSudah[] = $uSudah;
            }

            if (count($belum) > 0) {
                $uBelum = clone $unit;
                $uBelum->list_belum = $belum;
                $uBelum->list_sudah = $sudah;
                $uBelum->total_indikator = count($indikators);
                $unitsBelum[] = $uBelum;
            }
        }

        return [
            'totalUnit' => count($units),
            'totalIndikatorSudah' => $totalIndikatorSudah, // Untuk Card
            'totalIndikatorBelum' => $totalIndikatorBelum, // Untuk Card
            'unitsSudah' => $unitsSudah, // Untuk Modal
            'unitsBelum' => $unitsBelum, // Untuk Modal
        ];
    }

    private function getRecentIsi(): array
    {
        return [
            'recentIsi' => DB::table('tbl_laporan_dan_analis_unit as l')
                ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
                ->orderByDesc('l.tanggal_laporan')
                ->limit(5)
                ->get()
        ];
    }

    private function getUserChartData($indikators): array
    {
        $user = Auth::user();
        $years = $this->getYears();
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        if (!in_array($user->role_id, [1, 2])) {
            $indikators = $indikators->where('unit_id', $user->unit_id);
        }

        $data = [];

        foreach ($indikators as $ind) {
            foreach ($years as $tahun) {

                $data[$ind->id][$tahun] = $this->buildIndikatorData(
                    $ind,
                    $tahun,
                    $labels,
                    in_array($user->role_id, [1, 2]) ? null : $user->unit_id
                );
            }
        }

        return $data;
    }

    private function getDivisionData($indikators): array
    {
        $units = DB::table('tbl_unit')->orderBy('nama_unit')->get();
        $years = $this->getYears();
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $divisionData = [];

        foreach ($years as $tahun) {
            $divisionData[$tahun]['labels'] = $labels;

            foreach ($units as $u) {
                $divisionData[$tahun][$u->nama_unit]['indikators'] = [];

                foreach ($indikators->where('unit_id', $u->id) as $ind) {
                    $divisionData[$tahun][$u->nama_unit]['indikators'][$ind->id] = array_merge(
                        [
                            'nama_indikator' => $ind->nama_indikator
                        ],
                        $this->buildIndikatorData($ind, $tahun, $labels, $u->id)
                    );
                }
            }
        }


        return $divisionData;
    }

    private function buildIndikatorData($ind, int $tahun, array $labels, $unitId = null): array
    {
        $hasil = array_fill(1, 12, null);
        $target = array_fill(1, 12, $ind->target_indikator);

        $query = DB::table('tbl_laporan_dan_analis_unit')
            ->where('indikator_id', $ind->id)
            ->whereYear('tanggal_laporan', $tahun);

        if ($unitId) {
            $query->where('unit_id', $unitId);
        }

        if (in_array($ind->frekuensi_id, [1, 2])) {
            $query = $query
                ->selectRaw('EXTRACT(MONTH FROM tanggal_laporan) as bulan, SUM(nilai) as total, COUNT(*) as jumlah')
                ->groupBy('bulan')
                ->get();

            foreach ($query as $row) {
                $hasil[$row->bulan] = round($row->total / $row->jumlah, 2);
            }
        } else {
            $query = $query
                ->selectRaw('EXTRACT(MONTH FROM tanggal_laporan) as bulan, nilai')
                ->get();

            foreach ($query as $row) {
                $hasil[$row->bulan] = round($row->nilai, 2);
            }
        }

        return [
            'labels' => $labels,
            'hasil' => array_values($hasil),
            'target' => array_values($target),
        ];
    }

    private function getIndikatorNasional()
    {
        return DB::table('tbl_indikator')
            ->select(
                'id',
                'nama_indikator',
                'target_indikator'
            )
            ->whereIn('id', function ($query) {
                $query->select('indikator_id')
                    ->from('tbl_laporan_dan_analis_nasional');
            })
            ->orderBy('nama_indikator')
            ->get();
    }

    private function getNasionalYears()
    {
        return DB::table('tbl_laporan_dan_analis_nasional')
            ->selectRaw('DISTINCT EXTRACT(YEAR FROM tanggal_laporan) as tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');
    }

    private function getNasionalChartData(): array
    {
        $indikators = $this->getIndikatorNasional();
        $years = $this->getNasionalYears();
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $data = [];

        foreach ($indikators as $ind) {
            foreach ($years as $tahun) {
                $data[$ind->id][$tahun] = $this->buildNasionalIndikatorData(
                    $ind,
                    $tahun,
                    $labels
                );
            }
        }

        return $data;
    }

    private function buildNasionalIndikatorData($ind, int $tahun, array $labels): array
    {
        $hasil = array_fill(1, 12, null);
        $target = array_fill(1, 12, $ind->target_indikator);

        $rows = DB::table('tbl_laporan_dan_analis_nasional')
            ->where('indikator_id', $ind->id)
            ->whereYear('tanggal_laporan', $tahun)
            ->selectRaw('
            EXTRACT(MONTH FROM tanggal_laporan) as bulan,
            ROUND(AVG(nilai), 2) as nilai
        ')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        foreach ($rows as $row) {
            $hasil[$row->bulan] = $row->nilai;
        }

        return [
            'labels' => $labels,
            'hasil' => array_values($hasil),   // capaian
            'target' => array_values($target), // target nasional
        ];
    }

    private function getIMPRSChartData(): array
    {

        $indikators = DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as km', 'km.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_kategori_imprs as k', 'k.id', '=', 'km.kategori_id')
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.target_indikator',
                'km.jenis_indikator',
                'km.kategori_id',
                'k.nama_kategori_imprs'
            )
            ->where('km.jenis_indikator', 'LIKE', '%Prioritas RS%')

            ->orderBy('i.nama_indikator')
            ->get();

        $years = $this->getYears();
        $data = [];

        foreach ($indikators as $ind) {

            $kategoriKey = $ind->nama_kategori_imprs ?? 'Tanpa Kategori';

            if (!isset($data[$kategoriKey])) {
                $data[$kategoriKey] = [
                    'indikators' => []
                ];
            }


            $data[$kategoriKey]['indikators'][$ind->id] = [
                'judul' => $ind->nama_indikator,
                'data' => []
            ];

            foreach ($years as $tahun) {
                $data[$kategoriKey]['indikators'][$ind->id]['data'][$tahun]
                    = $this->buildImprsData($ind, $tahun);
            }
        }
        return $data;
    }

    private function buildImprsData($imprs, int $tahun): array
    {
        $target = array_fill(0, 12, (float) $imprs->target_indikator);

        $hasilDB = DB::table('tbl_laporan_dan_analis_imprs')
            ->where('indikator_id', $imprs->id)
            ->whereYear('tanggal_laporan', $tahun)
            ->selectRaw('
            EXTRACT(MONTH FROM tanggal_laporan) AS bulan,
            ROUND(AVG(nilai), 2) AS nilai
        ')
            ->groupByRaw('EXTRACT(MONTH FROM tanggal_laporan)')
            ->pluck('nilai', 'bulan')
            ->toArray();

        $hasil = [];
        for ($i = 1; $i <= 12; $i++) {
            $hasil[] = $hasilDB[$i] ?? null;
        }

        return [
            'target' => $target,
            'hasil' => $hasil
        ];
    }

    private function getPdsaNotification($unitId = null): array
    {
        $query = DB::table('tbl_pdsa_assignments as p')
            ->join('tbl_unit', 'tbl_unit.id', '=', 'p.unit_id')
            ->join('tbl_indikator as i', 'i.id', '=', 'p.indikator_id')
            ->whereIn('p.status_pdsa', ['assigned', 'submitted']);

        if ($unitId) {
            $query->where('p.unit_id', $unitId);
        }

        $total = (clone $query)->count();

        $list = $query->select(
            'p.id',
            'p.status_pdsa',
            'i.nama_indikator',
            'p.unit_id',
            'p.created_at',
            'tbl_unit.nama_unit',
            'p.quarter',
            'p.tahun',
        )
            ->orderByDesc('p.created_at')
            ->limit(5)
            ->get();

        return [
            'pdsaTotal' => $total,
            'pdsaList' => $list
        ];
    }

    private function getTotalPdsa($unitId = null): int
    {
        $query = DB::table('tbl_pdsa_assignments');

        if ($unitId) {
            $query->where('unit_id', $unitId);
        }

        return $query->count();
    }
}
