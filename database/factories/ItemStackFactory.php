<?php

namespace Database\Factories;

use App\Models\ItemStack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ItemStackFactory extends Factory
{
    protected $model = ItemStack::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'is_set' => $this->faker->boolean(),
            'category_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
