<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'id_proyecto',
        'estado',
        'uid',
    ];

    protected $primaryKey = 'id';
}
