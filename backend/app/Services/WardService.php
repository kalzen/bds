<?php

namespace App\Services;

use App\Models\Ward;
use App\DTO\WardDTO;

class WardService
{
    public function getAllWards()
    {
        return Ward::all();
    }

    public function getWardById(int $id)
    {
        return Ward::findOrFail($id);
    }

    public function createWard(WardDTO $wardDTO)
    {
        return Ward::create([
            'district_id' => $wardDTO->district_id,
            'name' => $wardDTO->name,
        ]);
    }

    public function updateWard(int $id, WardDTO $wardDTO)
    {
        $ward = Ward::findOrFail($id);
        $ward->update([
            'district_id' => $wardDTO->district_id,
            'name' => $wardDTO->name,
        ]);
        return $ward;
    }

    public function deleteWard(int $id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();
    }
}
