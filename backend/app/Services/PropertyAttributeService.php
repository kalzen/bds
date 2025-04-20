<?php

namespace App\Services;

use App\Models\PropertyAttribute;
use App\DTO\PropertyAttributeDTO;

class PropertyAttributeService
{
    public function getAllPropertyAttributes()
    {
        return PropertyAttribute::all();
    }

    public function getPropertyAttributeById(int $property_id, int $attribute_id)
    {
        return PropertyAttribute::where('property_id', $property_id)
            ->where('attribute_id', $attribute_id)
            ->firstOrFail();
    }

    public function createPropertyAttribute(PropertyAttributeDTO $propertyAttributeDTO)
    {
        return PropertyAttribute::create([
            'property_id' => $propertyAttributeDTO->property_id,
            'attribute_id' => $propertyAttributeDTO->attribute_id,
            'value' => $propertyAttributeDTO->value,
        ]);
    }

    public function updatePropertyAttribute(int $property_id, int $attribute_id, PropertyAttributeDTO $propertyAttributeDTO)
    {
        $propertyAttribute = $this->getPropertyAttributeById($property_id, $attribute_id);
        $propertyAttribute->update([
            'value' => $propertyAttributeDTO->value,
        ]);
        return $propertyAttribute;
    }

    public function deletePropertyAttribute(int $property_id, int $attribute_id)
    {
        $propertyAttribute = $this->getPropertyAttributeById($property_id, $attribute_id);
        $propertyAttribute->delete();
    }
}
