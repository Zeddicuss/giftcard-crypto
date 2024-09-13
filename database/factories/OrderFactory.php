<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;
use App\Models\GiftCard;
use App\Models\Cryptocurrency;
use App\Models\CryptoWalletAddress;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function model(): string
    {
        return Order::class;
    }
    public function definition(): array
    {
        return [
            'order_number' => $this->faker->unique()->numerify('ORD-#####'),
            'buyer' => User::factory(),  // Creates a user instance
            'seller' => User::factory(),  // Creates a user instance
            'crypto_id' => function () {
                // Determine if it's a crypto order
                if ($this->faker->boolean(50)) {
                    return Cryptocurrency::factory()->create()->id;
                }
                return null;
            },
            'giftcard_id' => function () {
                // Determine if it's a gift card order
                if ($this->faker->boolean(50)) {
                    return GiftCard::factory()->create()->id;
                }
                return null;
            },
            'wallet_address' => $this->faker->unique()->numerify('#####'),
            'network' => 'SOL',
            'amount_in_usd' => $this->faker->randomFloat(2, 1, 1000),
            'exchange_rate' => $this->faker->randomFloat(2, 1, 1000),
            'amount_in_naira' => $this->faker->randomFloat(2, 1, 1000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}
