<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected $service;

    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(Property::all());
    }

    public function show($id)
    {
        return response()->json($this->service->getPropertyById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->service->createProperty($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->service->updateProperty($id, $data));
    }

    public function destroy($id)
    {
        $this->service->deleteProperty($id);
        return response()->json(null, 204);
    }
}
