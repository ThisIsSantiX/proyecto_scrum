<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiembrosEquipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_equipo',
        'id_usuario',
        // 'id_rol',
        'estado',
        'uid',
    ];

    protected $primaryKey = 'id';

    public function usuario()
{
    return $this->belongsTo(User::class, 'id_usuario');
}

}
