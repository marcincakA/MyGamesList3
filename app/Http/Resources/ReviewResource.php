<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        Log::info('ReviewResource ');
        return [
        'id' => $this->id,
        'game_id' => $this->game_id,
        'user_name' => $this->user->name,
        'user_id' => $this->user_id,
        'rating' => $this->rating,
        'text' => $this->text,

    ];

    }
}
