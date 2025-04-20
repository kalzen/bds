<?php

namespace App\Http\Controllers;

use App\Services\WardService;
use App\DTO\WardDTO;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function __construct(private WardService $wardService) {}

    public function index()
    {
        return response()->json($this->wardService->getAllWards());
    }

    public function show(int $id)
    {
        return response()->json($this->wardService->getWardById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'district_id' => 'required|integer|exists:districts,id',
            'name' => 'required|string|max:255',
        ]);

        $wardDTO = new WardDTO($request->district_id, $request->name);
        $ward = $this->wardService->createWard($wardDTO);

        return response()->json($ward, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'district_id' => 'required|integer|exists:districts,id',
            'name' => 'required|string|max:255',
        ]);

        $wardDTO = new WardDTO($request->district_id, $request->name);
        $ward = $this->wardService->updateWard($id, $wardDTO);

        return response()->json($ward);
    }

    public function destroy(int $id)
    {
        $this->wardService->deleteWard($id);

        return response()->noContent();
    }
}
