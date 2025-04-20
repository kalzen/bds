<?php

namespace App\Services;

use App\Models\Project;
use App\DTO\ProjectDTO;

class ProjectService
{
    public function getAllProjects()
    {
        return Project::all();
    }

    public function getProjectById(int $id)
    {
        return Project::findOrFail($id);
    }

    public function createProject(ProjectDTO $projectDTO)
    {
        return Project::create([
            'name' => $projectDTO->name,
            'investor' => $projectDTO->investor,
            'location_id' => $projectDTO->location_id,
            'total_area' => $projectDTO->total_area,
            'number_of_units' => $projectDTO->number_of_units,
            'description' => $projectDTO->description,
            'start_date' => $projectDTO->start_date,
            'end_date' => $projectDTO->end_date,
        ]);
    }

    public function updateProject(int $id, ProjectDTO $projectDTO)
    {
        $project = Project::findOrFail($id);
        $project->update([
            'name' => $projectDTO->name,
            'investor' => $projectDTO->investor,
            'location_id' => $projectDTO->location_id,
            'total_area' => $projectDTO->total_area,
            'number_of_units' => $projectDTO->number_of_units,
            'description' => $projectDTO->description,
            'start_date' => $projectDTO->start_date,
            'end_date' => $projectDTO->end_date,
        ]);
        return $project;
    }

    public function deleteProject(int $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }
}
