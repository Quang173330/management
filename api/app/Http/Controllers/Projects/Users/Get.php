<?php

namespace App\Http\Controllers\Projects\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectPermissionResource;
use App\Models\Project;
use App\Queries\Projects\UserProjectPermissionQuery;
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
    public function __invoke(Request $request, Project $project)
    {
        $email = $request->query('email');

        $permissions = $this->userProjectPermissionQuery->email($email)->get($project);

        return ProjectPermissionResource::collection($permissions);
    }
}
