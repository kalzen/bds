<?php

namespace App\Services;

use App\Models\Amenity;

class AmenityService
{
    public function create(array $data)
    {
        return Amenity::create($data);
    }

    public function getAll()
    {
        return Amenity::all();
    }

    public function getById($id)
    {
        return Amenity::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->update($data);
        return $amenity;
    }

    public function delete($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
        return true;
    }
}
