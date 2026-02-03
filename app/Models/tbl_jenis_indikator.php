<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_jenis_indikator extends Model
{
    use HasFactory;
    protected $table = 'tbl_jenis_indikator';
    protected $fillable = [
        'nama_jenis_indikator',
    ];
}
