<?php

namespace App\Http\Controllers\Projects\Issues;

use App\Http\Controllers\Controller;
use App\Http\Requests\Issue\UpdateIssueRequest;
use App\Http\Resources\IssueResource;
use App\Models\Issue;
use App\Models\Project;

class Update extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Project $project, Issue $issue, UpdateIssueRequest $request)
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

        $issue->update($data);
        $milestoneId = $request->input('milestone');
        $issue->milestones()->syncWithoutDetaching($milestoneId);

        return IssueResource::make($issue);
    }
}
