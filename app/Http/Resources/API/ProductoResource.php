<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->idProducto,
            'nombre' => $this->nombre,
            'costo' => (float) $this->costo,
            'pvp' => (float) $this->pvp,
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
            'proveedor' => new ProveedorResource($this->whenLoaded('proveedor')),
            'idCategoria' => $this->idCategoria,
            'idProveedor' => $this->idProveedor,
        ];
    }
}
