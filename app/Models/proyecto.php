<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'id_owner',
        'estado',
        'uid',
        'visibilidad',
        'progreso',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $primaryKey = 'id';
}
