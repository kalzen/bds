<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    // ✅ Index - list locations
    public function index()
    {
        $locations = Location::all();

        return Inertia::render('Locations/Index', [
            'locations' => $locations,
            'emptyMessage' => $locations->isEmpty() ? 'Không có địa điểm nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('Locations/Create');
    }

    // ✅ Store location
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->locationService->create($data);

        return redirect()->route('locations.index')->with('success', 'Địa điểm đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $location = $this->locationService->getById($id);

        return Inertia::render('Locations/Edit', [
            'location' => $location,
        ]);
    }

    // ✅ Update location
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->locationService->update($id, $data);

        return redirect()->route('locations.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete location
    public function destroy($id)
    {
        $this->locationService->delete($id);

        return redirect()->route('locations.index')->with('success', 'Đã xoá địa điểm.');
    }
}
