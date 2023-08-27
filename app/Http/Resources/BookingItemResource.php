<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\BookingItem */
class BookingItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->item->name,
            'item_id' => $this->item->id,
            'item_stack_id' => $this->item->item_stack_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
