<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Services\AmenityService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AmenityController extends Controller
{
    protected AmenityService $amenityService;

    public function __construct(AmenityService $amenityService)
    {
        $this->amenityService = $amenityService;
    }

    // ✅ Index - list amenities
    public function index()
    {
        $amenities = Amenity::all();

        return Inertia::render('amenities/Index', [
            'amenities' => $amenities,
            'emptyMessage' => $amenities->isEmpty() ? 'Không có tiện ích nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('amenities/Create');
    }

    // ✅ Store amenity
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->amenityService->create($data);

        return redirect()->route('features')->with('success', 'Tiện ích đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $amenity = $this->amenityService->getById($id);

        return Inertia::render('amenities/Edit', [
            'amenity' => $amenity,
        ]);
    }

    // ✅ Update amenity
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->amenityService->update($id, $data);

        return redirect()->route('features')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete amenity
    public function destroy($id)
    {
        $this->amenityService->delete($id);

        return redirect()->route('features')->with('success', 'Đã xoá tiện ích.');
    }
}
