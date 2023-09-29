<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "status" => $this->status,
            "paragraph" => $this->paragraph,
            "slug" => $this->slug,
            "created_at" => $this->created_at->format('d-m-y'),
            "image_id" => $this->image_id,
            "image" => $this->whenLoaded('image'),
            "category_id" => $this->category_id,
            "category" => $this->whenLoaded('category'),
        ];
    }
}
