<?php

namespace Database\Factories;

use App\Models\RegisterDomain;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RegisterDomainFactory extends Factory
{
    protected $model = RegisterDomain::class;

    public function definition(): array
    {
        return [
            'domain' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
