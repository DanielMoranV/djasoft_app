<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
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
            'comment' => $this->comment,
            'create_at' => $this->create_at,
            'category_movement' => new CategoryMovementsResource($this->whenLoaded('category_movement')),
            'voucher' => new VoucherResource($this->whenLoaded('voucher')),
            'provider' => new ProviderResource($this->whenLoaded('provider')),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),

        ];
    }
}
