<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_kamus_indikator_mutu extends Model
{
    use HasFactory;
    protected $table = 'tbl_kamus_indikator_mutu';
    protected $fillable = [
        'definisi_operasional',
        'tujuan',
        'dasar_pemikiran',
        'formula_pengukuran',
        'metodologi',
        'detail_pengukuran',
        'sumber_data',
        'penanggung_jawab',
        'indikator_id',
        'dimensi_mutu_id',
        'metodologi_pengumpulan_data_id',
        'cakupan_data_id',
        'frekuensi_pengumpulan_data_id',
        'frekuensi_analisis_data_id',
        'metodologi_analisis_data_id',
        'interpretasi_data_id',
        'publikasi_data_id'
    ];
}
