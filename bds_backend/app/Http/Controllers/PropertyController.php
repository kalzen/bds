<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Attribute;
use App\Models\District;
use App\Models\ListingType;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyAttribute;
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
        $properties = Property::with([
            'category:id,name',
            'project:id,name',
            'listingType:id,name',
            'location:id,address',
            'media',
            'propertyAttributes.attribute:id,name', // load attribute name
        ])->get()->map(function ($property) {
            // Format attribute string for display
            $property->attribute_display = $property->propertyAttributes
                ->map(function ($pa) {
                    return "{$pa->attribute->name}: {$pa->value}";
                })
                ->implode(', ');

            return $property;
        });

        return Inertia::render('projects/properties/propertyManagement', [
            'properties' => $properties,
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name']),
            'amenities' => Amenity::all(['id', 'name']),
            'attributes' => Attribute::all(['id', 'name', 'data_type']),
            'provinces' => Provinces::all(['id', 'name', 'code']),
            'districts' => District::all(['id', 'name', 'code', 'parent_code']),
            'wards' => Ward::all(['id', 'name', 'code', 'parent_code']),
            'listing_types' => ListingType::all(['id', 'name']),
            'emptyMessage' => $properties->isEmpty() ? 'Không có bất động sản nào.' : null,
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
            'attributes' => Attribute::all(['id', 'name', 'data_type']),
            'auth' => ['user' => auth()->user()],
        ]);
    }

    public function store(Request $request)
    {
        // ✅ Validate dữ liệu gửi từ form với các quy tắc cụ thể
        $data = $request->validate([
            'name' => 'required|string|max:255', // Tên là bắt buộc, chuỗi, tối đa 255 ký tự
            'price' => 'required|numeric', // Giá là bắt buộc và phải là số
            'description' => 'nullable|string', // Mô tả có thể không có, nếu có thì là chuỗi
            'image' => 'nullable|image|max:2048', // Hình ảnh không bắt buộc, nếu có thì là file ảnh < 2MB
            'project_id' => 'nullable|exists:projects,id', // ID dự án nếu có thì phải tồn tại trong bảng projects
            'category_id' => 'required|exists:property_categories,id', // ID danh mục là bắt buộc và phải tồn tại
            'listing_type_id' => 'required|exists:listing_types,id', // ID loại tin đăng là bắt buộc và phải tồn tại
            'location_id' => 'nullable|exists:locations,id', // ID vị trí có thể có và phải tồn tại
            'address' => 'nullable|string|max:255', // Địa chỉ không bắt buộc, tối đa 255 ký tự
            'attributes' => 'array', // Mảng các thuộc tính EAV (Entity-Attribute-Value)
            'attributes.*.id' => 'required|exists:attributes,id', // Mỗi thuộc tính phải có id tồn tại trong bảng attributes
            'attributes.*.value' => 'nullable|string', // Giá trị cho thuộc tính, có thể để trống
        ]);

        // ✅ Nếu có nhập địa chỉ, thì tạo mới bản ghi location
        if ($request->has('address')) {
            $location = \App\Models\Location::create([
                'address' => $request->input('address'),
            ]);
            // Gán ID vị trí vừa tạo vào mảng dữ liệu
            $data['location_id'] = $location->id;
        }

        // ✅ Gán ID người dùng đang đăng nhập cho bất động sản
        $data['user_id'] = auth()->id();

        // ✅ Gọi service để tạo mới property với dữ liệu đã xử lý
        $property = $this->service->create($data);
        dd($property);

        // ✅ Lưu các thuộc tính EAV nếu có
        foreach ($data['attributes'] ?? [] as $attr) {
            PropertyAttribute::create([
                'property_id' => $property->id,
                'attribute_id' => $attr['attribute_id'], // ✅ dùng đúng key
                'value' => $attr['value'],
            ]);
        }


        // ✅ Nếu có upload hình ảnh, thêm vào media collection "properties"
        if ($request->hasFile('image')) {
            $property->addMediaFromRequest('image')->toMediaCollection('properties');
        }

        // ✅ Chuyển hướng về trang danh sách và thông báo tạo thành công
        return redirect()->route('properties.index')->with('success', 'Bất động sản đã được tạo.');
    }


    public function edit($id)
    {
        $property = $this->service->getById($id);

        return Inertia::render('projects/properties/editProperty', [
            'property' => $property->load('propertyAttributes.attribute'),
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name']),
            'amenities' => Amenity::all(['id', 'name']),
            'listing_types' => ListingType::all(['id', 'name']),
            'attributes' => Attribute::all(['id', 'name', 'data_type']),
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
            'attributes' => 'array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'nullable|string',
        ]);

        $property = $this->service->update($id, $data);

        // Cập nhật EAV attributes
        foreach ($data['attributes'] ?? [] as $attr) {
            PropertyAttribute::updateOrCreate(
                [
                    'property_id' => $property->id,
                    'attribute_id' => $attr['id'],
                ],
                [
                    'value' => $attr['value'],
                ]
            );
        }

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
