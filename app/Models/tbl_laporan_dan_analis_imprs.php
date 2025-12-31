<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_laporan_dan_analis_imprs extends Model
{
    use HasFactory;
    protected $table = 'tbl_laporan_dan_analis_imprs';
    protected $fillable = [
        'tanggal_laporan',
        'imprs_id',
        'unit_id',
        'kategori_id',
        'nilai',
        'pencapaian',
        'file_laporan',
    ];
}
