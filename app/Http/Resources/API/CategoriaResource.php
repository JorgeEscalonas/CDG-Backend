<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->idCategoria,
            'nombre' => $this->nombreC,
            'productos_count' => $this->whenCounted('productos'),
            // Solo cargar productos si la relación fue cargada explícitamente
            'productos' => ProductoResource::collection($this->whenLoaded('productos')),
        ];
    }
}
