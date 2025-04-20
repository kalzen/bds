<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attributes')->insert([
            ['name' => 'Bedrooms'],
            ['name' => 'Bathrooms'],
            ['name' => 'Square Footage'],
            ['name' => 'Year Built'],
        ]);
    }
}

