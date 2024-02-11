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
            "specification" => $this->specification,
            "category_id" => $this->category_id,
            "slug" => $this->slug,
            "price" => $this->price,
            "default_image" => $this->default_image,
            "discount" => $this->discount,
            "instock" => $this->instock,
            "created_at" => $this->created_at,
            "category_name" => $this->load('category')->name,
            "images" => $this->whenLoaded('images'),
            "category" => $this->whenLoaded('category'),
        ];
    }
}
