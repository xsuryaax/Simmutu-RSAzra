<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_indikator_nasional extends Model
{
    protected $table = 'tbl_indikator_nasional';
    protected $fillable = [
        'nama_indikator_nasional',
        'target_indikator_nasional',
        'periode_tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_periode',
        'status_indikator_nasional'
    ];
}
