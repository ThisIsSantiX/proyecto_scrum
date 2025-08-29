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
        Schema::create('criterios_aceptacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_item_backlog');
            $table->text('descripcion');
            $table->text('progreso'); // Cumplido - No cumplido
            $table->integer('estado'); 
            $table->text('uid');
            $table->foreign('id_item_backlog')->references('id')->on('product_backlog');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterios_aceptacion');
    }
};
