<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function create(array $data)
    {
        return Project::create($data);
    }

    public function findbyID(int $id)
    {
        return Project::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function delete(int $id)
    {
        $project = Project::findOrFail($id);
        return $project->delete();
    }
}
