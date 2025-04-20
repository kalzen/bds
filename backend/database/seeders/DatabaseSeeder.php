<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ListingTypeSeeder::class,
            PropertyCategorySeeder::class,
            LocationSeeder::class,
            UserSeeder::class,
            AmenitiesTableSeeder::class,
            AttributesTableSeeder::class,
            CitiesTableSeeder::class,
            DistrictsTableSeeder::class,
            LocationsTableSeeder::class,
            NewsCategoriesTableSeeder::class,
            NewsTableSeeder::class,
            PriceHistoryTableSeeder::class,
        ]);
    }

}

