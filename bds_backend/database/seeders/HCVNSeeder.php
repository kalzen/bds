<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HCVNSeeder extends Seeder
{
    public function run(): void
    {
        // Đọc dữ liệu từ file JSON
        $provinces = json_decode(File::get(resource_path('vendor/laravel-hanhchinhvn/data/provinces.json')), true);
        $districts = json_decode(File::get(resource_path('vendor/laravel-hanhchinhvn/data/districts.json')), true);
        $wards = json_decode(File::get(resource_path('vendor/laravel-hanhchinhvn/data/wards.json')), true);

        // Insert dữ liệu theo từng phần nhỏ để tránh lỗi quá nhiều placeholders
        $chunkSize = 500; // Số bản ghi mỗi lần insert

        DB::table('provinces')->insert($provinces);
        DB::table('districts')->insert($districts);

        foreach (array_chunk($wards, 500) as $chunk) {
            // Lọc các phần tử có 'code' bị null hoặc thiếu
            $filtered = array_filter($chunk, function ($ward) {
                return isset($ward['code']) && $ward['code'] !== null;
            });

            DB::table('wards')->insert($filtered);
        }

        // Tương tự nếu cần:
        // foreach (array_chunk($provinces, $chunkSize) as $chunk) {
        //     DB::table('provinces')->insert($chunk);
        // }
        //
        // foreach (array_chunk($districts, $chunkSize) as $chunk) {
        //     DB::table('districts')->insert($chunk);
        // }
    }
}
