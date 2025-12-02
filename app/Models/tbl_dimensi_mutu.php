<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_dimensi_mutu extends Model
{
    use HasFactory;
    protected $table = 'tbl_dimensi_mutu';
    protected $fillable = [
        'nama_dimensi_mutu',
    ];
}
