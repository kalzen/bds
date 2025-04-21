<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return response()->json(Project::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->projectService->createProject($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->projectService->getProjectById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->projectService->updateProject($id, $data));
    }

    public function destroy($id)
    {
        $this->projectService->deleteProject($id);
        return response()->json(null, 204);
    }
}
