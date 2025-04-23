<?php

namespace App\Http\Controllers;

use App\Models\PropertyAmenity;
use App\Services\PropertyAmenityService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyAmenityController extends Controller
{
    protected PropertyAmenityService $service;

    public function __construct(PropertyAmenityService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $amenities = PropertyAmenity::all();

        return Inertia::render('PropertyAmenities/Index', [
            'amenities' => $amenities,
            'emptyMessage' => $amenities->isEmpty() ? 'Không có tiện ích nào.' : null,
        ]);
    }

    public function create()
    {
        return Inertia::render('PropertyAmenities/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->create($data);

        return redirect()->route('property-amenities.index')->with('success', 'Tiện ích đã được tạo.');
    }

    public function edit($id)
    {
        $amenity = $this->service->getById($id);

        return Inertia::render('PropertyAmenities/Edit', [
            'amenity' => $amenity,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->update($id, $data);

        return redirect()->route('property-amenities.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('property-amenities.index')->with('success', 'Đã xoá tiện ích.');
    }
}
