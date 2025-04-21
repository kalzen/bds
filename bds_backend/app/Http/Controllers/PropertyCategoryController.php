<?php

namespace App\Http\Controllers;

use App\Models\PropertyCategory;
use App\Services\PropertyCategoryService;
use Illuminate\Http\Request;

class PropertyCategoryController extends Controller
{
    protected $service;

    public function __construct(PropertyCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(PropertyCategory::all());
    }

    public function show($id)
    {
        return response()->json($this->service->getPropertyCategoryById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->service->createPropertyCategory($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->service->updatePropertyCategory($id, $data));
    }

    public function destroy($id)
    {
        $this->service->deletePropertyCategory($id);
        return response()->json(null, 204);
    }
}
