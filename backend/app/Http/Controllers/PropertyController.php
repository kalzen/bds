<?php

namespace App\Http\Controllers;

use App\Services\PropertyService;
use App\DTO\PropertyDTO;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index()
    {
        return response()->json($this->propertyService->getAllProperties());
    }

    public function show(int $id)
    {
        return response()->json($this->propertyService->getPropertyById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'listing_type_id' => 'required|integer|exists:listing_types,id',
            'category_id' => 'required|integer|exists:property_categories,id',
            'location_id' => 'required|integer|exists:locations,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'legal_status' => 'required|string|max:255',
            'direction' => 'required|string|max:50',
            'project_id' => 'nullable|integer|exists:projects,id',
            'attribute_id' => 'nullable|integer|exists:attributes,id',
            'description' => 'nullable|string',
            'furniture' => 'nullable|string|max:255',
        ]);

        $propertyDTO = new PropertyDTO(
            $request->input('user_id'),
            $request->input('listing_type_id'),
            $request->input('category_id'),
            $request->input('location_id'),
            $request->input('title'),
            $request->input('price'),
            $request->input('legal_status'),
            $request->input('direction'),
            $request->input('project_id'),
            $request->input('attribute_id'),
            $request->input('description'),
            $request->input('furniture')
        );
        $property = $this->propertyService->createProperty($propertyDTO);

        return response()->json($property, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'listing_type_id' => 'required|integer|exists:listing_types,id',
            'category_id' => 'required|integer|exists:property_categories,id',
            'location_id' => 'required|integer|exists:locations,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'legal_status' => 'required|string|max:255',
            'direction' => 'required|string|max:50',
            'project_id' => 'nullable|integer|exists:projects,id',
            'attribute_id' => 'nullable|integer|exists:attributes,id',
            'description' => 'nullable|string',
            'furniture' => 'nullable|string|max:255',
        ]);

        $propertyDTO = new PropertyDTO(
            $request->input('user_id'),
            $request->input('listing_type_id'),
            $request->input('category_id'),
            $request->input('location_id'),
            $request->input('title'),
            $request->input('price'),
            $request->input('legal_status'),
            $request->input('direction'),
            $request->input('project_id'),
            $request->input('attribute_id'),
            $request->input('description'),
            $request->input('furniture')
        );
        $property = $this->propertyService->updateProperty($id, $propertyDTO);

        return response()->json($property);
    }

    public function destroy(int $id)
    {
        $this->propertyService->deleteProperty($id);

        return response()->noContent();
    }
}
