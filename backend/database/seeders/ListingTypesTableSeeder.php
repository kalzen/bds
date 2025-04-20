<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('listing_types')->insert([
            ['name' => 'For Sale'],
            ['name' => 'For Rent'],
            ['name' => 'Lease'],
        ]);
    }
}

