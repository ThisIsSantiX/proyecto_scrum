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
        Schema::create('criterios_aceptacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_historia');
            $table->text('descripcion');
            $table->integer('estado'); 
            $table->uuid('uid');
            $table->foreign('id_historia')->references('id')->on('historias_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterios_aceptacions');
    }
};
