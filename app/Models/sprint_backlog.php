<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sprint_backlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_sprint',
        'id_item_backlog',
        'asignado_a',
        'titulo',
        'progreso',
        'estado',
        'uid',
    ];

    protected $primaryKey = 'id';

}
