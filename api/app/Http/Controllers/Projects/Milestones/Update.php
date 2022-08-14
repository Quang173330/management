<?php

namespace App\Http\Controllers\Projects\Milestones;

use App\Http\Controllers\Controller;
use App\Http\Resources\MilestoneResource;
use App\Models\Milestone;
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
    public function __invoke(Project $project, Request $request, Milestone $milestone)
    {
        $milestone->update([
            'name' => $request->input('name'),
        ]);

        return MilestoneResource::make($milestone);
    }
}
