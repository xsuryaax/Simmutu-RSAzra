<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_periode extends Model
{
    use HasFactory;
    protected $table = 'tbl_periode';

    protected $fillable = [
        'nama_periode',
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];
}
