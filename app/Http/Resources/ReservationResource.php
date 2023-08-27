<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Reservation */
class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'notes' => $this->notes,
            'from' => $this->from,
            'to' => $this->to,
            'submitted_at' => $this->submitted_at,
            'fulfilled_at' => $this->fulfilled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'item_stacks' => ReservationItemStackResource::collection($this->reservationItemStacks),

            'organisation_id' => $this->organisation_id,
            'user_id' => $this->user_id,
        ];
    }
}
