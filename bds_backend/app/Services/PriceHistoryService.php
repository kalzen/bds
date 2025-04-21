<?php

namespace App\Services;

use App\Models\PriceHistory;

class PriceHistoryService
{
    public function getPriceHistoryById(int $id)
    {
        return PriceHistory::findOrFail($id);
    }

    public function createPriceHistory(array $data)
    {
        return PriceHistory::create($data);
    }

    public function updatePriceHistory(int $id, array $data)
    {
        $priceHistory = PriceHistory::findOrFail($id);
        $priceHistory->update($data);

        return $priceHistory;
    }

    public function deletePriceHistory(int $id)
    {
        $priceHistory = PriceHistory::findOrFail($id);
        $priceHistory->delete();
    }
}
