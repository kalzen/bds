<?php

namespace App\Http\Controllers;

use App\Models\ListingType;
use Inertia\Inertia;

class ListingTypeController extends Controller
{
    public function index()
    {
        $listingTypes = ListingType::all();

        return Inertia::render('ListingTypes/Index', [
            "listingTypes" => $listingTypes,
            "emptyMessage" => $listingTypes->isEmpty() ? "Không có loại danh sách nào" : null
        ]);
    }
}
