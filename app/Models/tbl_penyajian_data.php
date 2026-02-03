<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_penyajian_data extends Model
{
    use HasFactory;
    protected $table = 'tbl_penyajian_data';
    protected $fillable = [
        'nama_penyajian_data',
    ];
}
