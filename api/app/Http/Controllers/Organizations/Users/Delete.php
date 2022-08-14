<?php

namespace App\Http\Controllers\Organizations\Users;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationPermission;

class Delete extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, OrganizationPermission $organizationPermission)
    {
        $count = OrganizationPermission::where([
            ['admin', true],
            ['organization_id', $organization->id],
        ])->count();

        if (
            $organizationPermission->admin
            && ($count === 1 || $organizationPermission->user_id === $organization->user_id)
        ) {
            abort(403, 'Unauthorized action');
        }

        $organizationPermission->delete();

        return response(null, 204);
    }
}
