<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'objetivo',
        'id_proyecto',
        'fecha_inicio',
        'fecha_fin',
        'progreso',
        'estado',
        'uid',
    ];

    protected $primaryKey = 'id';

    public function getEstadoTextoAttribute()
    {
        $mapa = [
            0 => 'planificado',
            1 => 'activo',
            2 => 'completado',
            3 => 'cancelado',
        ];

        return $mapa[$this->estado] ?? 'desconocido';
    }
}