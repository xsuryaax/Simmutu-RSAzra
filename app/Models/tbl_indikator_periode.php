<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_indikator_periode extends Model
{
    use HasFactory;

    protected $table = "tbl_indikator_periode";
    protected $fillable = [
        "id", 
        "indikator_id", 
        "periode_id", 
        "status"];
}
