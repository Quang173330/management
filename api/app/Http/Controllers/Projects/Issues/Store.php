<?php

namespace App\Http\Controllers\Projects\Issues;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
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
        $data = $request->only([
            'parent_id',
            'title',
            'type',
            'priority',
            'estimated_hours',
            'actual_hours',
            'description',
            'status',
            'assign_id',
            'category_id',
            'start_date',
            'due_date',
        ]);

        $data['user_id'] = $request->user()->id;

        $issue = $project->issues()->create($data);
        $milestoneId = $request->input('milestone');
        $issue->milestones()->attach($milestoneId);

        return IssueResource::make($issue);
    }
}
