<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Location;
use App\Models\Project;
use App\Models\Provinces;
use App\Models\Ward;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    // ✅ Index - list projects
    public function index()
    {
        $projects = Project::with('location')->get();

        return Inertia::render('projects/ProjectManagement', [
            'projects' => $projects,
            'provinces' => Provinces::all(['id', 'name', 'code']),
            'districts' => District::all(['id', 'name', 'code', 'parent_code']),
            'wards' => Ward::all(['id', 'name', 'code', 'parent_code']),
            'emptyMessage' => $projects->isEmpty() ? 'Không có dự án nào.' : null,
        ]);
    }


    // ✅ Show create form
    public function create()
    {
        return Inertia::render('Projects/Create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'investor' => 'required|string|max:255',
            'number_of_units' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:500',
            'total_area' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // ✅ Lưu address vào bảng locations
        $location = Location::create([
            'address' => $validated['address'],
        ]);

        $validated['location_id'] = $location->id;
        $validated['user_id'] = auth()->id();

        $this->projectService->create($validated);

        return redirect()->route('project.index')->with('success', 'Dự án đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $project = $this->projectService->getById($id);

        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Dự án không tồn tại.');
        }

        return Inertia::render('Projects/Edit', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'address' => 'required|string|max:500',
            'total_area' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project = $this->projectService->getById($id);

        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Dự án không tồn tại.');
        }

        // ✅ Update address in the locations table
        $location = Location::find($data['location_id']);
        $location->address = $data['address'];
        $location->save();

        // Remove address from $data before updating the project
        unset($data['address']);

        $this->projectService->update($id, $data);

        return redirect()->route('projects.index')->with('success', 'Cập nhật thành công.');
    }


    // ✅ Delete project
    public function destroy($id)
    {
        $project = Project::destroy($id);

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

}
