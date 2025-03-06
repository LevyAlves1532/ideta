<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/old-login', [AuthController::class, 'oldIndex'])->name('old-login');
Route::post('/login', [AuthController::class, 'show'])->name('login.post');
Route::get('/registre-se', [AuthController::class, 'create'])->name('register');
Route::post('/registre-se', [AuthController::class, 'store'])->name('register.post');

Route::middleware('auth')->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::post('/categorias/ideia', [CategoryController::class, 'addIdeaCategory'])->name('categories.add-idea');
    Route::delete('/categorias/ideia/{ideia}', [CategoryController::class, 'removeIdeaCategory'])->name('categories.remove-idea');
    Route::resource('/categorias', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'show' => 'categories.show',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);
    Route::post('/ideias/categoria', [IdeaController::class, 'addCategoryIdea'])->name('ideas.add-category');
    Route::get('/ideias/copia/{token}', [IdeaController::class, 'copyIdea'])->name('ideas.copy');
    Route::post('/ideias/compartilhar', [IdeaController::class, 'shareIdea'])->name('ideas.share-idea');
    Route::delete('/ideias/categoria/{categoria}', [IdeaController::class, 'removeCategoryIdea'])->name('ideas.remove-category');
    Route::resource('/ideias', IdeaController::class)->names([
        'index' => 'ideas.index',
        'create' => 'ideas.create',
        'store' => 'ideas.store',
        'show' => 'ideas.show',
        'edit' => 'ideas.edit',
        'update' => 'ideas.update',
        'destroy' => 'ideas.destroy',
    ]);

    Route::get('/notas/{idea_id}', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notas/compartilhada/{token}', [NoteController::class, 'ideaShared'])->name('notes.idea-shared');
    Route::get('/notas/{idea_id}/{note_id}/down', [NoteController::class, 'downNote'])->name('notes.down');
    Route::get('/notas/{idea_id}/{note_id}/up', [NoteController::class, 'upNote'])->name('notes.up');
    Route::post('/notas/{idea_id}', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('/notas/{idea_id}/{note_id}', [NoteController::class, 'destroy'])->name('notes.destroy');

    Route::get('/perfil/{user_id}', [UserController::class, 'show'])->name('profile.show');
    Route::get('/perfil/{user_id}/editar', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil/{user_id}/update', [UserController::class, 'update'])->name('profile.update');

    Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
});
