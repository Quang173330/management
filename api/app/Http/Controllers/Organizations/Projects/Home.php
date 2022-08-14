<?php

namespace App\Http\Controllers\Organizations\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
use App\Models\Organization;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MergeValue;

class Home extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, Project $project, Request $request)
    {
        $allIssues = $project->issues;
        $status = [
            'open' => $allIssues->where('status', 'open')->count(),
            'inprogress' => $allIssues->where('status', 'in progress')->count(),
            'resolved' => $allIssues->where('status', 'resolved')->count(),
            'closed' => $allIssues->where('status', 'closed')->count(),
            'all' => $allIssues->count(),
        ];

        $milestones = $project->milestones;

        foreach ($milestones as $milestone) {
            $milestone->open = $milestone->issues()->where('status', 'open')->count();
            $milestone->inprogress = $milestone->issues()->where('status', 'in progress')->count();
            $milestone->resolved = $milestone->issues()->where('status', 'resolved')->count();
            $milestone->closed = $milestone->issues()->where('status', 'closed')->count();
            $milestone->all = $milestone->issues()->count();
        }

        $categories = $project->categories;

        foreach ($categories as $category) {
            $category->open = $category->issues()->where('status', 'open')->count();
            $category->inprogress = $category->issues()->where('status', 'in progress')->count();
            $category->resolved = $category->issues()->where('status', 'resolved')->count();
            $category->closed = $category->issues()->where('status', 'closed')->count();
            $category->all = $category->issues()->count();
        }

        return JsonResource::make([
            'milestones' => $milestones,
            'status' => $status,
            'categories' => $categories,
        ]);
    }
}
