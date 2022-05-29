<?php

namespace App\Http\Controllers\Organizations\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Organization;
use App\Models\Project;
use Illuminate\Http\Request;

class Store extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Organization $organization, Project $project)
    {
        $data = array_merge($request->only(['name', 'description']), [
            'user_id' => $request->user()->id,
            'organization_id' => $organization->id,
        ]);
        
        $project = Project::create($data);

        return ProjectResource::make($project);
    }
}
