<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_cakupan_data extends Model
{
    use HasFactory;
    protected $table = 'tbl_cakupan_data';
    protected $fillable = [
        'nama_cakupan_data'
    ];
}
