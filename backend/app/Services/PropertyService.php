<?php

namespace App\Services;

use App\Models\Property;
use App\DTO\PropertyDTO;

class PropertyService
{
    public function getAllProperties()
    {
        return Property::all();
    }

    public function getPropertyById(int $id)
    {
        return Property::findOrFail($id);
    }

    public function createProperty(PropertyDTO $propertyDTO)
    {
        return Property::create([
            'user_id' => $propertyDTO->user_id,
            'project_id' => $propertyDTO->project_id,
            'listing_type_id' => $propertyDTO->listing_type_id,
            'category_id' => $propertyDTO->category_id,
            'location_id' => $propertyDTO->location_id,
            'title' => $propertyDTO->title,
            'description' => $propertyDTO->description,
            'price' => $propertyDTO->price,
            'attribute_id' => $propertyDTO->attribute_id,
            'legal_status' => $propertyDTO->legal_status,
            'direction' => $propertyDTO->direction,
            'furniture' => $propertyDTO->furniture,
        ]);
    }

    public function updateProperty(int $id, PropertyDTO $propertyDTO)
    {
        $property = Property::findOrFail($id);
        $property->update([
            'user_id' => $propertyDTO->user_id,
            'project_id' => $propertyDTO->project_id,
            'listing_type_id' => $propertyDTO->listing_type_id,
            'category_id' => $propertyDTO->category_id,
            'location_id' => $propertyDTO->location_id,
            'title' => $propertyDTO->title,
            'description' => $propertyDTO->description,
            'price' => $propertyDTO->price,
            'attribute_id' => $propertyDTO->attribute_id,
            'legal_status' => $propertyDTO->legal_status,
            'direction' => $propertyDTO->direction,
            'furniture' => $propertyDTO->furniture,
        ]);
        return $property;
    }

    public function deleteProperty(int $id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
    }
}
