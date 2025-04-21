<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function getCityById(int $id)
    {
        return City::findOrFail($id);
    }

    public function createCity(array $data)
    {
        return City::create($data);
    }

    public function updateCity(int $id, array $data)
    {
        $city = City::findOrFail($id);
        $city->update($data);

        return $city;
    }

    public function deleteCity(int $id)
    {
        $city = City::findOrFail($id);
        $city->delete();
    }
}
