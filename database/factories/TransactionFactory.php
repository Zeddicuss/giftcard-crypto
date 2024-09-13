<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\GiftCard;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_number'=>$this->faker->unique()->uuid,
            'user_id'=>User::inRandomOrder()->first()->id,
            'name' => $this->faker->randomElement(['Bicoin', 'Giftcard']),
            'product_id'=>Giftcard::inRandomOrder()->first()->id,
            'brand' => $this->faker->randomElement(['Netflix', 'Googlepay', 'Itunes']),
            'transaction_type'=>$this->faker->randomElement(['buy', 'sell', 'transfer']),
            'exchange_rate' => $this->faker->randomFloat(2,0, 100),
            'status'=>$this->faker->randomElement(['pending','completed', 'failed']),
        ];
    }
}
