<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Services\PropertyAmenityService;
use Illuminate\Http\Request;

class PropertyAmenityController extends Controller
{
    protected $service;

    public function __construct(PropertyAmenityService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(PropertyAmenity::all());
    }

    public function show($id)
    {
        return response()->json($this->service->getPropertyAmenityById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->service->createPropertyAmenity($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->service->updatePropertyAmenity($id, $data));
    }

    public function destroy($id)
    {
        $this->service->deletePropertyAmenity($id);
        return response()->json(null, 204);
    }
}
