<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_frekuensi_analisis_data extends Model
{
    use HasFactory;
    protected $table = 'tbl_frekuensi_analisis_data';
    protected $fillable = [
        'nama_frekuensi_analisis_data',
    ];
}
