<?php

namespace App\Http\Controllers\Organizations\Projects;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Issue;
use App\Models\IssueMilestone;
use App\Models\IssuePermission;
use App\Models\Milestone;
use App\Models\Organization;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Delete extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Organization $organization, Project $project, Request $request)
    {
        DB::beginTransaction();
        try {

            $issueIds = $project->issues->pluck('id');
            IssuePermission::whereIn('issue_id', $issueIds)->delete();
            Category::where('project_id', $project->id)->delete();
            IssueMilestone::whereIn('issue_id', $issueIds)->delete();
            Milestone::where('project_id', $project->id)->delete();
            Issue::whereIn('id', $issueIds)->delete();
            $project->users()->detach();
            $project->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return response(null, 204);
    }
}
