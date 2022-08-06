<?php

namespace App\Http\Controllers\Admin\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Queries\Admin\Projects\AdminProjectQuery;
use Illuminate\Http\Request;

class Get extends Controller
{
    protected $adminProjectQuery;

    public function __construct(AdminProjectQuery $adminProjectQuery)
    {
        $this->adminProjectQuery = $adminProjectQuery;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $name = $request->query('name');
        $email = $request->query('email');

        $projects = $this->adminProjectQuery->name($name)->email($email)->get();

        $projects->load(['issues', 'permissions.user']);

        return ProjectResource::collection($projects);
    }
}
