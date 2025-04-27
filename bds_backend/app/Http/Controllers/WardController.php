<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Services\WardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WardController extends Controller
{
    protected WardService $service;

    public function __construct(WardService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        return Inertia::render('Wards/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
        ]);

        $this->service->create($data);

        return redirect()->route('location')->with('success', 'Phường đã được tạo.');
    }

    public function edit($id)
    {
        $ward = $this->service->getById($id);

        return Inertia::render('Wards/Edit', [
            'ward' => $ward,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->update($id, $data);

        return redirect()->route('location')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('location')->with('success', 'Đã xoá phường.');
    }
}
