<?php

namespace App\Http\Controllers\Projects\Users;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectPermission;

class Delete extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Project $project, ProjectPermission $projectPermission)
    {
        $count = ProjectPermission::where([
            ['admin', true],
            ['project_id', $project->id],
        ])->count();

        if (
            $projectPermission->admin
            && ($count === 1 || $projectPermission->user_id === $project->user_id)
        ) {
            abort(403, 'Unauthorized action');
        }

        $projectPermission->delete();

        return response(null, 204);
    }
}
