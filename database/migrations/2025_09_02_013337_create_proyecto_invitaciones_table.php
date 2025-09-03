<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proyecto_invitaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('invitado_por');
            $table->unsignedBigInteger('usuario_invitado');
            $table->enum('estadoInvitacion',['pendiente','aceptada','rechazada'])->default('pendiente');
            $table->text('uid');
            $table->integer('estado');
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('invitado_por')->references('id')->on('users');
            $table->foreign('usuario_invitado')->references('id')->on('users');
            $table->timestamp('expira_en')->nullable();
            $table->timestamps();

            // Evitar invitaciones duplicadas pendientes
            $table->unique(['proyecto_id', 'usuario_invitado', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_invitaciones');
    }
};
