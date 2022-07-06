<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\OrganizationPermission;
use Illuminate\Http\Request;

class Store extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->only(['name', 'description']);
        $user = $request->user();
        $organization = $user->ownerOrganizations()->create($data);
        $user->organizations()->attach($organization, [
            'read' => true,
            'write' => true,
            'admin' => true,
        ]);

        if (!$organization->permission) {
            $organization->setRelation(
                'permission',
                new OrganizationPermission(['read' => true, 'write' => true, 'admin' => true])
            );
        }

        return OrganizationResource::make($organization);
    }
}
