<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id" => $this->id,
            "name" => $this->name,
            "paragraph" => $this->paragraph,
            "created_at" => $this->created_at->format('d-m-y'),
            "image_id" => $this->image_id,
            "image" => $this->whenLoaded('image'),
        ];
    }
}
