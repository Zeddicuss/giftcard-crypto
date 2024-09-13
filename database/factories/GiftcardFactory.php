<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Giftcard>
 */
class GiftcardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->randomElement(['Netflix Starter Sub', 'Google Pay Giftcard', 'ITunes Slush fund']),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'amount_in_naira' => fake()->randomFloat(2, 10, 1000),
            'pin' => fake()->randomNumber(6),
            'currency' => 'USD',
            'exchange_rate' => $this->faker->randomFloat(2, 10, 500), // Generates a random value between 10 and 500' => $this->faker->randomFloat(2, 10, 500), // Generates a random value between 10 and 500
            'listed_by' => User::count() > 0 ? User::inRandomOrder()->first()->id : null,
            'category_id' => Category::factory(),
            'photo' => $this->faker->imageUrl(640, 480, 'gift_cards', true, 'Faker'),
            'status' => $this->faker->randomElement(['available', 'sold', 'expired']),
            'v_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

}
