<?php

namespace App\Services;

use App\Models\Location;
use App\DTO\LocationDTO;
use Exception;

class LocationService
{
    public function getAllLocations()
    {
        try {
            return Location::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getLocationById(int $id)
    {
        try {
            return Location::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createLocation(LocationDTO $locationDTO)
    {
        try {
            return Location::create([
                'ward_id' => $locationDTO->ward_id,
                'address' => $locationDTO->address,
                'latitude' => $locationDTO->latitude,
                'longitude' => $locationDTO->longitude,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateLocation(int $id, LocationDTO $locationDTO)
    {
        try {
            $location = Location::findOrFail($id);
            $location->update([
                'ward_id' => $locationDTO->ward_id,
                'address' => $locationDTO->address,
                'latitude' => $locationDTO->latitude,
                'longitude' => $locationDTO->longitude,
            ]);
            return $location;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteLocation(int $id)
    {
        try {
            $location = Location::findOrFail($id);
            $location->delete();
            return ['message' => 'Location deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
