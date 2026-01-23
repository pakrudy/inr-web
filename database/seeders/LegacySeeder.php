<?php

namespace Database\Seeders;

use App\Models\Legacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Legacy::factory()->count(15)->create();
    }
}