<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'logo' => $this->faker->imageUrl(100, 100, 'business', true, 'logo'), // Generates a random logo image URL
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
