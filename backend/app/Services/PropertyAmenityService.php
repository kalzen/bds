<?php

namespace App\Services;

use App\Models\PropertyAmenity;
use App\DTO\PropertyAmenityDTO;

class PropertyAmenityService
{
    public function getAllPropertyAmenities()
    {
        return PropertyAmenity::all();
    }

    public function getPropertyAmenityById(int $property_id, int $amenity_id)
    {
        return PropertyAmenity::where('property_id', $property_id)
            ->where('amenity_id', $amenity_id)
            ->firstOrFail();
    }

    public function createPropertyAmenity(PropertyAmenityDTO $propertyAmenityDTO)
    {
        return PropertyAmenity::create([
            'property_id' => $propertyAmenityDTO->property_id,
            'amenity_id' => $propertyAmenityDTO->amenity_id,
        ]);
    }

    public function deletePropertyAmenity(int $property_id, int $amenity_id)
    {
        $propertyAmenity = $this->getPropertyAmenityById($property_id, $amenity_id);
        $propertyAmenity->delete();
    }
}
