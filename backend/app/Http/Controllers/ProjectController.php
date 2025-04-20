<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\DTO\ProjectDTO;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService) {}

    public function index()
    {
        return response()->json($this->projectService->getAllProjects());
    }

    public function show(int $id)
    {
        return response()->json($this->projectService->getProjectById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'investor' => 'required|string|max:255',
            'location_id' => 'required|integer|exists:locations,id',
            'total_area' => 'required|numeric',
            'number_of_units' => 'required|integer',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $projectDTO = new ProjectDTO(
            $request->input('name'),
            $request->input('investor'),
            $request->input('location_id'),
            $request->input('total_area'),
            $request->input('number_of_units'),
            $request->input('description'),
            $request->input('start_date'),
            $request->input('end_date')
        );
        $project = $this->projectService->createProject($projectDTO);

        return response()->json($project, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'investor' => 'required|string|max:255',
            'location_id' => 'required|integer|exists:locations,id',
            'total_area' => 'required|numeric',
            'number_of_units' => 'required|integer',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $projectDTO = new ProjectDTO(
            $request->input('name'),
            $request->input('investor'),
            $request->input('location_id'),
            $request->input('total_area'),
            $request->input('number_of_units'),
            $request->input('description'),
            $request->input('start_date'),
            $request->input('end_date')
        );
        $project = $this->projectService->updateProject($id, $projectDTO);

        return response()->json($project);
    }

    public function destroy(int $id)
    {
        $this->projectService->deleteProject($id);

        return response()->noContent();
    }
}
