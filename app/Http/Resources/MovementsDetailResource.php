<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovementsDetailResource extends JsonResource
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
            'product_batch_id' => $this->product_batch_id,
            'stock_moment_id' => $this->stock_moment_id,
            'count' => $this->count,
            'created_at' => $this->created_at
        ];
    }
}
