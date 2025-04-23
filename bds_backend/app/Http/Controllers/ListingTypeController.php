<?php

namespace App\Http\Controllers;

use App\Models\ListingType;
use App\Services\ListingTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListingTypeController extends Controller
{
    protected ListingTypeService $listingTypeService;

    public function __construct(ListingTypeService $listingTypeService)
    {
        $this->listingTypeService = $listingTypeService;
    }

    // ✅ Index - list listing types
    public function index()
    {
        $listingTypes = ListingType::all();

        return Inertia::render('ListingTypes/Index', [
            'listingTypes' => $listingTypes,
            'emptyMessage' => $listingTypes->isEmpty() ? 'Không có loại danh sách nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('ListingTypes/Create');
    }

    // ✅ Store listing type
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->listingTypeService->create($data);

        return redirect()->route('listing-types.index')->with('success', 'Loại danh sách đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $listingType = $this->listingTypeService->getById($id);

        return Inertia::render('ListingTypes/Edit', [
            'listingType' => $listingType,
        ]);
    }

    // ✅ Update listing type
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->listingTypeService->update($id, $data);

        return redirect()->route('listing-types.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete listing type
    public function destroy($id)
    {
        $this->listingTypeService->delete($id);

        return redirect()->route('listing-types.index')->with('success', 'Đã xoá loại danh sách.');
    }
}
