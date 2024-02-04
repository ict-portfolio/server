<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "category_id" => $this->category_id,
            "slug" => $this->slug,
            "price" => $this->price,
            "default_image" => $this->default_image,
            "images" => $this->whenLoaded('images'),
            "discount" => $this->discount,
            "instock" => $this->instock,
            "created_at" => $this->created_at,
            "category" => $this->whenLoaded('category'),
            "category_name" => $this->category->name,
        ];
    }
}
