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
        Schema::create('product_backlog', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proyecto');
            $table->foreign('id_proyecto')->references('id')->on('proyectos');
            $table->unsignedBigInteger('creado_por');
            $table->foreign('creado_por')->references('id')->on('users');
            $table->string('titulo', 50);
            $table->string('descripcion', 255)->nullable();
            $table->string('prioridad', 10)->nullable();
            $table->integer('valor_historia')->nullable();
            $table->string('progreso', 20)->nullable();
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
        Schema::dropIfExists('product_backlog');
    }
};
