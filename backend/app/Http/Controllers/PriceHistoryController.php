<?php

namespace App\Http\Controllers;

use App\Services\PriceHistoryService;
use App\DTO\PriceHistoryDTO;
use Illuminate\Http\Request;

class PriceHistoryController extends Controller
{
    public function __construct(private PriceHistoryService $priceHistoryService) {}

    public function index()
    {
        return response()->json($this->priceHistoryService->getAllPriceHistories());
    }

    public function show(int $id)
    {
        return response()->json($this->priceHistoryService->getPriceHistoryById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer|exists:properties,id',
            'price' => 'required|numeric',
            'changed_at' => 'nullable|date',
        ]);

        $priceHistoryDTO = new PriceHistoryDTO(
            $request->input('property_id'),
            $request->input('price'),
            $request->input('changed_at')
        );
        $priceHistory = $this->priceHistoryService->createPriceHistory($priceHistoryDTO);

        return response()->json($priceHistory, 201);
    }

    public function destroy(int $id)
    {
        $this->priceHistoryService->deletePriceHistory($id);

        return response()->noContent();
    }
}
