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
            "paragraph" => $this->paragraph,
            "slug" => $this->slug,
            "created_at" => Carbon::parse($this->created_at)->format('j-F-Y'),
            "image_id" => $this->image_id,
            "category_id" => $this->category_id,
            "category" => $this->whenLoaded("category"),
            "image" => $this->whenLoaded('image'),
        ];
    }
}
