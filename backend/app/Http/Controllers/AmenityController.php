<?php

namespace App\Http\Controllers;

use App\Services\AmenityService;
use App\DTO\AmenityDTO;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function __construct(private AmenityService $amenityService) {}

    public function index()
    {
        return response()->json($this->amenityService->getAllAmenities());
    }

    public function show(int $id)
    {
        return response()->json($this->amenityService->getAmenityById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $amenityDTO = new AmenityDTO(
            $request->input('name')
        );
        $amenity = $this->amenityService->createAmenity($amenityDTO);

        return response()->json($amenity, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $amenityDTO = new AmenityDTO(
            $request->input('name')
        );
        $amenity = $this->amenityService->updateAmenity($id, $amenityDTO);

        return response()->json($amenity);
    }

    public function destroy(int $id)
    {
        $this->amenityService->deleteAmenity($id);

        return response()->noContent();
    }
}
