<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use Illuminate\Http\Request;
use App\Services\NewCategoryService;

class NewsCategoryController extends Controller
{
    protected $newCategoryService;

    public function __construct(NewCategoryService $newCategoryService)
    {
        $this->newCategoryService = $newCategoryService;
    }

    public function index()
    {
        return response()->json(NewsCategory::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->newCategoryService->createNewCategory($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->newCategoryService->getNewCategoryById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->newCategoryService->updateNewCategory($id, $data));
    }

    public function destroy($id)
    {
        $this->newCategoryService->deleteNewCategory($id);
        return response()->json(null, 204);
    }
}
