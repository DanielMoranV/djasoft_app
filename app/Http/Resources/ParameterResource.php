<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParameterResource extends JsonResource
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
            'warehouse_id' => $this->warehouse_id,
            'sunat_send' => (bool) $this->sunat_send,
            'locked' => (bool) $this->locked,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
        ];
    }
}
