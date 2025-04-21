<?php

use App\Models\PropertyAttribute;

class PropertyAttributeService
{
    public function createPropertyAttribute(array $data)
    {
        return PropertyAttribute::create($data);
    }

    public function getPropertyAttributeById(int $id)
    {
        return PropertyAttribute::findOrFail($id);
    }

    public function updatePropertyAttribute(int $id, array $data)
    {
        $attribute = PropertyAttribute::findOrFail($id);
        $attribute->update($data);

        return $attribute;
    }

    public function deletePropertyAttribute(int $id)
    {
        $attribute = PropertyAttribute::findOrFail($id);
        $attribute->delete();
    }
}
