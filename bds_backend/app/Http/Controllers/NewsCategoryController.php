<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use App\Services\NewsCategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsCategoryController extends Controller
{
    protected NewsCategoryService $newsCategoryService;

    public function __construct(NewsCategoryService $newsCategoryService)
    {
        $this->newsCategoryService = $newsCategoryService;
    }

    // ✅ Index - list news categories
    public function index()
    {
        $newsCategories = NewsCategory::all();

        return Inertia::render('NewsCategories/Index', [
            'newsCategories' => $newsCategories,
            'emptyMessage' => $newsCategories->isEmpty() ? 'Không có danh mục tin tức nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('NewsCategories/Create');
    }

    // ✅ Store news category
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->newsCategoryService->create($data);

        return redirect()->route('news-categories.index')->with('success', 'Danh mục tin tức đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $newsCategory = $this->newsCategoryService->getById($id);

        return Inertia::render('NewsCategories/Edit', [
            'newsCategory' => $newsCategory,
        ]);
    }

    // ✅ Update news category
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->newsCategoryService->update($id, $data);

        return redirect()->route('news-categories.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete news category
    public function destroy($id)
    {
        $this->newsCategoryService->delete($id);

        return redirect()->route('news-categories.index')->with('success', 'Đã xoá danh mục tin tức.');
    }
}
