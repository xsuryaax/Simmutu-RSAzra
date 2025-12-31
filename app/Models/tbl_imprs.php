<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_imprs extends Model
{
    use HasFactory;
    protected $table = 'tbl_imprs';
    protected $fillable = [
        'nama_imprs',
        'target_imprs',
        'tipe_imprs',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_periode',
        'status_imprs',
        'kategori_id',
        'kamus_imprs_id'
    ]; 
}
