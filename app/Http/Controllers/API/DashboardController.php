<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Dolar;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Obtener estadísticas del dashboard
     */
    public function index(): JsonResponse
    {
        $stats = [
            'totalProductos' => Producto::count(),
            'totalCategorias' => Categoria::count(),
            'totalProveedores' => Proveedor::count(),
            'ultimoPrecioDolar' => Dolar::obtenerUltimoPrecio()
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'totalProductos' => $stats['totalProductos'],
                'totalCategorias' => $stats['totalCategorias'],
                'totalProveedores' => $stats['totalProveedores'],
                'ultimoPrecioDolar' => $stats['ultimoPrecioDolar'] ? [
                    'precio' => $stats['ultimoPrecioDolar']->precio,
                    'fecha_actualizacion' => $stats['ultimoPrecioDolar']->fecha_actualizacion
                ] : null
            ]
        ]);
    }
}

