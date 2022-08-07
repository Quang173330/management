<?php

namespace App\Http\Controllers\Projects\Issues\Comments;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Issue;
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
    public function __invoke(Project $project, Issue $issue, Request $request)
    {
        $comments = $issue->comments()->latest()->paginate();
        $comments->load(['user', 'issue']);

        return CommentResource::collection($comments);
    }
}
