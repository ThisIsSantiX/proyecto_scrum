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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('descripcion',255);
            $table->unsignedBigInteger('id_owner');
            $table->foreign('id_owner')->references('id')->on('users');
            $table->integer('estado')->default(1); // 1 = activo, 0 = inactivo
            $table->text('uid');
            $table->integer('visibilidad')->default(1); // 1 = privado, 2 = publico
            $table->string('progreso',20);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
