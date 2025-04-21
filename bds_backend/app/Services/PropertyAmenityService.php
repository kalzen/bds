<?php

namespace App\Services;

use App\Models\PropertyAmenity;

class PropertyAmenityService
{
    public function getPropertyAmenityById(int $id)
    {
        return PropertyAmenity::findOrFail($id);
    }

    public function createPropertyAmenity(array $data)
    {
        return PropertyAmenity::create($data);
    }

    public function updatePropertyAmenity(int $id, array $data)
    {
        $propertyAmenity = PropertyAmenity::findOrFail($id);
        $propertyAmenity->update($data);

        return $propertyAmenity;
    }

    public function deletePropertyAmenity(int $id)
    {
        $propertyAmenity = PropertyAmenity::findOrFail($id);
        $propertyAmenity->delete();
    }
}
