<?php

namespace App\Http\Controllers\Projects\Issues\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Issue\Comments\CreateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Issue;
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
    public function __invoke(Project $project, Issue $issue, CreateCommentRequest $request)
    {
        $data = $request->only([
            'content'
        ]);

        $data['user_id'] = $request->user()->id;

        $comment = $issue->comments()->create($data);
        $comment->load(['user', 'issue']);

        return CommentResource::make($comment);
    }
}
