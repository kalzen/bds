<?php

namespace App\Http\Controllers;

use App\Models\ListingType;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\PropertyCategory;
use App\Models\Project;
use App\Models\PropertyAmenity;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PropertyController extends Controller
{
    protected PropertyService $service;

    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $properties = Property::all();
        $listing_type = ListingType::all(['id', 'name']);
        return Inertia::render('projects/properties/propertyManagement', [
            'properties' => $properties,
            'categories' => PropertyCategory::all(),
            'projects' => Project::all(),
            'amenities' => Amenity::all(),
            'listing_types' => $listing_type,
            'emptyMessage' => $properties->isEmpty() ? 'Không có bất động sản nào.' : null,
            'auth' => [
                'user' => auth()->user(), // 👈 Thêm dòng này
            ],
        ]);

    }

    public function create()
    {
        $categories = PropertyCategory::all(['id', 'name']);
        $projects = Project::all(['id', 'name']);
        $amenities = PropertyAmenity::all(['id', 'name']);
        $listing_type = ListingType::all(['id', 'name']);
        return Inertia::render('projects/properties/propertyManagement', [
            'categories' => $categories,
            'projects' => $projects,
            'amenities' => $amenities,
            'listing_types' => $listing_type,
            'auth' => [
                'user' => auth()->user(), // 👈 Thêm dòng này
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $property = $this->service->create($data);

        if ($request->hasFile('image')) {
            $property->addMediaFromRequest('image')->toMediaCollection('properties');
        }

        return redirect()->route('properties.index')->with('success', 'Bất động sản đã được tạo.');
    }

    public function edit($id)
    {
        $property = $this->service->getById($id);
        $categories = PropertyCategory::all(['id', 'name']);
        $projects = Project::all(['id', 'name']);
        $amenities = PropertyAmenity::all(['id', 'name']);
        $listing_type = ListingType::all(['id', 'name']);

        return Inertia::render('projects/properties/propertyManagement', [
            'property' => $property,
            'categories' => $categories,
            'projects' => $projects,
            'amenities' => $amenities,
            'listing_types' => $listing_type,
            'auth' => [
                'user' => auth()->user(), // 👈 Thêm dòng này
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $property = $this->service->update($id, $data);

        if ($request->hasFile('image')) {
            $property->clearMediaCollection('properties');
            $property->addMediaFromRequest('image')->toMediaCollection('properties');
        }

        return redirect()->route('properties.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('properties.index')->with('success', 'Đã xoá bất động sản.');
    }
}
