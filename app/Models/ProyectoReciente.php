<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoReciente extends Model
{
    use HasFactory;

    protected $table = 'proyecto_recientes';
    protected $fillable = ['id_usuario', 'id_proyecto', 'opened_at'];
    public $timestamps = false;

}
