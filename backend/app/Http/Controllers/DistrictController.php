<?php

namespace App\Http\Controllers;

use App\Services\DistrictService;
use App\DTO\DistrictDTO;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __construct(private DistrictService $districtService) {}

    public function index()
    {
        return response()->json($this->districtService->getAllDistricts());
    }

    public function show(int $id)
    {
        return response()->json($this->districtService->getDistrictById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|integer|exists:cities,id',
            'name' => 'required|string|max:255',
        ]);

        $districtDTO = new DistrictDTO($request->city_id, $request->name);
        $district = $this->districtService->createDistrict($districtDTO);

        return response()->json($district, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'city_id' => 'required|integer|exists:cities,id',
            'name' => 'required|string|max:255',
        ]);

        $districtDTO = new DistrictDTO($request->city_id, $request->name);
        $district = $this->districtService->updateDistrict($id, $districtDTO);

        return response()->json($district);
    }

    public function destroy(int $id)
    {
        $this->districtService->deleteDistrict($id);

        return response()->noContent();
    }
}
