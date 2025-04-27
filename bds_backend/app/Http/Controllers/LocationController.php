<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Location;
use App\Models\Ward;
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
    public function index(Request $request)
    {
        // Lấy cities
        $cities = City::all();

        // Lấy districts có filter
        $query = District::with('city');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($cityId = $request->input('city_id')) {
            $query->where('city_id', $cityId);
        }

        $districts = $query->get();

        // Lấy wards có filter
        $wardQuery = Ward::with('district.city');

        if ($search = $request->input('search')) {
            $wardQuery->where('name', 'like', "%{$search}%");
        }

        if ($districtId = $request->input('district_id')) {
            $wardQuery->where('district_id', $districtId);
        }

        $wards = $wardQuery->get();

        return Inertia::render('location/location', [
            'cities' => $cities,
            'districts' => $districts,
            'wards' => $wards,
            'filters' => $request->only('search', 'city_id', 'district_id'),
            'emptyMessage' => 'Không có dữ liệu.',
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
