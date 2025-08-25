<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriosAceptacion extends Model
{   
    protected $fillable = [
        'id_historia',
        'descripcion',
        'estado',
        'uid',
    ];

    use HasFactory;
}
