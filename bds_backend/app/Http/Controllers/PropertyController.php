<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\District;
use App\Models\ListingType;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Provinces;
use App\Models\Ward;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    protected PropertyService $service;

    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {


        return Inertia::render('projects/properties/propertyManagement', [
            'properties' => Property::with([
                'category:id,name',
                'project:id,name',
                'listingType:id,name',
                'location:id,address',
                'attributes:id,name',
                'media',
            ])->get(),
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name']),
            'amenities' => Amenity::all(['id', 'name']),
            'provinces' => Provinces::all(['id', 'name', 'code']),
            'districts' => District::all(['id', 'name', 'code', 'parent_code']),
            'wards' => Ward::all(['id', 'name', 'code', 'parent_code']),
            'listing_types' => ListingType::all(['id', 'name']),
            'emptyMessage' => Property::all()->isEmpty() ? 'Không có bất động sản nào.' : null,
            'auth' => ['user' => auth()->user()],
        ]);
    }

    public function create()
    {
        return Inertia::render('projects/properties/createProperty', [
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name']),
            'amenities' => Amenity::all(['id', 'name']),
            'listing_types' => ListingType::all(['id', 'name']),
            'auth' => ['user' => auth()->user()],
        ]);
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'required|exists:property_categories,id',
            'listing_type_id' => 'required|exists:listing_types,id',
            'location_id' => 'nullable|exists:locations,id',
            'address' => 'nullable|string|max:255',  // Thêm xác thực cho trường address
        ]);

        // Nếu có địa chỉ, tạo hoặc cập nhật bảng location
        if ($request->has('address')) {
            $location = \App\Models\Location::create([
                'address' => $request->input('address'),
                // Nếu cần thêm thông tin khác vào bảng location, bạn có thể bổ sung ở đây
            ]);

            // Cập nhật location_id trong $data với id của location mới tạo
            $data['location_id'] = $location->id;
        }
        $data['user_id'] = auth()->id();
        // Tạo mới bất động sản
        $property = $this->service->create($data);

        // Xử lý hình ảnh (nếu có)
        if ($request->hasFile('image')) {
            $property->addMediaFromRequest('image')->toMediaCollection('properties');
        }

        // Chuyển hướng và thông báo thành công
        return redirect()->route('properties.index')->with('success', 'Bất động sản đã được tạo.');
    }


    public function edit($id)
    {
        $property = $this->service->getById($id);

        return Inertia::render('projects/properties/editProperty', [
            'property' => $property,
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name']),
            'amenities' => Amenity::all(['id', 'name']),
            'listing_types' => ListingType::all(['id', 'name']),
            'auth' => ['user' => auth()->user()],
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'required|exists:property_categories,id',
            'listing_type_id' => 'required|exists:listing_types,id',
            'location_id' => 'required|exists:locations,id',
        ]);

        $property = $this->service->update($id, $data);

        if ($request->hasFile('image')) {
            $property->clearMediaCollection('properties');
            $property->addMediaFromRequest('image')->toMediaCollection('properties');
        }

        return redirect()->route('properties.index')->with('success', 'Cập nhật bất động sản thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('properties.index')->with('success', 'Bất động sản đã được xoá.');
    }
}
