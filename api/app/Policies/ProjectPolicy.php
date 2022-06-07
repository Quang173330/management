<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Project $project): bool
    {
        return $user && $user->projects()
            ->where('projects.id', $project->id)
            ->wherePivot('read', true)
            ->exists();
    }

    public function manage(?User $user, Project $project): bool
    {
        return $user && $user->projects()
            ->where('projects.id', $project->id)
            ->wherePivot('admin', true)
            ->exists();
    }

    public function edit(?User $user, Project $project): bool
    {
        return $user && $user->projects()
            ->where('projects.id', $project->id)
            ->wherePivot('write', true)
            ->exists();
    }
}
