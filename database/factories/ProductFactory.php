<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::title(fake()->words(3, true)),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(10000, 1000000),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}
