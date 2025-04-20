<?php

namespace App\Services;

use App\Models\Amenity;
use App\DTO\AmenityDTO;
use Exception;

class AmenityService
{
    public function getAllAmenities()
    {
        try {
            return Amenity::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getAmenityById(int $id)
    {
        try {
            return Amenity::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createAmenity(AmenityDTO $amenityDTO)
    {
        try {
            return Amenity::create([
                'name' => $amenityDTO->name,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateAmenity(int $id, AmenityDTO $amenityDTO)
    {
        try {
            $amenity = Amenity::findOrFail($id);
            $amenity->update([
                'name' => $amenityDTO->name,
            ]);
            return $amenity;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteAmenity(int $id)
    {
        try {
            $amenity = Amenity::findOrFail($id);
            $amenity->delete();
            return ['message' => 'Amenity deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
