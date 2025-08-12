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
}
