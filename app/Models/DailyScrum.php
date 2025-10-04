<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_scrum extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'duracion',
        'URL',
        'id_proyectos',
        'id_sprints',
        'observaciones',
        'bloqueos_detectados',
        'acuerdos',
        'estado',
        'uid'
    ];

    protected $primaryKey = 'id';

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyectos');
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'id_sprints');
    }
}
