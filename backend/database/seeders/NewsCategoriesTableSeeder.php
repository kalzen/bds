<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news_categories')->insert([
            ['name' => 'Real Estate News'],
            ['name' => 'Market Trends'],
            ['name' => 'Tips & Advice'],
        ]);
    }
}

