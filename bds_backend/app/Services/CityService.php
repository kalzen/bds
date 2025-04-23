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
        $attribute = City::findOrFail($id);
        $attribute->update($data);
        return $attribute;
    }

    public function delete($id)
    {
        $attribute = City::findOrFail($id);
        $attribute->delete();
        return true;
    }
}
