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
            "icon" => $this->icon,
            "root_category_id" => $this->root_category_id,
            "root_category" => $this->whenLoaded('root_category'),
            "created_at" => $this->created_at->format('d-m-y'),
        ];
    }
}
