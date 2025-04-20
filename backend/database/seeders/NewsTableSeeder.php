<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->insert([
            ['title' => 'Housing Market Update', 'category_id' => 1],
            ['title' => 'Top 10 Investment Tips', 'category_id' => 3],
        ]);
    }
}

