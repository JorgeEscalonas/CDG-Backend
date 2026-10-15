<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\ProveedorController;
use App\Http\Controllers\API\DolarController;
use App\Http\Controllers\API\ReporteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::apiResource('productos', ProductoController::class)->except(['destroy']);
    Route::apiResource('categorias', CategoriaController::class)->except(['destroy']);
    Route::apiResource('proveedores', ProveedorController::class)->except(['destroy']);

    Route::get('/dolar/ultimo', [DolarController::class, 'obtenerUltimoPrecio']);
    Route::get('/dolar/historial', [DolarController::class, 'obtenerHistorial']);
    Route::get('/dolar/api', [DolarController::class, 'obtenerTasaAPI']);

    Route::get('/reportes/productos', [ReporteController::class, 'productos']);
    Route::get('/reportes/categorias', [ReporteController::class, 'categorias']);
    Route::get('/reportes/proveedores', [ReporteController::class, 'proveedores']);
    Route::get('/reportes/precios-dolar', [ReporteController::class, 'preciosDolar']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::delete('categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::delete('proveedores/{proveedore}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
    Route::post('/dolar', [DolarController::class, 'guardarPrecio']);
});
