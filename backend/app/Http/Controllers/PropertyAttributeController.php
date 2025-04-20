<?php

namespace App\Http\Controllers;

use App\Services\PropertyAttributeService;
use App\DTO\PropertyAttributeDTO;
use Illuminate\Http\Request;

class PropertyAttributeController extends Controller
{
    public function __construct(private PropertyAttributeService $propertyAttributeService) {}

    public function index()
    {
        return response()->json($this->propertyAttributeService->getAllPropertyAttributes());
    }

    public function show(int $property_id, int $attribute_id)
    {
        return response()->json($this->propertyAttributeService->getPropertyAttributeById($property_id, $attribute_id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer|exists:properties,id',
            'attribute_id' => 'required|integer|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $propertyAttributeDTO = new PropertyAttributeDTO(
            $request->input('property_id'),
            $request->input('attribute_id'),
            $request->input('value')
        );
        $propertyAttribute = $this->propertyAttributeService->createPropertyAttribute($propertyAttributeDTO);

        return response()->json($propertyAttribute, 201);
    }

    public function update(Request $request, int $property_id, int $attribute_id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $propertyAttributeDTO = new PropertyAttributeDTO(
            $property_id,
            $attribute_id,
            $request->input('value')
        );
        $propertyAttribute = $this->propertyAttributeService->updatePropertyAttribute($property_id, $attribute_id, $propertyAttributeDTO);

        return response()->json($propertyAttribute);
    }

    public function destroy(int $property_id, int $attribute_id)
    {
        $this->propertyAttributeService->deletePropertyAttribute($property_id, $attribute_id);

        return response()->noContent();
    }
}
