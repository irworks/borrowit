<?php

namespace App\Http\Resources;

use App\Models\ItemStack;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Booking */
class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'notes' => $this->notes,
            'organisation_id' => $this->organisation_id,
            'user_id' => $this->user_id,
            'manager_id' => $this->manager_id,
            'from' => $this->from,
            'to' => $this->to,
            'items' => BookingItemResource::collection($this->items)
        ];
    }
}
