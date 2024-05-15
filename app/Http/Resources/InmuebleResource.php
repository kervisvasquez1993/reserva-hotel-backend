<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InmuebleResource extends JsonResource
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
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'direccion' => $this->direccion,
            'imagen' => $this->imagen,
            'video_url' => $this->video_url,
            'destacado' => $this->destacado,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'inmobiliaria' => new InmobiliariaResource($this->inmobiliaria),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
