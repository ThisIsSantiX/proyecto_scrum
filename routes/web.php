<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.auth.login');
});


Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.detalle');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
Route::get('/usuarios/{id}/delete', [UserController::class, 'destroy'])->name('usuarios.delete');


Route::get('/kanban', function () {return view('pages.kanban.index');})->name('kanban'); 

Route::get('/login', [AuthController::class, 'index'])->name('login');

// Mostrar formulario de registro
Route::get('/register', [AuthController::class, 'register'])->name('register');
// Procesar registro
Route::post('/storeCuenta', [AuthController::class, 'store'])->name('storeCuenta');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



