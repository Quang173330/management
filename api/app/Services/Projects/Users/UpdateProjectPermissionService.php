<?php

namespace App\Services\Projects\Users;

use App\Models\Project;
use App\Models\User;

class UpdateProjectPermissionService
{
    /**
     * Create project for user
     *
     * @param  User $user
     * @param  array $data
     * @return Project
     */
    public function handle($project, $projectPermission, array $data)
    {
        $projectPermission->update([
            'admin' => $data['admin'],
            'write' => $data['admin'] || $data['write'],
            'read' => $data['admin'] || $data['write'] || $data['read'],
        ]);

        return $projectPermission;
    }
}
