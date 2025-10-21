<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialAssistanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // 'name',
        // 'category',
        // 'thumbnail',
        // 'amount',
        // 'provider',
        // 'description',
        // 'is_available',
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'thumbnail' => $this->thumbnail,
            'amount' => $this->amount,
            'provider' => $this->provider,
            'description' => $this->description,
            'is_available' => $this->is_available,


        ];
    }
}
