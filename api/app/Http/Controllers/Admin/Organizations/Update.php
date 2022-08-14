<?php

namespace App\Http\Controllers\Admin\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\ProjectResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class Update extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, Request $request)
    {
        $data = $request->only(['name', 'description']);
        $organization->update($data);

        $organization->load(['projects', 'permissions.user']);

        return OrganizationResource::make($organization);
    }
}
