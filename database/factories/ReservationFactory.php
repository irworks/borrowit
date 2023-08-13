<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'notes' => $this->faker->word(),
            'organisation_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
            'from' => Carbon::now(),
            'to' => Carbon::now(),
            'submitted_at' => Carbon::now(),
            'fullfilled_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
