<?php

namespace App\Http\Controllers\Projects\Issues;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
use App\Models\Project;
use Illuminate\Http\Request;

class Get extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Project $project, Request $request)
    {
        $issues = $project->issues;
        $issues->load(['assign', 'milestones', 'category']);
        return IssueResource::collection($issues);
    }
}
