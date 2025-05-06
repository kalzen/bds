<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use App\Services\NewCategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsCategoryController extends Controller
{
    protected NewCategoryService $newsCategoryService;

    public function __construct(NewCategoryService $newsCategoryService)
    {
        $this->newsCategoryService = $newsCategoryService;
    }

    // 📄 Danh sách
    public function index()
    {
        $newsCategories = NewsCategory::all();

        return Inertia::render('newscategory/NewCategoryManagement', [
            'newscategory' => $newsCategories,
        ]);
    }

    // ➕ Tạo mới
    public function create()
    {
        return Inertia::render('newscategory/Create');
    }

    // 💾 Lưu mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->newsCategoryService->create($data);

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được tạo.');
    }

    // 🖊️ Sửa
    public function edit($id)
    {
        $category = $this->newsCategoryService->getById($id);

        return Inertia::render('NewsCategory/Edit', [
            'category' => $category,
        ]);
    }

    // 🔄 Cập nhật
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->newsCategoryService->update($id, $data);

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    // ❌ Xoá
    public function destroy($id)
    {
        $this->newsCategoryService->delete($id);

        return redirect()->route('categories.index')->with('success', 'Danh mục đã bị xoá.');
    }
}
