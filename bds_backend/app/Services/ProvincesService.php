<?php

namespace App\Services;

use App\Models\Provinces;

class ProvincesService
{

    public function create(array $data)
    {
        return Provinces::create($data);
    }

    public function getAll()
    {
        return Provinces::all();
    }

    public function getById($id)
    {
        return Provinces::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $attribute = Provinces::findOrFail($id);
        $attribute->update($data);
        return $attribute;
    }

    public function delete($id)
    {
        $attribute = Provinces::findOrFail($id);
        $attribute->delete();
        return true;
    }
}
