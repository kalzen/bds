<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Services\LocationService;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index()
    {
        return response()->json(Location::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->locationService->createLocation($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->locationService->getLocationById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->locationService->updateLocation($id, $data));
    }

    public function destroy($id)
    {
        $this->locationService->deleteLocation($id);
        return response()->json(null, 204);
    }
}
