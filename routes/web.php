<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/inicio', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/clientes', [ClienteController::class, 'index'])->name('aplicacion.cliente.cliente');
Route::post('/clientes', [ClienteController::class, 'store'])->name('aplicacion.cliente.cliente');
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('aplicacion.cliente.destroy');

Route::get('/productos', [ProductoController::class, 'index'])->name('aplicacion.producto.producto');
Route::post('/productos', [ProductoController::class, 'store'])->name('aplicacion.producto.producto');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('aplicacion.producto.destroy');

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('aplicacion.index');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('aplicacion.usuario.usuario');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('aplicacion.usuario.destroy');

Route::get('/ventas', [VentaController::class, 'index'])->name('aplicacion.index');
Route::post('/ventas', [VentaController::class, 'store'])->name('aplicacion.venta.venta');
Route::delete('/ventas/{id}', [VentaController::class, 'destroy'])->name('aplicacion.ventas.destroy');

require __DIR__ . '/auth.php';
