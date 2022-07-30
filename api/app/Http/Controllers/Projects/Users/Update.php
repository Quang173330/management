<?php

namespace App\Http\Controllers\Projects\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\Users\UpdateProjectPermissionRequest;
use App\Http\Resources\ProjectPermissionResource;
use App\Models\Project;
use App\Models\ProjectPermission;
use App\Services\Projects\Users\UpdateProjectPermissionService;

class Update extends Controller
{
    protected $updateProjectPermissionService;


    public function __construct(
        UpdateProjectPermissionService $updateProjectPermissionService
    ) {
        $this->updateProjectPermissionService = $updateProjectPermissionService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        UpdateProjectPermissionRequest $request,
        Project $project,
        ProjectPermission $projectPermission
    ) {

        $count = ProjectPermission::where([
            ['admin', true],
            ['project_id', $project->id],
        ])->count();

        if (
            !$request->admin
            && $projectPermission->admin
            && ($count === 1 || $projectPermission->user_id === $project->user_id)
        ) {
            abort(403, 'Unauthorized action');
        }

        $permission = $this->updateProjectPermissionService->handle($project, $projectPermission, $request->only(['admin', 'write', 'read']));

        return ProjectPermissionResource::make($permission->load('user'));
    }
}
