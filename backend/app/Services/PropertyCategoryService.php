<?php

namespace App\Services;

use App\Models\PropertyCategory;
use App\DTO\PropertyCategoryDTO;

class PropertyCategoryService
{
    public function getAllCategories()
    {
        return PropertyCategory::all();
    }

    public function getCategoryById(int $id)
    {
        return PropertyCategory::findOrFail($id);
    }

    public function createCategory(PropertyCategoryDTO $categoryDTO)
    {
        try {
            return PropertyCategory::create([
                'name' => $categoryDTO->name,
            ]);
        }catch (\Exception $exception){
            echo "line 27: "+ $exception->getMessage();
        }
    }

    public function updateCategory(int $id, PropertyCategoryDTO $categoryDTO)
    {
        $category = PropertyCategory::findOrFail($id);
        $category->update([
            'name' => $categoryDTO->name,
        ]);
        return $category;
    }

    public function deleteCategory(int $id)
    {
        $category = PropertyCategory::findOrFail($id);
        $category->delete();
    }
}
