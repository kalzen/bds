<?php

namespace App\Http\Controllers;

use App\Models\PropertyCategory;
use App\Services\PropertyCategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyCategoryController extends Controller
{
    protected PropertyCategoryService $service;

    public function __construct(PropertyCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $categories = PropertyCategory::all();

        return Inertia::render('PropertyCategories/Index', [
            'categories' => $categories,
            'emptyMessage' => $categories->isEmpty() ? 'Không có danh mục nào.' : null,
        ]);
    }

    public function create()
    {
        return Inertia::render('PropertyCategories/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->create($data);

        return redirect()->route('features')->with('success', 'Danh mục đã được tạo.');
    }

    public function edit($id)
    {
        $category = $this->service->getById($id);

        return Inertia::render('PropertyCategories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->update($id, $data);

        return redirect()->route('features')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('features')->with('success', 'Đã xoá danh mục.');
    }
}
