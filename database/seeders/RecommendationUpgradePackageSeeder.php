<?php

namespace Database\Seeders;

use App\Models\RecommendationUpgradePackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecommendationUpgradePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Paket A',
                'slug' => 'paket-a',
                'description' => 'Rekomendasi akan terindeks dan mendapatkan lencana "Direkomendasikan".',
                'price' => 50000.00,
                'features' => json_encode(['indexed' => true, 'certificate' => false, 'media_publication' => false]),
                'is_active' => true,
            ],
            [
                'name' => 'Paket B',
                'slug' => 'paket-b',
                'description' => 'Semua fitur Paket A, ditambah dengan sertifikat cetak resmi.',
                'price' => 150000.00,
                'features' => json_encode(['indexed' => true, 'certificate' => true, 'media_publication' => false]),
                'is_active' => true,
            ],
            [
                'name' => 'Paket C',
                'slug' => 'paket-c',
                'description' => 'Semua fitur Paket B, ditambah dengan publikasi di media partner.',
                'price' => 500000.00,
                'features' => json_encode(['indexed' => true, 'certificate' => true, 'media_publication' => true]),
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            RecommendationUpgradePackage::updateOrCreate(['slug' => $package['slug']], $package);
        }
    }
}