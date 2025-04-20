<?php

namespace App\Services;

use App\Models\City;
use App\DTO\CityDTO;
use Exception;

class CityService
{
    public function getAllCities()
    {
        try {
            return City::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getCityById(int $id)
    {
        try {
            return City::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createCity(CityDTO $cityDTO)
    {
        try {
            return City::create([
                'name' => $cityDTO->name,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateCity(int $id, CityDTO $cityDTO)
    {
        try {
            $city = City::findOrFail($id);
            $city->update([
                'name' => $cityDTO->name,
            ]);
            return $city;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteCity(int $id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();
            return ['message' => 'City deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
