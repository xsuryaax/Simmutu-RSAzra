<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tbl_indikator_unit extends Model
{
    use HasFactory;
    protected $table = 'tbl_indikator_unit';
    protected $fillable = [
        'nama_indikator_unit',
        'target_indikator_unit',
        'tipe_indikator_unit',
        'periode_tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_periode',
        'status_indikator_unit',
        'unit_id',
        'kamus_indikator_unit_id',
    ];
}
