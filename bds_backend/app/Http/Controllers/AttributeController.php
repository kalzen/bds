<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Services\AttributeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttributeController extends Controller
{
    protected AttributeService $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    // ✅ Index - list attributes
    public function index()
    {
        $attributes = Attribute::all();

        return Inertia::render('Attributes/Index', [
            'attributes' => $attributes,
            'emptyMessage' => $attributes->isEmpty() ? 'Không có thuộc tính nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('Attributes/Create');
    }

    // ✅ Store attribute
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'data_type' => 'required|string|max:255', // 👈 đảm bảo validate & nhận đúng
        ]);

        Attribute::create($validated);

        return redirect()->back()->with('message', 'Thuộc tính đã được tạo.');
    }


    // ✅ Show edit form
    public function edit($id)
    {
        $attribute = $this->attributeService->getById($id);

        return Inertia::render('Attributes/Edit', [
            'attribute' => $attribute,
        ]);
    }

    // ✅ Update attribute
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->attributeService->update($id, $data);

        return redirect()->route('features')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete attribute
    public function destroy($id)
    {
        $this->attributeService->delete($id);

        return redirect()->route('features')->with('success', 'Đã xoá thuộc tính.');
    }
}
