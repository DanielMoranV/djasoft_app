<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->id,
            'ruc' => $this->ruc,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email
        ];
    }
}
