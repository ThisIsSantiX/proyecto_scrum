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
        Schema::create('sprint_backlog', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sprint');
            $table->foreign('id_sprint')->references('id')->on('sprints');
            $table->unsignedBigInteger('id_item_backlog');
            $table->foreign('id_item_backlog')->references('id')->on('product_backlog');
            $table->string('titulo', 50);
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
        Schema::dropIfExists('sprint_backlog');
    }
};
