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
        $listingTypes = ListingType::with('media')->get();

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon'        => 'nullable|file|mimetypes:image/svg+xml|max:512',
        ]);

        // Tạo ListingType đúng
        $listType = ListingType::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        // Lưu icon nếu có
        if ($request->hasFile('icon')) {
            $listType
                ->addMediaFromRequest('icon')
                ->usingFileName('icon_' . uniqid() . '.svg')
                ->toMediaCollection('icon', 'public');
        }

        return redirect()->route('features')->with('success', 'Loại danh sách đã được tạo.');
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
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|file|mimetypes:image/svg+xml|max:512', // chỉ cho SVG
        ]);


        $listingType = $this->listingTypeService->update($id, $data);

        if ($request->hasFile('icon')) {
            $listingType->clearMediaCollection('icon');
            $listingType
                ->addMediaFromRequest('icon')
                ->usingFileName('icon_' . uniqid() . '.svg')
                ->toMediaCollection('icon');
        }

        return redirect()->route('features')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete listing type
    public function destroy($id)
    {
        $this->listingTypeService->delete($id);

        return redirect()->route('features')->with('success', 'Đã xoá loại danh sách.');
    }
}
