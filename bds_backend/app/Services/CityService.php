<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function create(array $data)
    {
        return City::create($data);
    }

    public function getAll()
    {
        return City::all();
    }

    public function getById($id)
    {
        return City::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $city = City::findOrFail($id);
        $city->update($data);
        return $city;
    }

    public function delete($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return true;
    }
}
