<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request):array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "image_id" => $this->image_id,
            "image" => $this->whenLoaded('image'),
            "created_at" => $this->created_at->format('d-m-y'),
            "updated_at" => $this->updated_at->format('d-m-y'),
        ];
    }
}
