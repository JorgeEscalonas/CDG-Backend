<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Listar todas las categorías
     */
    public function index(): JsonResponse
    {
        $categorias = Categoria::withCount('productos')->get();

        return response()->json([
            'success' => true,
            'data' => \App\Http\Resources\API\CategoriaResource::collection($categorias)->resolve()
        ]);
    }

    /**
     * Obtener una categoría por ID
     */
    public function show($id): JsonResponse
    {
        $categoria = Categoria::with('productos')->find($id);

        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => (new \App\Http\Resources\API\CategoriaResource($categoria))->resolve()
        ]);
    }

    /**
     * Crear una nueva categoría
     */
    public function store(\App\Http\Requests\API\StoreCategoriaRequest $request): JsonResponse
    {
        $categoria = Categoria::create([
            'nombreC' => $request->nombre
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría creada exitosamente',
            'data' => (new \App\Http\Resources\API\CategoriaResource($categoria))->resolve()
        ], 201);
    }

    /**
     * Actualizar una categoría
     */
    public function update(\App\Http\Requests\API\UpdateCategoriaRequest $request, $id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        $categoria->update([
            'nombreC' => $request->nombre ?? $categoria->nombreC
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada exitosamente',
            'data' => (new \App\Http\Resources\API\CategoriaResource($categoria))->resolve()
        ]);
    }

    /**
     * Eliminar una categoría
     */
    public function destroy($id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        // Verificar si tiene productos asociados
        if ($categoria->productos()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la categoría porque tiene productos asociados'
            ], 422);
        }

        $categoria->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoría eliminada exitosamente'
        ]);
    }
}

