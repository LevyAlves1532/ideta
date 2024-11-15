<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'show'])->name('login.post');
Route::get('/registre-se', [AuthController::class, 'create'])->name('register');
Route::post('/registre-se', [AuthController::class, 'store'])->name('register.post');

Route::middleware('auth')->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::resource('/categorias', CategoryController::class);
    Route::resource('/ideias', IdeaController::class);

    Route::get('/notas/{id}', [NoteController::class, 'show'])->name('notas.show');
});
