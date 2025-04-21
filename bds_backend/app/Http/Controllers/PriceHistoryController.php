<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use Illuminate\Http\Request;
use App\Services\PriceHistoryService;

class PriceHistoryController extends Controller
{
    protected $priceHistoryService;

    public function __construct(PriceHistoryService $priceHistoryService)
    {
        $this->priceHistoryService = $priceHistoryService;
    }

    public function index()
    {
        return response()->json(PriceHistory::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->priceHistoryService->createPriceHistory($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->priceHistoryService->getPriceHistoryById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->priceHistoryService->updatePriceHistory($id, $data));
    }

    public function destroy($id)
    {
        $this->priceHistoryService->deletePriceHistory($id);
        return response()->json(null, 204);
    }
}
