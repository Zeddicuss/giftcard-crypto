<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isAdmin = \App\Models\User::where('role', 'admin')->exists() ? 'user' : 'admin';

        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01'),
            'address' => json_encode([
                'country' => $this->faker->country,
                'state' => $this->faker->state,
                'street' => $this->faker->streetAddress,
            ]),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Default password
            'phone' => $this->faker->phoneNumber,
            'verification_status' => $this->faker->randomElement(['Pending', 'Verified', 'Rejected']),
            'photo' => $this->faker->imageUrl(),
            'role' => $isAdmin, // Default role
            'is_active' => true, // Default active status
            'remember_token' => Str::random(10),
        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
