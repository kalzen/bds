<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Services\DistrictService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DistrictController extends Controller
{
    protected DistrictService $districtService;

    public function __construct(DistrictService $districtService)
    {
        $this->districtService = $districtService;
    }

    // ✅ Index - list districts
    public function index()
    {
        $districts = District::all();

        return Inertia::render('Districts/Index', [
            'districts' => $districts,
            'emptyMessage' => $districts->isEmpty() ? 'Không có quận nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('Districts/Create');
    }

    // ✅ Store district
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->districtService->create($data);

        return redirect()->route('districts.index')->with('success', 'Quận đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $district = $this->districtService->getById($id);

        return Inertia::render('Districts/Edit', [
            'district' => $district,
        ]);
    }

    // ✅ Update district
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->districtService->update($id, $data);

        return redirect()->route('districts.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete district
    public function destroy($id)
    {
        $this->districtService->delete($id);

        return redirect()->route('districts.index')->with('success', 'Đã xoá quận.');
    }
}
