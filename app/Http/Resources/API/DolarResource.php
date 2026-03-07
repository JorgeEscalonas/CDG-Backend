<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DolarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'precio' => (float) $this->precio,
            'fecha' => $this->fecha_actualizacion->format('Y-m-d H:i:s'),
            'hace_cuanto' => $this->fecha_actualizacion->diffForHumans(),
        ];
    }
}
