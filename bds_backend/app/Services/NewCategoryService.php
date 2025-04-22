<?php

namespace App\Services;

use App\Models\NewsCategory;

class NewCategoryService
{
    public function create(array $data)
    {
        return NewsCategory::create($data);
    }

    public function findbyID(int $id)
    {
        return NewsCategory::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $category = NewsCategory::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id)
    {
        $category = NewsCategory::findOrFail($id);
        return $category->delete();
    }
}
