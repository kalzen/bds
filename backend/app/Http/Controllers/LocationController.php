<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use App\DTO\LocationDTO;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct(private LocationService $locationService) {}

    public function index()
    {
        return response()->json($this->locationService->getAllLocations());
    }

    public function show(int $id)
    {
        return response()->json($this->locationService->getLocationById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ward_id' => 'required|integer|exists:wards,id',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $locationDTO = new LocationDTO(
            $request->ward_id,
            $request->address,
            $request->latitude,
            $request->longitude
        );
        $location = $this->locationService->createLocation($locationDTO);

        return response()->json($location, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'ward_id' => 'required|integer|exists:wards,id',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $locationDTO = new LocationDTO(
            $request->ward_id,
            $request->address,
            $request->latitude,
            $request->longitude
        );
        $location = $this->locationService->updateLocation($id, $locationDTO);

        return response()->json($location);
    }

    public function destroy(int $id)
    {
        $this->locationService->deleteLocation($id);

        return response()->noContent();
    }
}
