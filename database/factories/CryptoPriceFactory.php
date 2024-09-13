<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CryptoPrice>
 */
class CryptoPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'crypto_name' => $this->faker->randomElement(['Bitcoin', 'Ethereum', 'Litecoin']),
            'symbol' => $this->faker->randomElement(['BTC', 'ETH', 'LTC']),
            'price' => $this->faker->randomFloat(8, 1000, 50000),
            'currency' => 'USD',
        ];
    }
}
