<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Services\AmenityService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AmenityController extends Controller
{
    protected AmenityService $amenityService;

    public function __construct(AmenityService $amenityService)
    {
        $this->amenityService = $amenityService;
    }

    // GET: /amenities
    public function index()
    {
        $amenities = Amenity::with('media')->get();

        return Inertia::render('amenities/Index', [
            'amenities' => $amenities,
            'emptyMessage' => $amenities->isEmpty() ? 'Không có tiện ích nào.' : null,
        ]);
    }

    // GET: /amenities/create
    public function create()
    {
        return Inertia::render('amenities/Create');
    }

    // POST: /amenities
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|file|mimetypes:image/svg+xml|max:512',
        ]);

        $amenity = Amenity::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->hasFile('icon')) {
            $amenity
                ->addMediaFromRequest('icon')
                ->usingFileName('icon_' . uniqid() . '.svg')
                ->toMediaCollection('icon', 'public');
        }

        return redirect()->route('features')->with('success', 'Tiện ích đã được tạo.');
    }

    // GET: /amenities/{id}/edit
    public function edit($id)
    {
        $amenity = $this->amenityService->getById($id)->load('media');

        return Inertia::render('amenities/Edit', [
            'amenity' => $amenity,
            'icon_url' => $amenity->getFirstMediaUrl('icon'),
        ]);
    }

    // PUT: /amenities/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|file|mimetypes:image/svg+xml|max:512',
        ]);

        $amenity = $this->amenityService->update($id, $validated);

        if ($request->hasFile('icon')) {
            $amenity->clearMediaCollection('icon');
            $amenity
                ->addMediaFromRequest('icon')
                ->usingFileName('icon_' . uniqid() . '.svg')
                ->toMediaCollection('icon');
        }

        return redirect()->route('features')->with('success', 'Cập nhật thành công.');
    }

    // DELETE: /amenities/{id}
    public function destroy($id)
    {
        $this->amenityService->delete($id);

        return redirect()->route('features')->with('success', 'Đã xoá tiện ích.');
    }
}
