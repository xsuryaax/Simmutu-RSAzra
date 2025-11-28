<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_frekuensi_pengumpulan_data extends Model
{
    use HasFactory;
    protected $table = 'tbl_frekuensi_pengumpulan_data';
    protected $fillable = [
        'nama_frekuensi_pengumpulan_data',
    ];
}
