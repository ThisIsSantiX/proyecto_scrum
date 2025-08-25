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



// Mostrar formulario de registro
Route::get('/register', [AuthController::class, 'register'])->name('register');
// Procesar registro
Route::post('/storeCuenta', [AuthController::class, 'store'])->name('storeCuenta');

// Rutas para gestión de usuarios
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/showUsuarios', [UserController::class, 'show'])->name('showUsuarios');
Route::get('/usuarios/edit/{uid}', [UserController::class, 'edit'])->name('editUsuario');
Route::put('/usuarios/update/{uid}', [UserController::class, 'update'])->name('updateUsuario');
Route::delete('/usuarios/eliminar/{uid}', [UserController::class, 'destroy'])->name('deleteUsuario');
Route::get('/showRoles', [UserController::class, 'showRoles'])->name('showRoles');

Route::get('/kanban', function () {return view('pages.kanban.index');})->name('kanban'); 
Route::get('/dashboard', function () {return view('pages.dashboard.index');})->name('dashboard'); 

// Authentication Routes
Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
Route::redirect('/', '/auth/login');
Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/register', [AuthController::class, 'authRegister'])->name('register');
Route::post('/auth/login', [AuthController::class, 'authLogin'])->name('authLogin');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/recovery', [AuthController::class, 'showRecoveryForm'])->name('recoverypw');
Route::get('/auth/confirm-mail', [AuthController::class, 'confirmMail'])->name('confirmMail');

