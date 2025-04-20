<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('price_history')->insert([
            ['property_id' => 1, 'price' => 500000, 'date' => '2023-01-01'],
            ['property_id' => 2, 'price' => 750000, 'date' => '2023-02-01'],
        ]);
    }
}

