<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_publikasi_data extends Model
{
    use HasFactory;
    protected $table = 'tbl_publikasi_data';
    protected $fillable = [
        'nama_publikasi_data',
    ];
}
