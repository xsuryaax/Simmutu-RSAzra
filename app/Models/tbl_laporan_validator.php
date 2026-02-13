<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_laporan_validator extends Model
{
    use HasFactory;
    protected $table = 'tbl_laporan_validator';
    protected $fillable = [
        'tanggal_laporan',
        'indikator_id',
        'laporan_analis_id',
        'kategori_indikator',
        'kategori_id',
        'numerator',
        'denominator',
        'unit_id',
        'nilai_validator',
        'pencapaian',
        'status_laporan',
        'file_laporan',
    ];
}
