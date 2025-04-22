<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Inertia\Inertia;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return Inertia::render('Locations/Index', [
            "locations" => $locations,
            "emptyMessage" => $locations->isEmpty() ? "Không có địa điểm nào" : null
        ]);
    }
}
