<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'thumbnail' => $this->thumbnail,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float)(string)$this->price,
            'date' => $this->date,
            'time' => $this->time,
            'is_active' => $this->is_active,
        ];
    }
}
