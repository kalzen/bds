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

        return Inertia::render('Cities/Index', [
            'cities' => $cities,
            'emptyMessage' => $cities->isEmpty() ? 'Không có thành phố nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('Cities/Create');
    }

    // ✅ Store city
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->cityService->create($data);

        return redirect()->route('cities.index')->with('success', 'Thành phố đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $city = $this->cityService->getById($id);

        return Inertia::render('Cities/Edit', [
            'city' => $city,
        ]);
    }

    // ✅ Update city
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->cityService->update($id, $data);

        return redirect()->route('cities.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete city
    public function destroy($id)
    {
        $this->cityService->delete($id);

        return redirect()->route('cities.index')->with('success', 'Đã xoá thành phố.');
    }
}
