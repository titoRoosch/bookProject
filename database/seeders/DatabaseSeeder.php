<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();
        \App\Models\Authors::factory(10)->create();
        \App\Models\Books::factory(20)->create()->each(function ($book) {
            $authorIds = \App\Models\Authors::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $book->authors()->attach($authorIds);
        });
    }
}
