<?php

namespace App\Http\Controllers;

use App\Services\PropertyAmenityService;
use App\DTO\PropertyAmenityDTO;
use Illuminate\Http\Request;

class PropertyAmenityController extends Controller
{
    public function __construct(private PropertyAmenityService $propertyAmenityService) {}

    public function index()
    {
        return response()->json($this->propertyAmenityService->getAllPropertyAmenities());
    }

    public function show(int $property_id, int $amenity_id)
    {
        return response()->json($this->propertyAmenityService->getPropertyAmenityById($property_id, $amenity_id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer|exists:properties,id',
            'amenity_id' => 'required|integer|exists:amenities,id',
        ]);

        $propertyAmenityDTO = new PropertyAmenityDTO(
            $request->input('property_id'),
            $request->input('amenity_id')
        );
        $propertyAmenity = $this->propertyAmenityService->createPropertyAmenity($propertyAmenityDTO);

        return response()->json($propertyAmenity, 201);
    }

    public function destroy(int $property_id, int $amenity_id)
    {
        $this->propertyAmenityService->deletePropertyAmenity($property_id, $amenity_id);

        return response()->noContent();
    }
}
