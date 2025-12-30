<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        if (in_array($roleId, [1, 2])) {
            // Admin / Mutu
            $indikatorsForChart = $this->getIndikators();
        } else {
            // User biasa → hanya indikator unit sendiri
            $indikatorsForChart = $this->getIndikators()
                ->where('unit_id', $user->unit_id);
        }

        $data = [
            'roleId' => $roleId,

            ...$this->getBaseData(),
            ...$this->getStatistikUnit(),
            ...$this->getRecentIsi(),

            'indikatorsForChart' => $indikatorsForChart,
            'allDataJson' => json_encode($this->getUserChartData()),
        ];

        if (in_array($roleId, [1, 2])) {
            $data['unitIndikatorMap'] = $this->getUnitIndikatorMap();
        }

        if (in_array($roleId, [1, 2])) {
            $data['divisionData'] = $this->getDivisionData();
        }

        return view('admin.dashboard', $data);
    }

    private function getBaseData(): array
    {
        return [
            'totalIndikator' => DB::table('tbl_indikator_unit')->count(),
            'indikators' => $this->getIndikators(),
            'years' => $this->getYears(),
        ];
    }

    private function getIndikators()
    {
        return DB::table('tbl_indikator_unit')
            ->leftJoin('tbl_kamus_indikator_mutu_unit', 'tbl_kamus_indikator_mutu_unit.id', '=', 'tbl_indikator_unit.kamus_indikator_unit_id')
            ->select(
                'tbl_indikator_unit.id',
                'tbl_indikator_unit.nama_indikator_unit',
                'tbl_indikator_unit.target_indikator_unit',
                'tbl_indikator_unit.unit_id',
                'tbl_kamus_indikator_mutu_unit.frekuensi_pengumpulan_data_id as frekuensi_id'
            )
            ->orderBy('nama_indikator_unit')
            ->get();
    }

    private function getUnitIndikatorMap()
    {
        return DB::table('tbl_unit as u')
            ->join('tbl_indikator_unit as i', 'i.unit_id', '=', 'u.id')
            ->select(
                'u.nama_unit',
                'i.id as indikator_id',
                'i.nama_indikator_unit'
            )
            ->orderBy('u.nama_unit')
            ->orderBy('i.nama_indikator_unit')
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

        $unitsSudah = [];
        $unitsBelum = [];

        foreach ($units as $unit) {

            // 1️⃣ Ambil indikator MILIK UNIT
            $indikatorUnit = DB::table('tbl_indikator_unit')
                ->where('unit_id', $unit->id)
                ->pluck('id');

            // ❗ Jika unit TIDAK punya indikator → SKIP
            if ($indikatorUnit->isEmpty()) {
                continue;
            }

            // 2️⃣ Hitung indikator yang SUDAH diisi bulan wajib
            $indikatorTerisi = DB::table('tbl_laporan_dan_analis_unit')
                ->where('unit_id', $unit->id)
                ->whereMonth('tanggal_laporan', $bulanWajib)
                ->whereYear('tanggal_laporan', $tahunWajib)
                ->whereIn('indikator_unit_id', $indikatorUnit)
                ->distinct()
                ->count('indikator_unit_id');

            // 3️⃣ Bandingkan
            if ($indikatorTerisi === $indikatorUnit->count()) {
                $unitsSudah[] = $unit;
            } else {
                $unitsBelum[] = $unit;
            }
        }

        return [
            'totalUnit' => count($unitsSudah) + count($unitsBelum),
            'unitSudahIsi' => count($unitsSudah),
            'unitBelumIsi' => count($unitsBelum),
            'unitsSudah' => $unitsSudah,
            'unitsBelum' => $unitsBelum,
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

    private function getUserChartData(): array
    {
        $user = Auth::user();
        $years = $this->getYears();
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // 🔑 FILTER INDIKATOR DI AWAL
        if (in_array($user->role_id, [1, 2])) {
            // Admin / Mutu → semua indikator
            $indikators = $this->getIndikators();
        } else {
            // User biasa → hanya indikator unit sendiri
            $indikators = $this->getIndikators()
                ->where('unit_id', $user->unit_id);
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

    private function getDivisionData(): array
    {
        $indikators = $this->getIndikators();
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
                            'nama_indikator_unit' => $ind->nama_indikator_unit
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
        $target = array_fill(1, 12, $ind->target_indikator_unit);

        $query = DB::table('tbl_laporan_dan_analis_unit')
            ->where('indikator_unit_id', $ind->id)
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
}
