<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Ensure you have some users in the users table
            'crypto_type' => $this->faker->randomElement(['BTC', 'ETH', 'LTC', null]), // Random crypto type or null
            'wallet_address' => $this->faker->unique()->optional()->regexify('[A-Za-z0-9]{34}'), // Optional unique wallet address
            'crypto_balance' => $this->faker->randomFloat(8, 0, 100), // Random crypto balance with high precision
            'fiat_currency' => $this->faker->optional()->randomElement(['USD', 'EUR', 'GBP', 'JPY']), // Optional fiat currency
            'fiat_balance' => $this->faker->randomFloat(2, 0, 10000), // Random fiat balance with two decimal precision
        ];
    }
}
