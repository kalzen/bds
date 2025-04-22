<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();

        return Inertia::render('Attributes/Index', [
            "attributes" => $attributes,
            "emptyMessage" => $attributes->isEmpty() ? "Không có thuộc tính nào" : null
        ]);
    }

    public function show($id)
    {
        $attribute = Attribute::findOrFail($id);
        return response()->json($attribute);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute = Attribute::create($validated);
        return response()->json($attribute, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->update($validated);
        return response()->json($attribute);
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return response()->json(null, 204);
    }
}
