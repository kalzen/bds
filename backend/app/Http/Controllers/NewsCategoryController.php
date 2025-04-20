<?php

namespace App\Http\Controllers;

use App\Services\NewsCategoryService;
use App\DTO\NewsCategoryDTO;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    private $newsCategoryService;

    public function __construct(NewsCategoryService $newsCategoryService)
    {
        $this->newsCategoryService = $newsCategoryService;
    }

    public function index()
    {
        return response()->json($this->newsCategoryService->getAllNewsCategories());
    }

    public function show(int $id)
    {
        return response()->json($this->newsCategoryService->getNewsCategoryById($id));
    }

    public function store(Request $request)
    {
        $newsCategoryDTO = new NewsCategoryDTO(
            $request->input('name'),
            $request->input('slug'),
            $request->input('description')
        );
        $newsCategory = $this->newsCategoryService->createNewsCategory($newsCategoryDTO);
        return response()->json($newsCategory, 201);
    }

    public function update(Request $request, int $id)
    {
        $newsCategoryDTO = new NewsCategoryDTO(
            $request->input('name'),
            $request->input('slug'),
            $request->input('description')
        );
        $newsCategory = $this->newsCategoryService->updateNewsCategory($id, $newsCategoryDTO);
        return response()->json($newsCategory);
    }

    public function destroy(int $id)
    {
        $this->newsCategoryService->deleteNewsCategory($id);
        return response()->json(null, 204);
    }
}
