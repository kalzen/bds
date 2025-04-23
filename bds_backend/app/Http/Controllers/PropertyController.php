<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    protected PropertyService $service;

    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $properties = Property::all();

        return Inertia::render('Properties/Index', [
            'properties' => $properties,
            'emptyMessage' => $properties->isEmpty() ? 'Không có bất động sản nào.' : null,
        ]);
    }

    public function create()
    {
        return Inertia::render('Properties/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->create($data);

        return redirect()->route('properties.index')->with('success', 'Bất động sản đã được tạo.');
    }

    public function edit($id)
    {
        $property = $this->service->getById($id);

        return Inertia::render('Properties/Edit', [
            'property' => $property,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->update($id, $data);

        return redirect()->route('properties.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('properties.index')->with('success', 'Đã xoá bất động sản.');
    }
}
