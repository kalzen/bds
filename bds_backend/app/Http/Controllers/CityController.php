<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    // ✅ Index - list cities
    public function index()
    {
        $cities = City::all();

        return Inertia::render('location/location', [
            'cities' => $cities,
            'emptyMessage' => $cities->isEmpty() ? 'Không có thành phố nào.' : null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->cityService->create($data);

        return redirect()->route('location')->with('success', 'Thành phố đã được tạo.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->cityService->update($id, $data);

        return redirect()->route('location')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->cityService->delete($id);

        return redirect()->route('location')->with('success', 'Đã xoá thành phố.');
    }

}
