<?php

namespace App\Http\Controllers\Projects\Issues;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
use App\Models\Project;
use App\Queries\Issues\IssuesQuery;
use Illuminate\Http\Request;

class Get extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Project $project, Request $request, IssuesQuery $issuesQuery)
    {
        $title = $request->query('title');
        $type = $request->query('type');
        $status = $request->query('status');
        $assign = $request->query('assign');
        $priority = $request->query('priority');
        $category = $request->query('category');
        // $milestone = $request->query('milestone');

        $issues = $issuesQuery
        ->title($title)
        ->type($type)
        ->status($status)
        ->assign($assign)
        ->priority($priority)
        ->category($category)
        // ->milestone($milestone)
        ->get($project);

        $issues->load([
            'assign',
            'milestones',
            'category',
            'owner',
            'children',
            'children.assign',
            'children.milestones',
            'children.category',
            'children.owner',
        ]);
        return IssueResource::collection($issues);
    }
}
