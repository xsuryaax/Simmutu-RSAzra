<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_laporan_dan_analis extends Model
{
    use HasFactory;
    protected $table = 'tbl_laporan_dan_analis';
    protected $fillable = [
        'tanggal_laporan',
        'indikator_unit_id',
        'unit_id',
        'nilai',
        'pencapaian',
        'status_laporan',
        'file_laporan',
    ];
}
