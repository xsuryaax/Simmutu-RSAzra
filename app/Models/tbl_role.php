<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_role extends Model
{
    use HasFactory;
    protected $table = 'tbl_role';
    protected $fillable = [
        'nama_role',
        'deskripsi_role',
    ];
}
