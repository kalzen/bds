<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Attribute;
use App\Models\District;
use App\Models\ListingType;
use App\Models\Location;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyCategory;
use App\Models\PropertyAttribute;
use App\Models\Provinces;
use App\Models\Ward;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with([
            'category:id,name',
            'project:id,name',
            'listingType:id,name',
            'location:id,address',
            'media',
            'propertyAttributes.attribute:id,name,data_type',
            'propertyAmenities.amenity:id,name',
        ])->get()->map(function ($property) {
            $property->attribute_display = $property->propertyAttributes
                ->map(function ($pa) {
                    $name = $pa->attribute->name;
                    $value = $pa->value;
                    return "{$name}: {$value} ";
                })
                ->implode(', ');

            $property->amenity_display = $property->propertyAmenities
                ->map(function ($pa) {
                    $name = $pa->amenity->name;
                    $value = $pa->value;
                    return "{$name}: {$value} ";
                })
                ->filter() // loại bỏ null nếu có
                ->implode(', ');

            return $property;
        });

        return Inertia::render('projects/properties/Index', [
            'properties' => $properties,
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name', 'investor']),
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
        return Inertia::render('projects/properties/propertyManagement', [
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name']),
            'amenities' => Amenity::all(['id', 'name']),
            'attributes' => Attribute::all(['id', 'name', 'data_type']),
            'provinces' => Provinces::all(['id', 'name', 'code']),
            'districts' => District::all(['id', 'name', 'code', 'parent_code']),
            'wards' => Ward::all(['id', 'name', 'code', 'parent_code']),
            'listing_types' => ListingType::all(['id', 'name']),
        ]);
    }

    public function edit($id)
    {
        $property = Property::with([
            'category:id,name',
            'project:id,name',
            'listingType:id,name',
            'location:id,address',
            'media',
            'propertyAttributes.attribute:id,name',
            'propertyAmenities.amenity:id,name',
        ])->findOrFail($id);

        return Inertia::render('projects/properties/propertyManagement', [
            'property' => $property,
            'properties' => [], // hoặc danh sách khác nếu có
            'categories' => PropertyCategory::all(['id', 'name']),
            'projects' => Project::all(['id', 'name']),
            'amenities' => Amenity::all(['id', 'name']),
            'attributes' => Attribute::all(['id', 'name', 'data_type']),
            'provinces' => Provinces::all(['id', 'name', 'code']),
            'districts' => District::all(['id', 'name', 'code', 'parent_code']),
            'wards' => Ward::all(['id', 'name', 'code', 'parent_code']),
            'listing_types' => ListingType::all(['id', 'name']),
            'auth' => ['user' => auth()->user()],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'required|exists:property_categories,id',
            'listing_type_id' => 'required|exists:listing_types,id',
            'location_id' => 'nullable|exists:locations,id',
            'address' => 'nullable|string|max:255',
            'attributes' => 'array',
            'attributes.*.attribute_id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'nullable|string',
            'amenities' => 'array',
            'amenities.*.amenity_id' => 'required|exists:amenities,id',
            'amenities.*.value' => 'nullable|string',

        ]);
        //tạo file frontend layout riêng
        DB::transaction(function () use ($request, &$data) {
            if ($request->has('address')) {
                $location = \App\Models\Location::create(['address' => $request->input('address')]);
                $data['location_id'] = $location->id;
            }

            $data['user_id'] = auth()->id();
            $property = Property::create($data);

            foreach ($data['attributes'] ?? [] as $attr) {
                PropertyAttribute::create([
                    'property_id' => $property->id,
                    'attribute_id' => $attr['attribute_id'],
                    'value' => $attr['value'],
                ]);
            }

            foreach ($data['amenities'] ?? [] as $amenity) {
                \App\Models\PropertyAmenity::create([
                    'property_id' => $property->id,
                    'amenity_id' => $amenity['amenity_id'],
                    'value' => $amenity['value'] ?? null,
                ]);
            }

            if ($request->hasFile('image')) {
                $property->addMediaFromRequest('image')->toMediaCollection('properties');
            }
        });

        return redirect()->route('properties.index')->with('success', 'Bất động sản đã được tạo.');
    }

    public function update(Request $request, $id)
    {

        logger('INCOMING REQUEST', $request->all());

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
            'attributes.*.attribute_id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'nullable|string',
            'amenities' => 'array',
            'amenities.*.amenity_id' => 'required|exists:amenities,id',
            'amenities.*.value' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $id, &$data) {
            $property = Property::findOrFail($id);
            $property->update($data);

            // Attributes
            foreach ($data['attributes'] ?? [] as $attr) {
                logger('⚠️ Attribute Raw:', $data['attributes']);

                // Xoá nếu đã tồn tại
                PropertyAttribute::where('property_id', $property->id)
                    ->where('attribute_id', $attr['attribute_id'])
                    ->delete();

                // Tạo lại
                PropertyAttribute::create([
                    'property_id' => $property->id,
                    'attribute_id' => (int)$attr['attribute_id'],
                    'value' => $attr['value'],
                ]);
            }

            // Amenities
            foreach ($data['amenities'] ?? [] as $amenity) {
                logger('⚠️ Amenity Raw:', $data['amenities']);

                PropertyAmenity::where('property_id', $property->id)
                    ->where('amenity_id', $amenity['amenity_id'])
                    ->delete();

                PropertyAmenity::create([
                    'property_id' => $property->id,
                    'amenity_id' => $amenity['amenity_id'],
                    'value' => $amenity['value'],
                ]);
            }

            if ($request->hasFile('image')) {
                $property->clearMediaCollection('properties');
                $property->addMediaFromRequest('image')->toMediaCollection('properties');
            }
        });


        return redirect()->route('properties.index')->with('success', 'Cập nhật bất động sản thành công.');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Bất động sản đã được xoá.');
    }
}
