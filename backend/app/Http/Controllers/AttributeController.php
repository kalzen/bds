<?php

namespace App\Http\Controllers;

use App\Services\AttributeService;
use App\DTO\AttributeDTO;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function __construct(private AttributeService $attributeService) {}

    public function index()
    {
        return response()->json($this->attributeService->getAllAttributes());
    }

    public function show(int $id)
    {
        return response()->json($this->attributeService->getAttributeById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'data_type' => 'required|string|max:50',
            'unit' => 'nullable|string|max:50',
        ]);

        $attributeDTO = new AttributeDTO(
            $request->input('name'),
            $request->input('data_type'),
            $request->input('unit')
        );
        $attribute = $this->attributeService->createAttribute($attributeDTO);

        return response()->json($attribute, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'data_type' => 'required|string|max:50',
            'unit' => 'nullable|string|max:50',
        ]);

        $attributeDTO = new AttributeDTO(
            $request->input('name'),
            $request->input('data_type'),
            $request->input('unit')
        );
        $attribute = $this->attributeService->updateAttribute($id, $attributeDTO);

        return response()->json($attribute);
    }

    public function destroy(int $id)
    {
        $this->attributeService->deleteAttribute($id);

        return response()->noContent();
    }
}
