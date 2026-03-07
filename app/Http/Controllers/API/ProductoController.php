<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos o filtrar por categoría
     */
    public function index(Request $request): JsonResponse
    {
        $query = Producto::with(['proveedor', 'categoria']);

        if ($request->has('categoria') && $request->categoria) {
            $query->where('idCategoria', $request->categoria);
        }

        $productos = $request->has('per_page') 
            ? $query->paginate($request->per_page) 
            : $query->get();

        return response()->json([
            'success' => true,
            'data' => \App\Http\Resources\API\ProductoResource::collection($productos)
                ->response()
                ->getData(true)['data']
        ]);
    }

    /**
     * Obtener un producto por ID
     */
    public function show($id): JsonResponse
    {
        $producto = Producto::with(['proveedor', 'categoria'])->find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new \App\Http\Resources\API\ProductoResource($producto)
        ]);
    }

    /**
     * Crear un nuevo producto
     */
    public function store(\App\Http\Requests\API\StoreProductoRequest $request): JsonResponse
    {
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->costo = $request->costo;
        $producto->pvp = $request->costo / 0.7;
        $producto->idProveedor = $request->idProveedor;
        $producto->idCategoria = $request->idCategoria;
        $producto->save();

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente',
            'data' => new \App\Http\Resources\API\ProductoResource($producto->load(['proveedor', 'categoria']))
        ], 201);
    }

    /**
     * Actualizar un producto
     */
    public function update(\App\Http\Requests\API\UpdateProductoRequest $request, $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $data = $request->only(['nombre', 'idProveedor', 'idCategoria']);
        if ($request->has('costo')) {
            $data['costo'] = $request->costo;
            $data['pvp'] = $request->costo / 0.7;
        }
        $producto->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => new \App\Http\Resources\API\ProductoResource($producto->load(['proveedor', 'categoria']))
        ]);
    }

    /**
     * Eliminar un producto
     */
    public function destroy($id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}

