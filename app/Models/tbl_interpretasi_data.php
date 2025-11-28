<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_interpretasi_data extends Model
{
    use HasFactory;
    protected $table = 'tbl_interpretasi_data';
    protected $fillable = [
        'nama_interpretasi_data',
    ];
}
