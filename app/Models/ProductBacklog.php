<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBacklog extends Model
{
    use HasFactory;
    
    protected $table = 'product_backlog';

    protected $fillable = [
        'id_proyecto',
        'creado_por',
        'titulo',
        'descripcion',
        'prioridad',
        'valor_historia',
        'progreso',
        'estado',
        'uid',
    ];

    protected $primaryKey = 'id';
}
