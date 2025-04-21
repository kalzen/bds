<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Services\CityService;
use Inertia\Inertia;

class CityController extends Controller
{
    protected $cityService;


    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;

    }

    public function index()
    {
        $cities = City::all();

        return Inertia::render('Cities/Index', [
            'cities' => $cities
        ]);
    }
    // Hiển thị form tạo thành phố
    public function create()
    {
        return Inertia::render('Cities/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->cityService->createCity($data);
        return redirect()->route('cities.index')->with('success', 'City created successfully!');
    }

    // Hiển thị 1 thành phố cụ thể
    public function show($id)
    {
        $city = $this->cityService->getCityById($id);
        return Inertia::render('Cities/Show', [
            'city' => $city
        ]);
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $city = $this->cityService->getCityById($id);
        return Inertia::render('Cities/Edit', [
            'city' => $city
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->cityService->updateCity($id, $data);
        return redirect()->route('cities.index')->with('success', 'City updated successfully!');
    }

    public function destroy($id)
    {
        $this->cityService->deleteCity($id);
        return redirect()->route('cities.index')->with('success', 'City deleted.');
    }
}
