<?php

namespace App\Http\Controllers\Organizations\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Organization;
use App\Models\Project;
use Illuminate\Http\Request;

class Update extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, Project $project, UpdateProjectRequest $request)
    {
        $data = $request->only(['name', 'description']);
        $project->update($data);
        $permission = $project->permissions()->where('user_id', $request->user()->id)->first();

        $project->setRelation('permission', $permission);
        $project->load('users');

        return ProjectResource::make($project);
    }
}
