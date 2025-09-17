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

// Rutas para Sucursales

Route::get('/admin/sucursales', [App\Http\Controllers\SucursalController::class, 'index'])
    ->name('sucursal.index')
    ->middleware(['auth']);

Route::get('/admin/sucursales/create', [App\Http\Controllers\SucursalController::class, 'create'])
    ->name('sucursal.create')
    ->middleware(['auth']);

Route::post('/admin/sucursales/create', [App\Http\Controllers\SucursalController::class, 'store'])
    ->name('sucursales.store');

Route::get('/admin/sucursales/{id}', [App\Http\Controllers\SucursalController::class, 'show'])
    ->name('sucursales.show')
    ->middleware(['auth']);

Route::get('/admin/sucursales/{id}/edit', [App\Http\Controllers\SucursalController::class, 'edit'])
    ->name('sucursales.edit')
    ->middleware(['auth']);

Route::put('/admin/sucursales/{id}', [App\Http\Controllers\SucursalController::class, 'update'])
    ->name('sucursales.update')
    ->middleware(['auth']);

Route::delete('/admin/sucursales/{id}', [App\Http\Controllers\SucursalController::class, 'destroy'])
    ->name('sucursales.destroy')
    ->middleware(['auth']);


    
// Rutas para Productos

Route::get('/admin/productos', [App\Http\Controllers\ProductoController::class, 'index'])
    ->name('productos.index')
    ->middleware(['auth']);

Route::get('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])
    ->name('productos.create')
    ->middleware(['auth']);

Route::post('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'store'])
    ->name('productos.store');

Route::get('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'show'])
    ->name('productos.show')
    ->middleware(['auth']);

Route::get('/admin/productos/{id}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])
    ->name('productos.edit')
    ->middleware(['auth']);

Route::put('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'update'])
    ->name('productos.update')
    ->middleware(['auth']);

Route::delete('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])
    ->name('productos.destroy')
    ->middleware(['auth']);

