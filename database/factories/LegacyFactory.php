<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Legacy>
 */
class LegacyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get customer IDs (IDs 3 to 22 are customers based on UserSeeder)
        $customerIds = User::where('role', 'pelanggan')->pluck('id');
        $categoryIds = Category::pluck('id');

        return [
            'user_id' => fake()->randomElement($customerIds),
            'category_id' => fake()->randomElement($categoryIds),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'photo' => null, // Not handling file uploads in factories
            'status' => fake()->randomElement(['pending', 'active']),
            'is_indexed' => fake()->boolean(),
            'published_at' => now(),
        ];
    }
}