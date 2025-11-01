<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'rating' => $this->rating,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'created_at' => $this->created_at,
        ];
    }
}
