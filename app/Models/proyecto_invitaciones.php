<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyecto_invitaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_id',
        'invitado_por',
        'usuario_invitado',
        'estadoInvitacion',
        'uid',
        'estado',
        'expira_en'
    ];

    protected $casts = [
        'expira_en' => 'datetime'
    ];

    public function proyecto(){
        return $this->belongsTo(proyecto::class,'proyecto_id');
    }

    public function invitadoPor(){
        return $this->belongsTo(User::class,'invitado_por');
    }

    public function usuarioInvitado(){
        return $this->belongsTo(User::class,'usuario_invitado');
    }

    public function scopePendientes($query){
        return $query->where('estadoInvitacion','pendiente')
                    ->where(function($q){
                        $q->whereNull('expira_en')
                          ->orwhere('expira_en','>',now());
                    });
    }

    public function estaVencida(){
        return $this->expira_en && $this->expira_en->isPast();
    }

    public function puedeSerAceptada(){
        return $this->estadoInvitacion === 'pendiente' && !$this->estaVencida();
    }
}
