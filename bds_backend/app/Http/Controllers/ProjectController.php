<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
        $projects = Project::all();

        return Inertia::render('dashboard', [
            'projects' => $projects,
            'emptyMessage' => $projects->isEmpty() ? 'Không có dự án nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    // ✅ Store project
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->projectService->create($data);

        return redirect()->route('projects.index')->with('success', 'Dự án đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $project = $this->projectService->getById($id);

        return Inertia::render('Projects/Edit', [
            'project' => $project,
        ]);
    }

    // ✅ Update project
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->projectService->update($id, $data);

        return redirect()->route('projects.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete project
    public function destroy($id)
    {
        $this->projectService->delete($id);

        return redirect()->route('projects.index')->with('success', 'Đã xoá dự án.');
    }
}
