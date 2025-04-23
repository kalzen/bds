<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Services\PriceHistoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PriceHistoryController extends Controller
{
    protected PriceHistoryService $priceHistoryService;

    public function __construct(PriceHistoryService $priceHistoryService)
    {
        $this->priceHistoryService = $priceHistoryService;
    }

    // ✅ Index - list price histories
    public function index()
    {
        $priceHistories = PriceHistory::all();

        return Inertia::render('PriceHistories/Index', [
            'priceHistories' => $priceHistories,
            'emptyMessage' => $priceHistories->isEmpty() ? 'Không có lịch sử giá nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('PriceHistories/Create');
    }

    // ✅ Store price history
    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $this->priceHistoryService->create($data);

        return redirect()->route('priceHistories.index')->with('success', 'Lịch sử giá đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $priceHistory = $this->priceHistoryService->getById($id);

        return Inertia::render('PriceHistories/Edit', [
            'priceHistory' => $priceHistory,
        ]);
    }

    // ✅ Update price history
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'property_id' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $this->priceHistoryService->update($id, $data);

        return redirect()->route('priceHistories.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete price history
    public function destroy($id)
    {
        $this->priceHistoryService->delete($id);

        return redirect()->route('priceHistories.index')->with('success', 'Đã xoá lịch sử giá.');
    }
}
