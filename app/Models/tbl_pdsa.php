<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pdsa extends Model
{
    use HasFactory;
    protected $table = 'tbl_pdsa';
    protected $fillable = [
        'indikator_id',
        'unit_id',
        'tahun',
        'quarter',
        'realisasi',
        'plan',
        'do',
        'study',
        'action',
        'status',
        'created_by',
    ];
}
