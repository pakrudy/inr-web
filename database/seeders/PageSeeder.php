<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'content' => 'This is the About Us page content. Please edit this from the admin panel.',
            ],
            [
                'title' => 'Services',
                'content' => 'This is the Services page content. Please edit this from the admin panel.',
            ],
            [
                'title' => 'Contact Us',
                'content' => 'This is the Contact Us page content. Please edit this from the admin panel.',
            ],
        ];

        foreach ($pages as $page) {
            Page::create([
                'title' => $page['title'],
                'slug' => Str::slug($page['title']),
                'content' => $page['content'],
                'is_published' => true,
            ]);
        }
    }
}