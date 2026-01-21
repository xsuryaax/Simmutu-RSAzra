<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pdsa_assignments extends Model
{
    use HasFactory;

    protected $table = "tbl_pdsa_assignments";

    protected $fillable = [
        'indikator_id', 
        'unit_id', 
        'tahun', 
        'quarter', 
        'catatan_mutu', 
        'status_pdsa', 
        'created_at', 
        'updated_at'
        ];
}
