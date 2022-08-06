<?php

namespace App\Http\Controllers\Projects\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\MilestoneResource;
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
    public function __invoke(Project $project, Request $request)
    {
        $categories = $project->categories;
        $categories->load('issues');
        return CategoryResource::collection($categories);
    }
}
