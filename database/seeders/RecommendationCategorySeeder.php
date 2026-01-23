<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RecommendationCategory;

class RecommendationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Kuliner', 'slug' => 'kuliner'],
            ['name' => 'Wisata', 'slug' => 'wisata'],
            ['name' => 'Penginapan', 'slug' => 'penginapan'],
            ['name' => 'Belanja', 'slug' => 'belanja'],
            ['name' => 'Lainnya', 'slug' => 'lainnya'],
        ];

        foreach ($categories as $category) {
            RecommendationCategory::create($category);
        }
    }
}