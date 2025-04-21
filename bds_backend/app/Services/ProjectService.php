<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function getProjectById(int $id)
    {
        return Project::findOrFail($id);
    }

    public function createProject(array $data)
    {
        return Project::create($data);
    }

    public function updateProject(int $id, array $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function deleteProject(int $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }
}
