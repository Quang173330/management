<?php

namespace App\Http\Controllers\Projects\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
    public function __invoke(Project $project, Request $request, Category $category)
    {
        $count = $category->issues->count();
        if(!$count) {
            $category->delete();

            return response(null, 204);
        }

        return response(null, 500);
    }
}
