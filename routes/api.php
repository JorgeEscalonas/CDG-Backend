<?php

use Illuminate\Http\Request;
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

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Productos
    Route::apiResource('productos', ProductoController::class);

    // Categorías
    Route::apiResource('categorias', CategoriaController::class);

    // Proveedores
    Route::apiResource('proveedores', ProveedorController::class);

    // Dólar
    Route::get('/dolar/ultimo', [DolarController::class, 'obtenerUltimoPrecio']);
    Route::get('/dolar/historial', [DolarController::class, 'obtenerHistorial']);
    Route::get('/dolar/api', [DolarController::class, 'obtenerTasaAPI']);
    Route::post('/dolar', [DolarController::class, 'guardarPrecio']);

    // Reportes
    Route::get('/reportes/productos', [ReporteController::class, 'productos']);
    Route::get('/reportes/categorias', [ReporteController::class, 'categorias']);
    Route::get('/reportes/proveedores', [ReporteController::class, 'proveedores']);
    Route::get('/reportes/precios-dolar', [ReporteController::class, 'preciosDolar']);
});

