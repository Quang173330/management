<?php

namespace App\Queries\Organizations;

use App\Models\Organization;

class UserProjectPermissionQuery
{
    /** @var string|null */
    protected ?string $email = null;

    public function get(Organization $organization)
    {
        return $this->getQuery($organization)
            ->orderby('organization_permissions.created_at', 'desc')
            ->with('user')
            ->paginate();
    }

    /**
     * Get the base query
     *
     * @param  Project $project
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    protected function getQuery(Organization $organization)
    {
        $query = $organization->permissions();

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
            $query->join('users', 'users.id', 'organization_permissions.user_id')->select('organization_permissions.*')->where('users.email', 'LIKE', "%$this->email%");
        }

        return $query;
    }
}
