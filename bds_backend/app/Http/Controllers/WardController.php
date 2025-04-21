<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Services\WardService;
use Illuminate\Http\Request;

class WardController extends Controller
{
    protected $service;

    public function __construct(WardService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(Ward::all());
    }

    public function show($id)
    {
        return response()->json($this->service->getWardById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->service->createWard($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->service->updateWard($id, $data));
    }

    public function destroy($id)
    {
        $this->service->deleteWard($id);
        return response()->json(null, 204);
    }
}
