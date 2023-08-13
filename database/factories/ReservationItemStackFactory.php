<?php

namespace Database\Factories;

use App\Models\ReservationItemStack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReservationItemStackFactory extends Factory
{
    protected $model = ReservationItemStack::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(),
            'reservation_id' => $this->faker->randomNumber(),
            'item_stack_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
