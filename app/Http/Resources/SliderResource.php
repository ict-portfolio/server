<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            "status" => $this->status,
            "image_id" => $this->image_id,
            "image" => $this->whenLoaded('image'),
            "created_at" => $this->created_at->format('d-m-y'),
        ];
    }
}
