<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class IndikatorMutuService
{
    /**
     * Ambil periode aktif dengan caching
     */
    public function getPeriodeAktif()
    {
        return Cache::remember('periode_aktif', 60, function () {
            return DB::table('tbl_periode')
                ->where('status', 'aktif')
                ->first();
        });
    }

    /**
     * Ambil daftar indikator berdasarkan user dan kategori
     */
    public function getIndikator($user, $kategori = null)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_periode_pengumpulan_data as f', 'f.id', '=', 'k.periode_pengumpulan_data_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->join('tbl_indikator_periode as ip', 'ip.indikator_id', '=', 'i.id')
            ->join('tbl_periode as p', 'p.id', '=', 'ip.periode_id')
            ->where('p.status', 'aktif')
            ->where('ip.status', 'aktif')
            ->where('i.status_indikator', 'aktif')
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
                'ip.created_at as entry_date'
            )
            ->when($kategori, function ($q) use ($kategori) {
                $q->whereRaw(
                    "LOWER(k.kategori_indikator) LIKE ?",
                    ['%' . strtolower($kategori) . '%']
                );
            })
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )
            ->orderByRaw("CASE WHEN i.unit_id = ? THEN 0 ELSE 1 END", [$user->unit_id])
            ->orderByRaw("
                CASE
                    WHEN k.kategori_indikator ILIKE '%Nasional%' THEN 1
                    WHEN k.kategori_indikator ILIKE '%Prioritas RS%' THEN 2
                    WHEN k.kategori_indikator ILIKE '%Prioritas Unit%' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('i.nama_indikator')
            ->get();
    }

    /**
     * Hitung pencapaian (tercapai/tidak)
     */
    public function hitungPencapaian($nilai, $arah, $target, $min, $max)
    {
        if ($nilai === null) return false;

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

    /**
     * Hitung status validasi (Valid/Tidak Valid)
     */
    public function hitungStatusValidasi($rataAnalis, $rataValidator)
    {
        if ($rataValidator === null || $rataAnalis === null) {
            return null;
        }

        $toleransi = $rataValidator * 0.10;
        $selisih = abs($rataValidator - $rataAnalis);

        return ($selisih <= $toleransi) ? 'valid' : 'tidak-valid';
    }

    /**
     * Ambil bulan validasi untuk suatu indikator
     */
    public function getBulanValidasi($indikatorId, $unitId, $periodeAktif)
    {
        if (!$periodeAktif) return now()->startOfMonth();

        $periodeStart = Carbon::parse($periodeAktif->tanggal_mulai)->startOfMonth();
        $periodeEnd = Carbon::parse($periodeAktif->tanggal_selesai)->endOfMonth();

        $firstReportDate = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $indikatorId)
            ->where('unit_id', $unitId)
            ->whereBetween('tanggal_laporan', [$periodeStart, $periodeEnd])
            ->orderBy('tanggal_laporan', 'asc')
            ->value('tanggal_laporan');

        if ($firstReportDate) {
            return Carbon::parse($firstReportDate)->startOfMonth();
        }

        $now = now()->startOfMonth();
        return $now->max($periodeStart)->min($periodeEnd);
    }
}
