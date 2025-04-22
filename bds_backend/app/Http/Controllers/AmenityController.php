<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::all();

        return Inertia::render('Amenities/Index', [
            "amenities" => $amenities,
            "emptyMessage" => $amenities->isEmpty() ? "Không có tiện ích nào" : null
        ]);
    }

    public function show($id)
    {
        $amenity = Amenity::findOrFail($id);
        return response()->json($amenity);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $amenity = Amenity::create($validated);
        return response()->json($amenity, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $amenity = Amenity::findOrFail($id);
        $amenity->update($validated);
        return response()->json($amenity);
    }

    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
        return response()->json(null, 204);
    }
}
