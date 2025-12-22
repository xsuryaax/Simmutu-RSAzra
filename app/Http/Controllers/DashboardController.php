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

        // 🔑 indikator KHUSUS untuk chart
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

            // ⚠️ data global (tetap)
            ...$this->getBaseData(),
            ...$this->getStatistikUnit(),
            ...$this->getRecentIsi(),

            // 🔥 chart data (sinkron)
            'indikatorsForChart' => $indikatorsForChart,
            'allDataJson' => json_encode($this->getUserChartData()),
        ];

        // 🟢 khusus admin / mutu
        if (in_array($roleId, [1, 2])) {
            $data['divisionData'] = $this->getDivisionData();
        }

        return view('admin.dashboard', $data);
    }


    /* =========================
     * DATA DASAR
     * ========================= */
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
            ->leftJoin('tbl_kamus_indikator_mutu', 'tbl_kamus_indikator_mutu.id', '=', 'tbl_indikator.kamus_indikator_id')
            ->select(
                'tbl_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.target_indikator',
                'tbl_indikator.unit_id',
                'tbl_kamus_indikator_mutu.frekuensi_pengumpulan_data_id as frekuensi_id'
            )
            ->orderBy('nama_indikator')
            ->get();
    }

    private function getYears()
    {
        return DB::table('tbl_laporan_dan_analis')
            ->selectRaw('DISTINCT EXTRACT(YEAR FROM tanggal_laporan) as tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');
    }

    /* =========================
     * STATISTIK UNIT
     * ========================= */
    private function getStatistikUnit(): array
    {
        $bulan = date('m');
        $tahun = date('Y');

        $totalUnit = DB::table('tbl_indikator')
            ->distinct('unit_id')
            ->count('unit_id');

        $unitSudahIsi = DB::table('tbl_indikator as i')
            ->leftJoin('tbl_laporan_dan_analis as l', function ($join) use ($bulan, $tahun) {
                $join->on('i.id', '=', 'l.indikator_id')
                    ->whereMonth('l.tanggal_laporan', $bulan)
                    ->whereYear('l.tanggal_laporan', $tahun);
            })
            ->selectRaw('i.unit_id')
            ->groupBy('i.unit_id')
            ->havingRaw('COUNT(i.id) = COUNT(l.id)')
            ->count();

        return [
            'totalUnit' => $totalUnit,
            'unitSudahIsi' => $unitSudahIsi,
            'unitBelumIsi' => $totalUnit - $unitSudahIsi,
        ];
    }

    /* =========================
     * RECENT INPUT
     * ========================= */
    private function getRecentIsi(): array
    {
        return [
            'recentIsi' => DB::table('tbl_laporan_dan_analis as l')
                ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
                ->orderByDesc('l.tanggal_laporan')
                ->limit(5)
                ->get()
        ];
    }

    /* =========================
     * USER CHART
     * ========================= */
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

    /* =========================
     * DIVISION CHART (ADMIN/MUTU)
     * ========================= */
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
                    $divisionData[$tahun][$u->nama_unit]['indikators'][$ind->id] =
                        $this->buildIndikatorData($ind, $tahun, $labels, $u->id);
                }
            }
        }

        return $divisionData;
    }

    /* =========================
     * BUILDER DATA INDIKATOR
     * ========================= */
    private function buildIndikatorData($ind, int $tahun, array $labels, $unitId = null): array
    {
        $hasil = array_fill(1, 12, null);
        $target = array_fill(1, 12, $ind->target_indikator);

        $query = DB::table('tbl_laporan_dan_analis')
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
}
