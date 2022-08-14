<?php

namespace App\Http\Controllers\Organizations\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organizations\Users\UpdateOrganizationPermissionRequest;
use App\Http\Resources\OrganizationPermissionResource;
use App\Models\Organization;
use App\Models\OrganizationPermission;

class Update extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        UpdateOrganizationPermissionRequest $request,
        Organization $organization,
        OrganizationPermission $organizationPermission
    ) {

        $count = OrganizationPermission::where([
            ['admin', true],
            ['organization_id', $organization->id],
        ])->count();

        if (
            !$request->admin
            && $organizationPermission->admin
            && ($count === 1 || $organizationPermission->user_id === $organization->user_id)
        ) {
            abort(403, 'Unauthorized action');
        }

        $data = $request->only(['admin', 'write', 'read']);

        $organizationPermission->update([
            'admin' => $data['admin'],
            'write' => $data['admin'] || $data['write'],
            'read' => $data['admin'] || $data['write'] || $data['read'],
        ]);
        return OrganizationPermissionResource::make($organizationPermission->load('user'));
    }
}
