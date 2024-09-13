<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CryptoTransaction>
 */
class CryptoTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_number' => $this->faker->unique()->regexify('[A-Fa-f0-9]{64}'), // Generate a unique transaction hash
            'crypto_price' => $this->faker->randomFloat(10, 100), // Random amount with precision
            'transaction_type' => $this->faker->randomElement(['buy', 'sell', 'transfer']),
            'user_id' => \App\Models\User::factory()->create()->id, // Create a new user and use its ID
            'product_id' => \App\Models\Cryptocurrency::factory()->create()->id,
            'crypto_name' => $this->faker->randomElement(['Bitcoin', 'Etherum', 'Luno']), // Random crypto type
            'wallet_address' => $this->faker->md5, // Generate a random wallet address
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
        ];
    }
}
