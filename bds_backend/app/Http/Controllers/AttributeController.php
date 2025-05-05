<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Services\AttributeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttributeController extends Controller
{
    protected AttributeService $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    // GET: /attributes
    public function index()
    {
        $attributes = Attribute::with('media')->get();

        return Inertia::render('Attributes/Index', [
            'attributes' => $attributes,
            'emptyMessage' => $attributes->isEmpty() ? 'Không có thuộc tính nào.' : null,
        ]);
    }

    // GET: /attributes/create
    public function create()
    {
        return Inertia::render('Attributes/Create');
    }

    // POST: /attributes
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'data_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|file|mimetypes:image/svg+xml|max:512', // chỉ cho SVG
        ]);

        // Tạo attribute không bao gồm icon
        $attribute = Attribute::create([
            'name' => $validated['name'],
            'data_type' => $validated['data_type'],
            'description' => $validated['description'] ?? null,
        ]);

        // Nếu có upload icon thì lưu vào Media Library
        if ($request->hasFile('icon')) {
            $attribute
                ->addMediaFromRequest('icon')
                ->usingFileName('icon_' . uniqid() . '.svg')
                ->toMediaCollection('icon', 'public'); // ensure using 'public' disk
        }

        return redirect()->route('features')->with('success', 'Thuộc tính đã được tạo.');
    }


    // GET: /attributes/{id}/edit
    public function edit($id)
    {
        $attribute = $this->attributeService->getById($id)->load('media');

        return Inertia::render('Attributes/Edit', [
            'attribute' => $attribute,
            'icon_url' => $attribute->getFirstMediaUrl('icon'),
        ]);
    }

    // PUT/PATCH: /attributes/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'data_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|file|mimetypes:image/svg+xml|max:512',
        ]);

        $attribute = $this->attributeService->update($id, $validated);

        if ($request->hasFile('icon')) {
            $attribute->clearMediaCollection('icon');
            $attribute
                ->addMediaFromRequest('icon')
                ->usingFileName('icon_' . uniqid() . '.svg')
                ->toMediaCollection('icon');
        }

        return redirect()->route('features')->with('success', 'Cập nhật thành công.');
    }

    // DELETE: /attributes/{id}
    public function destroy($id)
    {
        $this->attributeService->delete($id);

        return redirect()->route('features')->with('success', 'Đã xoá thuộc tính.');
    }
}
