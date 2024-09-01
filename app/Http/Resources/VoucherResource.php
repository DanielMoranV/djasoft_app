<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            'series' => $this->series,
            'number' => $this->number,
            'amount' => $this->amount,
            'status' => $this->status,
            'issue_date' => $this->issue,
            'created_at' => $this->create_at,
        ];
    }
}
