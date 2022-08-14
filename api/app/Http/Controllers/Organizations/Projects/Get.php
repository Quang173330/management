<?php

namespace App\Http\Controllers\Organizations\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class Get extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, Request $request)
    {
        $user = $request->user();
        $projects = $user->projects()->latest()->paginate();
        $projects->load('users');
        return ProjectResource::collection($projects);
    }
}
