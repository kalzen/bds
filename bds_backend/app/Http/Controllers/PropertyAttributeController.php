<?php

namespace App\Http\Controllers;

use App\Models\PropertyAttribute;
use App\Services\PropertyAttributeService;
use Illuminate\Http\Request;

class PropertyAttributeController extends Controller
{
    protected $service;

    public function __construct(PropertyAttributeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(PropertyAttribute::all());
    }

    public function show($id)
    {
        return response()->json($this->service->getPropertyAttributeById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->service->createPropertyAttribute($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->service->updatePropertyAttribute($id, $data));
    }

    public function destroy($id)
    {
        $this->service->deletePropertyAttribute($id);
        return response()->json(null, 204);
    }
}
