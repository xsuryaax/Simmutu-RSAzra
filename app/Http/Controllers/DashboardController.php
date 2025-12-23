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

        // 2. Masukkan semua ke dalam array $data
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

        if (in_array($roleId, [1, 2])) {
            $data['unitIndikatorMap'] = $this->getUnitIndikatorMap();
        }

        // 🟢 khusus admin / mutu
        if (in_array($roleId, [1, 2])) {
            $data['divisionData'] = $this->getDivisionData();
        }

        // 3. Langsung kirim array $data. 
        // Di Blade, key array otomatis jadi nama variabel (contoh: $unitsSudah)
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
        return DB::table('tbl_laporan_dan_analis')
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
            $indikatorUnit = DB::table('tbl_indikator')
                ->where('unit_id', $unit->id)
                ->pluck('id');

            // ❗ Jika unit TIDAK punya indikator → SKIP
            if ($indikatorUnit->isEmpty()) {
                continue;
            }

            // 2️⃣ Hitung indikator yang SUDAH diisi bulan wajib
            $indikatorTerisi = DB::table('tbl_laporan_dan_analis')
                ->where('unit_id', $unit->id)
                ->whereMonth('tanggal_laporan', $bulanWajib)
                ->whereYear('tanggal_laporan', $tahunWajib)
                ->whereIn('indikator_id', $indikatorUnit)
                ->distinct()
                ->count('indikator_id');

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
