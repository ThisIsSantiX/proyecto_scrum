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
        Schema::create('product_backlogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proyecto');
            $table->foreign('id_proyecto')->references('id')->on('proyectos');
            $table->unsignedBigInteger('creado_por');
            $table->foreign('creado_por')->references('id')->on('usuarios');
            $table->string('titulo', 50);
            $table->string('descripcion', 255);
            $table->string('prioridad', 10);
            $table->string('progreso', 20);
            $table->integer('estado')->default(1);
            $table->text('uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_backlogs');
    }
};
