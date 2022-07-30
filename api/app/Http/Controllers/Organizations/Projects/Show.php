<?php

namespace App\Http\Controllers\Organizations\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Organization;
use App\Models\Project;
use Illuminate\Http\Request;

class Show extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, Project $project, Request $request)
    {
        $permission = $project->permissions()->where('user_id', $request->user()->id)->first();

        $project->setRelation('permission', $permission);

        $project->load(['owner']);
        return ProjectResource::make($project);
    }
}
