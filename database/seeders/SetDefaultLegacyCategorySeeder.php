<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Legacy;

class SetDefaultLegacyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCategory = Category::where('slug', 'umum')->first();

        if ($defaultCategory) {
            Legacy::whereNull('category_id')->update(['category_id' => $defaultCategory->id]);
        } else {
            // Handle case where 'Umum' category doesn't exist
            $this->command->warn('Default category "Umum" not found. Please run CategorySeeder first.');
        }
    }
}