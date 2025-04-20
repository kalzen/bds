<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('districts')->insert([
            ['name' => 'Ba Dinh', 'city_id' => 1],
            ['name' => 'District 1', 'city_id' => 2],
            ['name' => 'Hai Chau', 'city_id' => 3],
            ['name' => 'Le Chan', 'city_id' => 4],
        ]);
    }
}

