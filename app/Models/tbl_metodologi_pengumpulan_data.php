<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_metodologi_pengumpulan_data extends Model
{
    use HasFactory;
    protected $table = 'tbl_metodologi_pengumpulan_data';
    protected $fillable = [
        'nama_metodologi_pengumpulan_data',
    ];
}
