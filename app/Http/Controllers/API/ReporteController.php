<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Dolar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    /**
     * Generar reporte de productos
     */
    public function productos(Request $request)
    {
        $categoria = $request->query('categoria');
        
        $query = Producto::with(['proveedor', 'categoria']);
        if ($categoria) {
            $query->where('idCategoria', $categoria);
        }
        $productos = $query->get();
        
        $ultimoPrecioDolar = Dolar::obtenerUltimoPrecio();
        $tasaDolar = $ultimoPrecioDolar ? $ultimoPrecioDolar->precio : null;
        
        $data = [
            'productos' => $productos,
            'tasaDolar' => $tasaDolar,
            'titulo' => 'Reporte de Productos'
        ];
        
        try {
            $pdf = Pdf::loadView('reportes.productos', $data)
                ->setPaper('a4', 'portrait')
                ->setOption('margin-top', 5)
                ->setOption('margin-bottom', 5)
                ->setOption('margin-left', 5)
                ->setOption('margin-right', 5);
            return $pdf->download('reporte_productos.pdf');
        } catch (\Exception $e) {
            \Log::error('Error generando reporte de productos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar reporte de categorías
     */
    public function categorias()
    {
        $categorias = Categoria::all();
        
        $data = [
            'categorias' => $categorias,
            'titulo' => 'Reporte de Categorías'
        ];
        
        try {
            $pdf = Pdf::loadView('reportes.categorias', $data);
            return $pdf->download('reporte_categorias.pdf');
        } catch (\Exception $e) {
            \Log::error('Error generando reporte de categorías: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar reporte de proveedores
     */
    public function proveedores()
    {
        $proveedores = Proveedor::all();
        
        $data = [
            'proveedores' => $proveedores,
            'titulo' => 'Reporte de Proveedores'
        ];
        
        try {
            $pdf = Pdf::loadView('reportes.proveedores', $data);
            return $pdf->download('reporte_proveedores.pdf');
        } catch (\Exception $e) {
            \Log::error('Error generando reporte de proveedores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar reporte de precios del dólar
     */
    public function preciosDolar()
    {
        $precios = Dolar::orderBy('fecha_actualizacion', 'desc')->get();
        
        $data = [
            'precios' => $precios,
            'titulo' => 'Reporte de Precios del Dólar'
        ];
        
        try {
            $pdf = Pdf::loadView('reportes.precios_dolar', $data);
            return $pdf->download('reporte_precios_dolar.pdf');
        } catch (\Exception $e) {
            \Log::error('Error generando reporte de precios dólar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }
}

