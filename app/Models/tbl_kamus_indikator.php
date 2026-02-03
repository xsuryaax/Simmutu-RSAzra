<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_kamus_indikator extends Model
{
    use HasFactory;
    protected $table = 'tbl_kamus_indikator';
    protected $fillable = [
        'kategori_indikator',
        'dasar_pemikiran',
        'tujuan',
        'definisi_operasional',
        'jenis_indikator_id',
        'satuan_pengukuran',
        'numerator',
        'denominator',
        'target_pencapaian',
        'kriteria_inklusi',
        'kriteria_eksklusi',
        'formula',
        'metode_pengumpulan_data',
        'sumber_data',
        'instrumen_pengambilan_data',
        'populasi',
        'sampel',
        'penanggung_jawab',

        'indikator_id',
        'kategori_id',
        'dimensi_mutu_id',
        'periode_pengumpulan_data_id',
        'periode_analisis_data_id',
        'penyajian_data_id',
    ];
}
