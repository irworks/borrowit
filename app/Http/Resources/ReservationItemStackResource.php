<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ReservationItemStack */
class ReservationItemStackResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'quantity' => $this->quantity,
            'meta' => new ItemStackResource($this->itemStack),
        ];
    }
}
