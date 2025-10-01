<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\miembros_equipo;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

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

    public function miembrosEquipos()
    {
    return $this->hasMany(miembros_equipo::class, 'id_proyecto');
    }

    public function dailyScrums()
    {
        return $this->hasMany(Daily_scrum::class, 'id_proyectos');
    }
}




