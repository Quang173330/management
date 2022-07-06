<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Organization $organization): bool
    {
        return $user && $user->organizations()
            ->where('organizations.id', $organization->id)
            ->wherePivot('read', true)
            ->exists();
    }

    public function manage(?User $user, Organization $organization): bool
    {
        return $user && $user->organizations()
            ->where('organizations.id', $organization->id)
            ->wherePivot('admin', true)
            ->exists();
    }

    public function edit(?User $user, Organization $organization): bool
    {
        return $user && $user->organizations()
            ->where('organizations.id', $organization->id)
            ->wherePivot('write', true)
            ->exists();
    }
}
