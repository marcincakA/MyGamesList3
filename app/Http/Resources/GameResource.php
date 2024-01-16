<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'name' => $this->name,
            'developer' => $this->developer,
            'publisher' => $this->publisher,
            'category1' => $this->category1,
            'category2' => $this->category2,
            'category3' => $this->category3,
            'about' => $this->about,
            'image' => $this->image
        ];
    }
}
