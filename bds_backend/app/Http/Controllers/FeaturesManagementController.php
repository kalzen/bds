<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Attribute;
use App\Models\ListingType;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeaturesManagementController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $attribute = Attribute::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->get();

        $amenties = Amenity::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->get();

        $listing_types = ListingType::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->get();

        $properties_categories = PropertyCategory::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->get();

        return Inertia::render('projects/FeaturesManagement', [
            'attribute' => $attribute,
            'amenties' => $amenties,
            'listing_types' => $listing_types,
            'properties_categories' => $properties_categories,
            'filters' => ['search' => $search]
        ]);
    }

}
