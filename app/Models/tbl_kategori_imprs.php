<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_kategori_imprs extends Model
{
    use HasFactory;
    protected $table = 'tbl_kategori_imprs';
    protected $fillable = [
        'nama_kategori_imprs',
    ];
}
