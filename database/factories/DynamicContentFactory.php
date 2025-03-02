<?php

namespace Database\Factories;

use App\Models\DynamicContent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DynamicContentFactory extends Factory
{
    protected $model = DynamicContent::class;

    public function definition(): array
    {
        return [
            'slot' => $this->faker->word(),
            'content' => $this->faker->word(),
            'html' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
