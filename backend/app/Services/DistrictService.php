<?php

namespace App\Services;

use App\Models\District;
use App\DTO\DistrictDTO;
use Exception;

class DistrictService
{


    public function getDistrictById(int $id)
    {
        try {
            return District::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createDistrict(DistrictDTO $districtDTO)
    {
        try {
            return District::create([
                'city_id' => $districtDTO->city_id,
                'name' => $districtDTO->name,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateDistrict(int $id, DistrictDTO $districtDTO)
    {
        try {
            $district = District::findOrFail($id);
            $district->update([
                'city_id' => $districtDTO->city_id,
                'name' => $districtDTO->name,
            ]);
            return $district;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteDistrict(int $id)
    {
        try {
            $district = District::findOrFail($id);
            $district->delete();
            return ['message' => 'District deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

