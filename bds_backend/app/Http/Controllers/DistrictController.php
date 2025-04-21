<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use App\Services\DistrictService;

class DistrictController extends Controller
{
    protected $districtService;

    public function __construct(DistrictService $districtService)
    {
        $this->districtService = $districtService;
    }

    public function index()
    {
        return response()->json(District::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $district = $this->districtService->createDistrict($data);
        return response()->json($district, 201);
    }

    public function show($id)
    {
        $district = $this->districtService->getDistrictById($id);
        return response()->json($district);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $district = $this->districtService->updateDistrict($id, $data);
        return response()->json($district);
    }

    public function destroy($id)
    {
        $this->districtService->deleteDistrict($id);
        return response()->json(null, 204);
    }
}

