<?php

namespace App\Queries\Projects;

use App\Models\Project;

class UserProjectPermissionQuery
{
    /** @var string|null */
    protected ?string $email = null;

    public function get(Project $project)
    {
        return $this->getQuery($project)
            ->orderby('project_permissions.created_at', 'desc')
            ->with('user')
            ->paginate();
    }

    /**
     * Get the base query
     *
     * @param  Project $project
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    protected function getQuery(Project $project)
    {
        $query = $project->permissions();

        if ($this->email) {
            $this->applyEmailFilter($query);
        }

        return $query;
    }

    /**
     * @param  string|null $search
     * @return self
     */
    public function email(?string $email)
    {
        if (!$email) {
            return $this;
        }

        $this->email = $email;

        return $this;
    }

    protected function applyEmailFilter($query)
    {
        if ($this->email) {
            $query->join('users', 'users.id', 'project_permissions.user_id')->where('users.email', 'LIKE', "%$this->email%");
        }

        return $query;
    }
}
