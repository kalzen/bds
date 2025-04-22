<?php

namespace App\Services;

use App\Models\PropertyCategory;

class PropertyCategoryService
{
    public function create(array $data): PropertyCategory
    {
        return PropertyCategory::create($data);
    }

    public function findbyID(int $id): ?PropertyCategory
    {
        return PropertyCategory::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $category = PropertyCategory::find($id);
        return $category ? $category->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $category = PropertyCategory::find($id);
        return $category ? $category->delete() : false;
    }
}
