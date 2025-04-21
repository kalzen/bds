<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Services\CityService;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index()
    {
        return response()->json(City::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $city = $this->cityService->createCity($data);
        return response()->json($city, 201);
    }

    public function show($id)
    {
        $city = $this->cityService->getCityById($id);
        return response()->json($city);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $city = $this->cityService->updateCity($id, $data);
        return response()->json($city);
    }

    public function destroy($id)
    {
        $this->cityService->deleteCity($id);
        return response()->json(null, 204);
    }
}

