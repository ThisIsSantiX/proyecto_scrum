<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'estado',
        'foto_url',
        'id_rol',
        'uid',
    ];

    /**
     * Accesor para mostrar el rol como texto.
     */
    public function getRolTextoAttribute()
    {
        $roles = [
            1 => 'Admin',
            2 => 'Usuario',
        ];

        return $roles[$this->id_rol] ?? 'Desconocido';
    }

    /**
     * Accesor para mostrar el estado como texto.
     */
    public function getEstadoTextoAttribute()
    {
        return $this->estado == 1 ? 'Activo' : 'Inactivo';
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'estado' => 'boolean', 
    ];
}
