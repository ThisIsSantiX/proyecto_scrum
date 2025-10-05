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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('email_verification_token', 60)->nullable();
            $table->integer('estado')->default(1);
            $table->text('foto_url')->nullable();
            $table->text('uid');
            $table->text('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('onboarding_completado')->default(false);
            $table->boolean('tour_completed')->default(false);
            $table->timestamps();
        });

        DB::table('users')->insert([
            'username' => 'santiagotorres431',
            'nombre' => 'Santiago',
            'apellido' => 'Torres',
            'email' => 'santi@gmail.com',
            'password' => bcrypt('12345678'),
            'estado' => 1,
            'foto_url' => 'https://ui-avatars.com/api/?name=Santiago+Torres&background=random&color=fff',
            'uid' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
