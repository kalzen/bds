<?php

namespace App\Services;

use App\Models\District;

class DistrictService
{
    public function getDistrictById(int $id)
    {
        return District::findOrFail($id);
    }

    public function createDistrict(array $data)
    {
        return District::create($data);
    }

    public function updateDistrict(int $id, array $data)
    {
        $district = District::findOrFail($id);
        $district->update($data);

        return $district;
    }

    public function deleteDistrict(int $id)
    {
        $district = District::findOrFail($id);
        $district->delete();
    }
}
