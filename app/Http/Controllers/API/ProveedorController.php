<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    /**
     * Listar todos los proveedores
     */
    public function index(): JsonResponse
    {
        $proveedores = Proveedor::withCount('productos')->get();

        return response()->json([
            'success' => true,
            'data' => \App\Http\Resources\API\ProveedorResource::collection($proveedores)->resolve()
        ]);
    }

    /**
     * Obtener un proveedor por ID
     */
    public function show($id): JsonResponse
    {
        $proveedor = Proveedor::with('productos')->find($id);

        if (!$proveedor) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => (new \App\Http\Resources\API\ProveedorResource($proveedor))->resolve()
        ]);
    }

    /**
     * Crear un nuevo proveedor
     */
    public function store(\App\Http\Requests\API\StoreProveedorRequest $request): JsonResponse
    {
        $proveedor = Proveedor::create([
            'nombreP' => $request->nombre
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor creado exitosamente',
            'data' => (new \App\Http\Resources\API\ProveedorResource($proveedor))->resolve()
        ], 201);
    }

    /**
     * Actualizar un proveedor
     */
    public function update(\App\Http\Requests\API\UpdateProveedorRequest $request, $id): JsonResponse
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        $proveedor->update([
            'nombreP' => $request->nombre ?? $proveedor->nombreP
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor actualizado exitosamente',
            'data' => (new \App\Http\Resources\API\ProveedorResource($proveedor))->resolve()
        ]);
    }

    /**
     * Eliminar un proveedor
     */
    public function destroy($id): JsonResponse
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        // Verificar si tiene productos asociados
        if ($proveedor->productos()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el proveedor porque tiene productos asociados'
            ], 422);
        }

        $proveedor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Proveedor eliminado exitosamente'
        ]);
    }
}

