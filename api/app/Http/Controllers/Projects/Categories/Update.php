<?php

namespace App\Http\Controllers\Projects\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class Update extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Project $project, Request $request, Category $category)
    {
        $category->update([
            'name' => $request->input('name'),
        ]);

        return CategoryResource::make($category);
    }
}
