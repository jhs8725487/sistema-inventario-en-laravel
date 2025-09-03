<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])
    ->name('home')
    ->middleware(['auth']);
    
//Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware(['auth'];

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])
    ->name('admin.index')
    ->middleware(['auth']);


    //rute for categories

Route::get('/admin/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])
    ->name('categoria.index')
    ->middleware(['auth']); // 👈 puedes cambiar 'admin' por tu middleware

Route::get('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])
    ->name('categoria.create')
    ->middleware(['auth']); // 👈 puedes cambiar 'admin' por tu middleware

Route::post('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'store'])->name('categorias.store');

Route::get('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])
    ->name('categorias.show')
    ->middleware(['auth']);

Route::get('/admin/categorias/{id}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])
    ->name('categorias.edit')
    ->middleware(['auth']);

Route::put('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])
    ->name('categorias.update')
    ->middleware(['auth']);

Route::delete('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'destroy'])
    ->name('categorias.destroy')
    ->middleware(['auth']);


