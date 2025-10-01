<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'username',
        'apellido',
        'email',
        'password',
        'estado',
        'google_id',
        'foto_url',
        'uid',
    ];

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
    ];

    public function getFotoUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }

        $username = $this->username ?? 'Usuario';
        $apellido = $this->apellido ?? '';
        $fullName = trim("{$username} {$apellido}");

        return "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=random&color=fff";
    }

}
