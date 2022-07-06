<?php

namespace App\Http\Controllers\Projects\Milestones;

use App\Http\Controllers\Controller;
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
    public function __invoke(Project $project, Request $request)
    {
        $data = $request->only(['name']);

        $data['project_id'] = $project->id;

        $milestone = $project->milestones()->create($data);

        return $milestone;
    }
}
