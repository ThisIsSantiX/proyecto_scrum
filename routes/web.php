<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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