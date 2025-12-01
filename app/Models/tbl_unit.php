<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_unit extends Model
{
    use HasFactory;
    protected $table = 'tbl_unit';
    protected $fillable = [
        'kode_unit',
        'nama_unit',
        'deskripsi_unit',
        'status_unit'
    ];
}
