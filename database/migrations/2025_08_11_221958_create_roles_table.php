<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Str;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('estado')->default(1); // 1 = activo, 0 = inactivo
            $table->text('uid');
            $table->timestamps();
        });

        DB::table('roles')->insert([
            [
                'nombre' => 'Scrum master',
                'estado' => 1,
                'uid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Scrum team',
                'estado' => 1,
                'uid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Product owner',
                'estado' => 1,
                'uid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Usuario',
                'estado' => 1,
                'uid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Admin',
                'estado' => 1,
                'uid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
