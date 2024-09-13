<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cryptocurrency>
 */
class CryptocurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'crypto_price' => $this->faker->optional()->randomFloat(2, 10, 1000),
            'exchange_rate' => $this->faker->optional()->randomFloat(6, 0.01, 10),
            'photo' => $this->faker->imageUrl(),
            'currency' => 'USD',
            'listed_by' => User::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'v_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
