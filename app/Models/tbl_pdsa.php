<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pdsa extends Model
{
    use HasFactory;
    protected $table = 'tbl_pdsa';
    protected $fillable = [
        'assignment_id',
        'plan',
        'do',
        'study',
        'action',
        'created_by',
    ];
}
