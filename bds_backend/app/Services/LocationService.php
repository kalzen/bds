<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{
    public function getLocationById(int $id)
    {
        return Location::findOrFail($id);
    }

    public function createLocation(array $data)
    {
        return Location::create($data);
    }

    public function updateLocation(int $id, array $data)
    {
        $location = Location::findOrFail($id);
        $location->update($data);

        return $location;
    }

    public function deleteLocation(int $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
    }
}
