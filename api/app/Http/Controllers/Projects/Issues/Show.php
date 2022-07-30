<?php

namespace App\Http\Controllers\Projects\Issues;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
use App\Models\Issue;
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
    public function __invoke(Project $project, Issue $issue, Request $request)
    {
        $issue->load(['assign', 'milestones', 'category', 'owner']);

        return IssueResource::make(($issue));
    }
}
