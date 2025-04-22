<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{
    public function create(array $data)
    {
        return Location::create($data);
    }

    public function findbyID(int $id)
    {
        return Location::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $location = Location::findOrFail($id);
        $location->update($data);
        return $location;
    }

    public function delete(int $id)
    {
        $location = Location::findOrFail($id);
        return $location->delete();
    }
}
