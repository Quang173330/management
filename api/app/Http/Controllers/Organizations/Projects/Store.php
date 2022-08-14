<?php

namespace App\Http\Controllers\Organizations\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectPermission;
use Illuminate\Http\Request;

class Store extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateProjectRequest $request, Organization $organization)
    {
        $data = array_merge($request->only(['name', 'description']), [
            'organization_id' => $organization->id,
        ]);
        $user = $request->user();
        $project = $user->ownerProjects()->create($data);
        $user->projects()->attach($project, [
            'read' => true,
            'write' => true,
            'admin' => true,
        ]);

        if (!$project->permission) {
            $project->setRelation(
                'permission',
                new ProjectPermission(['read' => true, 'write' => true, 'admin' => true])
            );
        }
        $project->load('users');
        return ProjectResource::make($project);
    }
}
