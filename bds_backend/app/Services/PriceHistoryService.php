<?php

namespace App\Services;

use App\Models\PriceHistory;

class PriceHistoryService
{
    public function create(array $data)
    {
        return PriceHistory::create($data);
    }

    public function findbyID(int $id)
    {
        return PriceHistory::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $priceHistory = PriceHistory::findOrFail($id);
        $priceHistory->update($data);
        return $priceHistory;
    }

    public function delete(int $id)
    {
        $priceHistory = PriceHistory::findOrFail($id);
        return $priceHistory->delete();
    }
}
