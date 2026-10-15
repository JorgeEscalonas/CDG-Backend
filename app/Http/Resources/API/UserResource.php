<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->idUsuario,
            'nombre' => $this->nombreU,
            'role' => $this->role ?? 'empleado',
        ];
    }
}
