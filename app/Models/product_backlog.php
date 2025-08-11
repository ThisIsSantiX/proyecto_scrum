<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_backlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_proyecto',
        'creado_por',
        'titulo',
        'descripcion',
        'prioridad',
        'progreso',
        'estado',
        'uid',
    ];

    protected $primaryKey = 'id';
}
