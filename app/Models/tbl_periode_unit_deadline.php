<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_periode_unit_deadline extends Model
{
    use HasFactory;
    protected $table = 'tbl_periode_unit_deadline';
    protected $fillable = [
        'periode_id',
        'unit_id',
    ];
}
