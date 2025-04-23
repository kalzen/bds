<?php

namespace App\Http\Controllers;

use App\Models\PropertyAttribute;
use App\Services\PropertyAttributeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyAttributeController extends Controller
{
    protected PropertyAttributeService $service;

    public function __construct(PropertyAttributeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $attributes = PropertyAttribute::all();

        return Inertia::render('PropertyAttributes/Index', [
            'attributes' => $attributes,
            'emptyMessage' => $attributes->isEmpty() ? 'Không có thuộc tính nào.' : null,
        ]);
    }

    public function create()
    {
        return Inertia::render('PropertyAttributes/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->create($data);

        return redirect()->route('property-attributes.index')->with('success', 'Thuộc tính đã được tạo.');
    }

    public function edit($id)
    {
        $attribute = $this->service->getById($id);

        return Inertia::render('PropertyAttributes/Edit', [
            'attribute' => $attribute,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->update($id, $data);

        return redirect()->route('property-attributes.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('property-attributes.index')->with('success', 'Đã xoá thuộc tính.');
    }
}
