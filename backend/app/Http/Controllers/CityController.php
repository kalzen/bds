<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use App\DTO\CityDTO;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(private CityService $cityService) {}

    public function index()
    {
        return response()->json($this->cityService->getAllCities());
    }

    public function show(int $id)
    {
        return response()->json($this->cityService->getCityById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $cityDTO = new CityDTO($request->name);
        $city = $this->cityService->createCity($cityDTO);

        return response()->json($city, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $cityDTO = new CityDTO($request->name);
        $city = $this->cityService->updateCity($id, $cityDTO);

        return response()->json($city);
    }

    public function destroy(int $id)
    {
        $this->cityService->deleteCity($id);

        return response()->noContent();
    }
}
