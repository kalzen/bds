<?php

namespace App\Services;

use App\Models\PriceHistory;
use App\DTO\PriceHistoryDTO;

class PriceHistoryService
{
    public function getAllPriceHistories()
    {
        return PriceHistory::all();
    }

    public function getPriceHistoryById(int $id)
    {
        return PriceHistory::findOrFail($id);
    }

    public function createPriceHistory(PriceHistoryDTO $priceHistoryDTO)
    {
        return PriceHistory::create([
            'property_id' => $priceHistoryDTO->property_id,
            'price' => $priceHistoryDTO->price,
            'changed_at' => $priceHistoryDTO->changed_at,
        ]);
    }

    public function deletePriceHistory(int $id)
    {
        $priceHistory = PriceHistory::findOrFail($id);
        $priceHistory->delete();
    }
}
