<?php

namespace App\Services;

use App\Models\NewsCategory;
use App\DTO\NewsCategoryDTO;
use Exception;

class NewsCategoryService
{
    public function getAllNewsCategories()
    {
        try {
            return NewsCategory::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getNewsCategoryById(int $id)
    {
        try {
            return NewsCategory::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createNewsCategory(NewsCategoryDTO $newsCategoryDTO)
    {
        try {
            return NewsCategory::create([
                'name' => $newsCategoryDTO->name,
                'slug' => $newsCategoryDTO->slug,
                'description' => $newsCategoryDTO->description,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateNewsCategory(int $id, NewsCategoryDTO $newsCategoryDTO)
    {
        try {
            $newsCategory = NewsCategory::findOrFail($id);
            $newsCategory->update([
                'name' => $newsCategoryDTO->name,
                'slug' => $newsCategoryDTO->slug,
                'description' => $newsCategoryDTO->description,
            ]);
            return $newsCategory;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteNewsCategory(int $id)
    {
        try {
            $newsCategory = NewsCategory::findOrFail($id);
            $newsCategory->delete();
            return ['message' => 'NewsCategory deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
