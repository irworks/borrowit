<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'notes' => $this->faker->word(),
            'organisation_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
            'manager_id' => $this->faker->randomNumber(),
            'from' => Carbon::now(),
            'to' => Carbon::now(),
            'returned_at' => Carbon::now(),
            'reservation_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
