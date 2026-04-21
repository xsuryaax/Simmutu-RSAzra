<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait DashboardChartTrait
{
    /**
     * Ambil tahun dari periode aktif. Jika tidak ada, fallback ke tahun ini.
     */
    private function getTahunPeriodeAktif(): int
    {
        $periode = DB::table('tbl_periode')->where('status', 'aktif')->first();
        return $periode
            ? (int) Carbon::parse($periode->tanggal_mulai)->year
            : (int) date('Y');
    }

    /**
     * Base query untuk mengambil indikator aktif yang ada di periode aktif.
     */
    private function baseIndikatorQuery(string $kategoriLike): \Illuminate\Database\Query\Builder
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as ki', 'ki.id', '=', 'i.kamus_indikator_id')
            ->join('tbl_indikator_periode as ip', 'ip.indikator_id', '=', 'i.id')
            ->join('tbl_periode as p', 'p.id', '=', 'ip.periode_id')
            ->where('p.status', 'aktif')
            ->where('ip.status', 'aktif')
            ->where('i.status_indikator', 'aktif')
            ->where('ki.kategori_indikator', 'LIKE', $kategoriLike);
    }

    /**
     * Ambil semua laporan setahun untuk sekumpulan indikator (batch).
     */
    private function getLaporanBatch(array $indIds, int $tahun, $unitId = null): \Illuminate\Support\Collection
    {
        $query = DB::table('tbl_laporan_dan_analis as l')
            ->whereIn('l.indikator_id', $indIds)
            ->whereBetween('l.tanggal_laporan', ["$tahun-01-01", "$tahun-12-31"]);

        if ($unitId) {
            $query->where('l.unit_id', $unitId);
        }

        return $query->selectRaw('
                l.indikator_id,
                l.unit_id,
                EXTRACT(MONTH FROM l.tanggal_laporan) AS bulan,
                ROUND(CAST(AVG(l.nilai) AS numeric), 2) AS nilai
            ')
            ->groupBy('l.indikator_id', 'l.unit_id', DB::raw('EXTRACT(MONTH FROM l.tanggal_laporan)'))
            ->get()
            ->groupBy('indikator_id');
    }

    public function allImnChartData(int $tahun, $unitId = null): \Illuminate\Http\JsonResponse
    {
        $query = $this->baseIndikatorQuery('%Nasional%')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id');

        if ($unitId) {
            $query->where('i.unit_id', $unitId);
        }

        $indikators = $query->select('i.id', 'i.nama_indikator', 'i.target_indikator', 'i.arah_target', 'u.nama_unit')
            ->orderBy('i.id')
            ->get();

        if ($indikators->isEmpty()) {
            return response()->json(['type' => 'imn', 'indikators' => [], 'tahun' => $tahun]);
        }

        $indIds  = $indikators->pluck('id')->toArray();
        $laporan = $this->getLaporanBatch($indIds, $tahun, $unitId);

        $result = $indikators->map(function ($ind) use ($laporan) {
            $target = array_fill(0, 12, (float) $ind->target_indikator);
            $hasil  = array_fill(0, 12, null);

            foreach ($laporan->get($ind->id, collect()) as $row) {
                $b = (int)$row->bulan - 1;
                $hasil[$b] = $hasil[$b] === null
                    ? (float) $row->nilai
                    : round(($hasil[$b] + (float) $row->nilai) / 2, 2);
            }

            return [
                'id'           => $ind->id,
                'nama'         => $ind->nama_indikator,
                'unit'         => $ind->nama_unit ?? 'Semua Unit',
                'target'       => $target,
                'hasil'        => $hasil,
                'target_value' => (float) $ind->target_indikator,
                'arah_target'  => $ind->arah_target,
            ];
        })->values();

        return response()->json(['type' => 'imn', 'indikators' => $result, 'tahun' => $tahun]);
    }

    public function allImprsChartData(int $tahun, $unitId = null): \Illuminate\Http\JsonResponse
    {
        $query = $this->baseIndikatorQuery('%Prioritas RS%')
            ->leftJoin('tbl_kategori_imprs as k', 'k.id', '=', 'ki.kategori_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id');

        if ($unitId) {
            $query->where('i.unit_id', $unitId);
        }

        $indikators = $query->select('i.id', 'i.nama_indikator', 'i.target_indikator', 'i.arah_target', 'k.nama_kategori_imprs', 'u.nama_unit')
            ->orderBy('k.nama_kategori_imprs')
            ->orderBy('i.id')
            ->get();

        if ($indikators->isEmpty()) {
            return response()->json(['type' => 'imprs', 'indikators' => [], 'tahun' => $tahun]);
        }

        $indIds  = $indikators->pluck('id')->toArray();
        $laporan = $this->getLaporanBatch($indIds, $tahun, $unitId);

        $result = $indikators->map(function ($ind) use ($laporan) {
            $target = array_fill(0, 12, (float) $ind->target_indikator);
            $hasil  = array_fill(0, 12, null);

            foreach ($laporan->get($ind->id, collect()) as $row) {
                $b = (int)$row->bulan - 1;
                $hasil[$b] = $hasil[$b] === null
                    ? (float) $row->nilai
                    : round(($hasil[$b] + (float) $row->nilai) / 2, 2);
            }

            return [
                'id'           => $ind->id,
                'nama'         => $ind->nama_indikator,
                'unit'         => $ind->nama_unit ?? 'Semua Unit',
                'kategori'     => $ind->nama_kategori_imprs ?? 'Tanpa Kategori',
                'target'       => $target,
                'hasil'        => $hasil,
                'target_value' => (float) $ind->target_indikator,
                'arah_target'  => $ind->arah_target,
            ];
        })->values();

        return response()->json(['type' => 'imprs', 'indikators' => $result, 'tahun' => $tahun]);
    }

    public function allUnitChartData(int $tahun, $unitId = null): \Illuminate\Http\JsonResponse
    {
        $query = $this->baseIndikatorQuery('%Prioritas Unit%')
            ->join('tbl_unit as u', 'u.id', '=', 'i.unit_id');

        if ($unitId) {
            $query->where('i.unit_id', $unitId);
        }

        $indikators = $query->select('i.id', 'i.nama_indikator', 'i.target_indikator', 'i.arah_target', 'i.unit_id', 'u.nama_unit')
            ->orderBy('u.nama_unit')
            ->orderBy('i.id')
            ->get();

        if ($indikators->isEmpty()) {
            return response()->json(['type' => 'unit', 'indikators' => [], 'tahun' => $tahun]);
        }

        $indIds  = $indikators->pluck('id')->toArray();
        $laporan = $this->getLaporanBatch($indIds, $tahun, $unitId);

        $result = $indikators->map(function ($ind) use ($laporan) {
            $target = array_fill(0, 12, (float) $ind->target_indikator);
            $hasil  = array_fill(0, 12, null);

            $rows = $laporan->get($ind->id, collect())
                            ->where('unit_id', $ind->unit_id);

            foreach ($rows as $row) {
                $hasil[(int)$row->bulan - 1] = (float) $row->nilai;
            }

            return [
                'id'           => $ind->id,
                'nama'         => $ind->nama_indikator,
                'unit'         => $ind->nama_unit,
                'target'       => $target,
                'hasil'        => $hasil,
                'target_value' => (float) $ind->target_indikator,
                'arah_target'  => $ind->arah_target,
            ];
        })->values();

        return response()->json(['type' => 'unit', 'indikators' => $result, 'tahun' => $tahun]);
    }

    public function allSpmChartData(int $tahun, $unitId = null): \Illuminate\Http\JsonResponse
    {
        $query = DB::table('tbl_spm as s')
            ->join('tbl_unit as u', 'u.id', '=', 's.unit_id')
            ->where('s.status_spm', 'aktif');

        if ($unitId) {
            $query->where('s.unit_id', $unitId);
        }

        $spms = $query->select('s.id', 's.nama_spm', 's.target_spm', 's.arah_target', 's.unit_id', 'u.nama_unit')
            ->orderBy('u.nama_unit')
            ->orderBy('s.urutan')
            ->get();

        if ($spms->isEmpty()) {
            return response()->json(['type' => 'spm', 'indikators' => [], 'tahun' => $tahun]);
        }

        $spmIds = $spms->pluck('id')->toArray();

        // Ambil laporan SPM batch
        $laporan = DB::table('tbl_spm_laporan_dan_analis as l')
            ->whereIn('l.spm_id', $spmIds)
            ->whereBetween('l.tanggal_laporan', ["$tahun-01-01", "$tahun-12-31"])
            ->selectRaw('
                l.spm_id,
                EXTRACT(MONTH FROM l.tanggal_laporan) AS bulan,
                ROUND(CAST(AVG(l.nilai) AS numeric), 2) AS nilai
            ')
            ->groupBy('l.spm_id', DB::raw('EXTRACT(MONTH FROM l.tanggal_laporan)'))
            ->get()
            ->groupBy('spm_id');

        $result = $spms->map(function ($spm) use ($laporan) {
            $target = array_fill(0, 12, (float) $spm->target_spm);
            $hasil  = array_fill(0, 12, null);

            foreach ($laporan->get($spm->id, collect()) as $row) {
                $hasil[(int)$row->bulan - 1] = (float) $row->nilai;
            }

            return [
                'id'           => $spm->id,
                'nama'         => $spm->nama_spm,
                'unit'         => $spm->nama_unit,
                'target'       => $target,
                'hasil'        => $hasil,
                'target_value' => (float) $spm->target_spm,
                'arah_target'  => $spm->arah_target,
            ];
        })->values();

        return response()->json(['type' => 'spm', 'indikators' => $result, 'tahun' => $tahun]);
    }
}
