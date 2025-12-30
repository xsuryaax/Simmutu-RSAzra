<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_laporan_dan_analis_nasional extends Model
{
    protected $table = 'tbl_laporan_dan_analis_nasional';
    protected $fillable = [
        'tanggal_laporan',
        'indikator_nasional_id',
        'nilai',
        'pencapaian',
        'status_laporan',
        'file',
    ];
}
