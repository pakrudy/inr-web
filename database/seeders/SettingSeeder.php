<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'payment.legacy.initial', 'value' => '100000'],
            ['key' => 'payment.legacy.upgrade', 'value' => '50000'],
            ['key' => 'payment.recommendation.initial', 'value' => '50000'],
            ['key' => 'payment.recommendation.upgrade', 'value' => '25000'],
            ['key' => 'payment.recommendation.renewal', 'value' => '25000'],
            ['key' => 'payment.recommendation.renewal_indexed', 'value' => '25000'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
