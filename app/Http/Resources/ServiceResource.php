<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            "slug" => $this->slug,
            "created_at" => Carbon::parse($this->created_at)->format('j-F-Y'),
            "category_id" => $this->category_id,
            "default_image" => $this->default_image,
            "proposal" => $this->proposal,
            "terms" => $this->terms,
            "features" => $this->features,
            "image_description" => $this->image_description,
            "images" => $this->whenLoaded('images'),
            "category" => $this->whenLoaded('category'),
            "category_name" => $this->category->name,
        ];
    }
}
