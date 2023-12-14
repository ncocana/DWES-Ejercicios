<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'alias' => fake()->name(),
            'address' => fake()->address(),
            // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
            'user_id' => fake()->numberBetween(1, User::count()),
        ];
    }
}
