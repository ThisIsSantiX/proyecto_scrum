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
        Schema::create('daily_scrums', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('duracion');
            $table->text('URL')->nullable();
            $table->unsignedBigInteger('id_proyectos');
            $table->foreign('id_proyectos')->references('id')->on('proyectos');
            $table->unsignedBigInteger('id_sprints');
            $table->foreign('id_sprints')->references('id')->on('sprints');
            $table->text('observaciones')->nullable();
            $table->text('bloqueos_detectados')->nullable();
            $table->text('acuerdos')->nullable();
            $table->integer('estado');
            $table->text('uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_scrums');
    }
};
