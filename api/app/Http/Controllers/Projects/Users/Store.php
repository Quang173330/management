<?php

namespace App\Http\Controllers\Projects\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\Users\CreateProjectPermissionRequest;
use App\Http\Resources\ProjectPermissionResource;
use App\Models\Project;
use App\Services\Users\CreateUserPermissionService;
use Exception;

class Store extends Controller
{
    protected $createUserPermissionService;

    public function __construct(CreateUserPermissionService $createUserPermissionService)
    {
        $this->createUserPermissionService = $createUserPermissionService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateProjectPermissionRequest $request, Project $project)
    {
        try {
            $permission = $this->createUserPermissionService->handle($project, $request->only(['email', 'admin', 'write', 'read']));

            return ProjectPermissionResource::make($permission->load('user'));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
