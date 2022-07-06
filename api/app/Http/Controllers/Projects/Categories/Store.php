<?php

namespace App\Http\Controllers\Projects\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
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
        $data = $request->only(['name']);

        $data['project_id'] = $project->id;

        $category = $project->categories()->create($data);

        return CategoryResource::make($category);
    }
}
