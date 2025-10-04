<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'uid',
    ];

    protected $table = 'roles';

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id')
                    ->withPivot('estado', 'uid')
                    ->withTimestamps();
    }

    protected $primaryKey = 'id';
}
