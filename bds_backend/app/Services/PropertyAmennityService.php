<?php
namespace App\Services;

use App\Models\PropertyAmenity;

class PropertyAmennityService
{
    public function create(array $data): PropertyAmenity
    {
        return PropertyAmenity::create($data);
    }

    public function findbyID(int $id): ?PropertyAmenity
    {
        return PropertyAmenity::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $amenity = PropertyAmenity::find($id);
        return $amenity ? $amenity->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $amenity = PropertyAmenity::find($id);
        return $amenity ? $amenity->delete() : false;
    }
}
