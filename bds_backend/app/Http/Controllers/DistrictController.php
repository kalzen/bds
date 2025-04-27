<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\City;
use App\Services\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DistrictController extends Controller
{
    protected DistrictService $districtService;

    public function __construct(DistrictService $districtService)
    {
        $this->districtService = $districtService;
    }

    // ✅ Index - list districts
    public function index(Request $request)
    {
        $query = District::with('city');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($cityId = $request->input('city_id')) {
            $query->where('city_id', $cityId);
        }


        $districts = $query->get();
        $cities = City::all();
        Log::debug("quan thuoc thanh pho: " . $districts);
        Log::debug("thanh pho: " . $cities);
        return Inertia::render('location/location', [
            'districts' => $districts,
            'cities' => $cities,
            'filters' => $request->only('search', 'city_id'),
            'emptyMessage' => 'Không có quận nào.',
        ]);
    }

    // ✅ Store - create new district
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        District::create($validated);

        return redirect()->route('location')->with('success', 'Tạo quận thành công!');
    }

    // ✅ Edit - show form edit
    public function edit(District $district)
    {
        $cities = City::all();

        return Inertia::render('location/edit-district', [
            'district' => $district,
            'cities' => $cities,
        ]);
    }

    // ✅ Update - update existing district
    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $district->update($validated);

        return redirect()->route('location')->with('success', 'Cập nhật quận thành công!');
    }

    // ✅ Destroy - delete a district
    public function destroy(District $district)
    {
        $district->delete();

        return redirect()->route('location')->with('success', 'Xoá quận thành công!');
    }
}
