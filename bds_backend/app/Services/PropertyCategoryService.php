<?php

use App\Models\PropertyCategory;

class PropertyCategoryService
{
    public function createPropertyCategory(array $data)
    {
        return PropertyCategory::create($data);
    }

    public function getPropertyCategoryById(int $id)
    {
        return PropertyCategory::findOrFail($id);
    }

    public function updatePropertyCategory(int $id, array $data)
    {
        $category = PropertyCategory::findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function deletePropertyCategory(int $id)
    {
        $category = PropertyCategory::findOrFail($id);
        $category->delete();
    }
}
