<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AppsTableSeeder extends Seeder
{
    public function run()
    {
        if (\Illuminate\Support\Facades\DB::table('apps')->count() > 0) {
            // Already seeded; skip to preserve existing data
            echo "AppsTableSeeder: table not empty, skipping\n";
            return;
        }
        DB::table('apps')->insert([
            [
                'title' => 'Weatherly',
                'description' => 'A lightweight weather app with beautiful animations.',
                'image' => '/assets/images/weatherly.png',
                'link' => 'https://example.com/weatherly',
                'category' => 'Productivity',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'TaskFlow',
                'description' => 'A minimal task manager with kanban style.',
                'image' => '/assets/images/taskflow.png',
                'link' => 'https://example.com/taskflow',
                'category' => 'Productivity',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // additional dummy apps
            [
                'title' => 'NoteNest',
                'description' => 'A cozy notes app for quick thoughts.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/notenest',
                'category' => 'Utilities',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'FitPulse',
                'description' => 'Track workouts and metrics with a simple UI.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/fitpulse',
                'category' => 'Health',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'BudgetBee',
                'description' => 'Personal budgeting made delightful.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/budgetbee',
                'category' => 'Finance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'PhotoFlick',
                'description' => 'A lightweight photo gallery with transitions.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/photoflick',
                'category' => 'Photography',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ShopLite',
                'description' => 'Minimal storefront demo for small sellers.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/shoplite',
                'category' => 'E-commerce',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'TimeTide',
                'description' => 'A focused Pomodoro timer with themes.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/timetide',
                'category' => 'Productivity',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'MapRoam',
                'description' => 'Simple map explorer for sightseeing.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/maproam',
                'category' => 'Travel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'CookPad',
                'description' => 'Save and share quick recipes.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/cookpad',
                'category' => 'Food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Lingua',
                'description' => 'Micro language flashcards for daily practice.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/lingua',
                'category' => 'Education',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'DevBoard',
                'description' => 'A compact dev dashboard showing metrics.',
                'image' => '/assets/images/placeholder.png',
                'link' => 'https://example.com/devboard',
                'category' => 'Developer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
