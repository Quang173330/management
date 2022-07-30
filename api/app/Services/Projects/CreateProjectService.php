<?php

namespace App\Services\Projects;

use App\Models\Project;
use App\Models\User;

class CreateProjectService
{
    /**
     * Create project for user
     *
     * @param  User $user
     * @param  array $data
     * @return Project
     */
    public function handle(User $user, array $data): Project
    {
        $project = $user->ownerProjects()->create($data);
        $user->projects()->attach($project, [
            'read' => true,
            'write' => true,
            'admin' => true,
        ]);

        return $project;
    }
}
