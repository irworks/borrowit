<?php

namespace Database\Factories;

use App\Models\BookingItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookingItemFactory extends Factory
{
    protected $model = BookingItem::class;

    public function definition(): array
    {
        return [
            'booking_id' => $this->faker->randomNumber(),
            'item_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
