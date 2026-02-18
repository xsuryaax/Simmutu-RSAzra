<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_hasil_analisa extends Model
{
    use HasFactory;
    protected $table = 'tbl_hasil_analisa';
    protected $fillable = [
        'indikator_id',
        'tanggal_analisa',
        'unit_id',
        'analisa',
        'tindak_lanjut',
    ];
}
