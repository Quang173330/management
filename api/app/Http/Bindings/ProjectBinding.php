<?php

namespace App\Http\Bindings;

use App\Models\Project;
use App\Queries\Projects\ProjectQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Route;

class ProjectBinding
{
    /** @var ProjectQuery */
    protected $projectQuery;

    public function __construct(ProjectQuery $projectQuery)
    {
        $this->projectQuery = $projectQuery;
    }

    public function bind(string $value, Route $route)
    {
        $projectSlug = $route->parameter('project');

        // If this isn't slug, fallback to find by key
        if (is_numeric($projectSlug)) {
            return Project::find($value);
        }

        // Remove unused variables so we don't have to put them in controller
        $project = $this->projectQuery->getBySlug($projectSlug);

        if ($project === null) {
            throw (new ModelNotFoundException())->setModel(Project::class);
        }

        return $project;
    }
}
