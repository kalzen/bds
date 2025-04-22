<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController
{
    public function index()
    {
        $cities = City::all();

        return Inertia::render('Index', [
            "cities" => $cities,
            "emptyMessage" => $cities->isEmpty() ? "Không có thành phố nào" : null
        ]);
    }

    public function show($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city = City::create($validated);
        return response()->json($city, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city = City::findOrFail($id);
        $city->update($validated);
        return response()->json($city);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(null, 204);
    }
}

