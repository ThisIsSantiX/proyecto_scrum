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
        Schema::create('historia_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_responsable')->nullable();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('prioridad', 50)->nullable(); 
            $table->integer('valor_historia')->nullable();
            $table->integer('estado');
            $table->uid('uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_usuarios');
    }
};
