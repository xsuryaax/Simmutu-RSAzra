<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tbl_indikator extends Model
{
    use HasFactory;
    protected $table = 'tbl_indikator';
    protected $fillable = [
        'nama_indikator',
        'target_indikator',
        'tipe_indikator',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_periode',
        'status_indikator',
        'unit_id'
    ];
}
