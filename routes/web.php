<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RolesController;

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

// usuarios ---------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/register', [AuthController::class, 'register'])->name('register');
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

//  Rutas para la gestion de proyectos ---------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
Route::get('/showProyectos',[ProyectoController::class, 'show'])->name('showProyectos');
Route::post('/proyectos/store', [ProyectoController::class, 'store'])->name('storeProyecto');
Route::get('/proyecto/{uid}', [ProyectoController::class, 'detailsProyecto'])->name('detailsProyecto');
Route::get('/proyectos/edit/{uid}', [ProyectoController::class, 'edit'])->name('editProyecto');
Route::put('/proyectos/update', [ProyectoController::class, 'update'])->name('updateProyecto');
Route::delete('/proyectos/delete/{uid}', [ProyectoController::class, 'destroy'])->name('deleteProyecto');

//sprints---------------------------------------------------------------------------------------------------------------------------------------------------


//Roles---------------------------------------------------------------------------------------------------------------------------------------------------

Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
Route::post('/roles/store', [RolesController::class, 'store'])->name('roles.store');
Route::get('/roles/{id}',[RolesController::class, 'show'])->name('roles.show');
Route::get('/roles/{id}/edit', [RolesController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
Route::get('/roles/{id}/delete', [RolesController::class, 'destroy'])->name('roles.delete');


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

