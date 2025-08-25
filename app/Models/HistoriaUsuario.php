<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaUsuario extends Model
{   
    protected $fillable = [
        'id_responsable',
        'titulo',
        'descripcion',
        'prioridad',
        'valor_historia',
        'estado',
        'uid',
    ];

    use HasFactory;
}
