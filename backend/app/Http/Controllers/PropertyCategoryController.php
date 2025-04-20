<?php

namespace App\Http\Controllers;

use App\Services\PropertyCategoryService;
use App\DTO\PropertyCategoryDTO;
use Illuminate\Http\Request;

class PropertyCategoryController
{
    private $propertyCategoryService;

    public function __construct(PropertyCategoryService $propertyCategoryService)
    {
        $this->propertyCategoryService = $propertyCategoryService;
    }

    public function index()
    {
        return response()->json($this->propertyCategoryService->getAllCategories());
    }

    public function show(int $id)
    {
        return response()->json($this->propertyCategoryService->getCategoryById($id));
    }

    public function store(Request $request)
    {
        $categoryDTO = new PropertyCategoryDTO($request->only(['name']));
        $category = $this->propertyCategoryService->createCategory($categoryDTO);
        return response()->json($category, 201);
    }

    public function update(Request $request, int $id)
    {
        $categoryDTO = new PropertyCategoryDTO($request->only(['name']));
        $category = $this->propertyCategoryService->updateCategory($id, $categoryDTO);
        return response()->json($category);
    }

    public function destroy(int $id)
    {
        $this->propertyCategoryService->deleteCategory($id);
        return response()->json(null, 204);
    }
}
