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

    public function index()
    {
        $wards = Ward::all();

        return Inertia::render('Wards/Index', [
            'wards' => $wards,
            'emptyMessage' => $wards->isEmpty() ? 'Không có phường nào.' : null,
        ]);
    }

    public function create()
    {
        return Inertia::render('Wards/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->service->create($data);

        return redirect()->route('wards.index')->with('success', 'Phường đã được tạo.');
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

        return redirect()->route('wards.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('wards.index')->with('success', 'Đã xoá phường.');
    }
}
