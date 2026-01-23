<?php

namespace Database\Factories;

use App\Models\RecommendationCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recommendation>
 */
class RecommendationFactory extends Factory
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
        $categoryIds = RecommendationCategory::pluck('id');

        return [
            'user_id' => fake()->randomElement($customerIds),
            'recommendation_category_id' => fake()->randomElement($categoryIds),
            'place_name' => fake()->company(),
            'address' => fake()->address(),
            'map_embed_code' => null, // Or generate fake embed codes
            'description' => fake()->paragraph(),
            'photo' => null, // Not handling file uploads in factories
            'status' => fake()->randomElement(['pending', 'active', 'expired']),
            'is_indexed' => fake()->boolean(),
            'published_at' => now(),
            'expires_at' => fake()->dateTimeBetween('+1 month', '+1 year'),
            'indexed_expires_at' => fake()->optional()->dateTimeBetween('+1 month', '+1 year'),
        ];
    }
}