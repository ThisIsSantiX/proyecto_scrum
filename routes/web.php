<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SprintController;

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
Route::get('/dashboard', function () {return view('pages.dashboard.index');})->name('dashboard'); 

// Authentication Routes
Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
Route::redirect('/', '/auth/login');
Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/login', [AuthController::class, 'authLogin'])->name('authLogin');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/recovery', [AuthController::class, 'showRecoveryForm'])->name('recoverypw');
Route::get('/auth/confirm-mail', [AuthController::class, 'confirmMail'])->name('confirmMail');

// Sprint Routes
Route::get('/sprints', [SprintController::class, 'index'])->name('sprints.index');
Route::get('/sprints/create', [SprintController::class, 'create'])->name('sprints.create');
Route::post('/sprints', [SprintController::class, 'store'])->name('sprints.store');
Route::get('/sprints/{id}', [SprintController::class, 'show'])->name('sprints.detalle');
Route::get('/sprints/{id}', [SprintController::class, 'show'])->name('sprints.show');
Route::get('/sprints/{id}/edit', [SprintController::class, 'edit'])->name('sprints.edit');
Route::put('/sprints/{id}', [SprintController::class, 'update'])->name('sprints.update');
Route::delete('/sprints/{id}', [SprintController::class, 'destroy'])->name('sprints.destroy');
