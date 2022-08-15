<?php

namespace App\Http\Controllers\Projects\Milestones;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Http\Request;

class Delete extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Project $project, Request $request, Milestone $milestone)
    {
        $count = $milestone->issues->count();
        if(!$count) {
            $milestone->delete();

            return response(null, 204);
        }

        return response(null, 500);
    }
}
