<?php

namespace App\Queries\Projects;

use App\Models\Project;

class ProjectQuery
{
    /**
     * @param  string $slug
     * @return Project|null
     */
    public function getBySlug(string $slug)
    {
        return Project::where('slug', $slug)->first();
    }
}
