<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_hak_akses extends Model
{
    use HasFactory;
    protected $table = 'tbl_hak_akses';
    protected $fillable = [
        'role_id',
        'menu_key',
    ];
}
