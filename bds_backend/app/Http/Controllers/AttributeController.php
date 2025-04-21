<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Services\AttributeService;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        return response()->json(Attribute::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $attribute = $this->attributeService->createAttribute($data);
        return response()->json($attribute, 201);
    }

    public function show($id)
    {
        $attribute = $this->attributeService->getAttributeById($id);
        return response()->json($attribute);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $attribute = $this->attributeService->updateAttribute($id, $data);
        return response()->json($attribute);
    }

    public function destroy($id)
    {
        $this->attributeService->deleteAttribute($id);
        return response()->json(null, 204);
    }
}

