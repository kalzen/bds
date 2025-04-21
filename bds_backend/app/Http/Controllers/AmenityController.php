<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Services\AmenityService;
use App\DTO\AmenityDTO;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    protected $amenityService;

    public function __construct(AmenityService $amenityService)
    {
        $this->amenityService = $amenityService;
    }

    public function index()
    {
        return response()->json(Amenity::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $amenity = $this->amenityService->createAmenity($data);
        return response()->json($amenity, 201);
    }

    public function show($id)
    {
        $amenity = $this->amenityService->getAmenityById($id);
        return response()->json($amenity);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $amenity = $this->amenityService->updateAmenity($id, $data);
        return response()->json($amenity);
    }

    public function destroy($id)
    {
        $this->amenityService->deleteAmenity($id);
        return response()->json(null, 204);
    }
}

