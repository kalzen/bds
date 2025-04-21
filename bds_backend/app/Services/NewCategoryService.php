<?php

namespace App\Services;

use App\Models\NewCategory;

class NewCategoryService
{
    public function getNewCategoryById(int $id)
    {
        return NewCategory::findOrFail($id);
    }

    public function createNewCategory(array $data)
    {
        return NewCategory::create($data);
    }

    public function updateNewCategory(int $id, array $data)
    {
        $newCategory = NewCategory::findOrFail($id);
        $newCategory->update($data);

        return $newCategory;
    }

    public function deleteNewCategory(int $id)
    {
        $newCategory = NewCategory::findOrFail($id);
        $newCategory->delete();
    }
}
