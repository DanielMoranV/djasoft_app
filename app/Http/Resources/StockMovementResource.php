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
            'user_id' => $this->user_id,
            'category_movements_id' => $this->category_movements_id,
            'provider_id' => $this->provider_id,
            'voucher_id' => $this->voucher_id,
            'created_at' => $this->created_at,
            'category_movement' => new CategoryMovementsResource($this->whenLoaded('category_movement')),
            'voucher' => new VoucherResource($this->whenLoaded('voucher')),
            'provider' => new ProviderResource($this->whenLoaded('provider')),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),
            'movements_detail' => MovementsDetailResource::collection($this->whenLoaded('movements_detail')),

        ];
    }
}
