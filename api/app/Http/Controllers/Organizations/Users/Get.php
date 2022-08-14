<?php

namespace App\Http\Controllers\Organizations\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectPermissionResource;
use App\Models\Organization;
use App\Models\Project;
use App\Queries\Organizations\UserProjectPermissionQuery;
use Illuminate\Http\Request;

class Get extends Controller
{
    protected $userProjectPermissionQuery;

    public function __construct(UserProjectPermissionQuery $userProjectPermissionQuery)
    {
        $this->userProjectPermissionQuery = $userProjectPermissionQuery;
    }

    /**
     * Get members in project
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, Request $request)
    {
        $email = $request->query('email');

        $permissions = $this->userProjectPermissionQuery->email($email)->get($organization);

        return ProjectPermissionResource::collection($permissions);
    }
}
