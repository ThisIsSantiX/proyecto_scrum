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
        Schema::create('sprint_backlogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sprint');
            $table->foreign('id_sprint')->references('id')->on('sprints');
            $table->unsignedBigInteger('id_item_backlog');
            $table->foreign('id_item_backlog')->references('id')->on('product_backlogs');
            $table->unsignedBigInteger('asignado_a');
            $table->foreign('asignado_a')->references('id')->on('users');
            $table->string('titulo', 50);
            $table->string('progreso', 20);
            $table->integer('estado')->default(1);
            $table->text('uid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprint_backlogs');
    }
};
