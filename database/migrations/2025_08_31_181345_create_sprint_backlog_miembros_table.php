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
        Schema::create('sprint_backlog_miembros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sprint_backlog');
            $table->unsignedBigInteger('id_miembro_equipo');
            $table->foreign('id_sprint_backlog')
                ->references('id')->on('sprint_backlog')
                ->onDelete('cascade');

            $table->foreign('id_miembro_equipo')
                ->references('id')->on('miembros_equipos')
                ->onDelete('cascade');
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
        Schema::dropIfExists('sprint_backlog_miembros');
    }
};
