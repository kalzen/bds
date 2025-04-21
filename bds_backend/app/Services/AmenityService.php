<?php

namespace App\Services;

use App\Models\Amenity;

class AmenityService
{
    public function getAmenityById(int $id)
    {
        return Amenity::findOrFail($id);
    }

    public function createAmenity(array $data)
    {
        return Amenity::create($data);
    }

    public function updateAmenity(int $id, array $data)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->update($data);

        return $amenity;
    }

    public function deleteAmenity(int $id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
    }
}
