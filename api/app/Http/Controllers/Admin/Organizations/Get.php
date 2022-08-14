<?php

namespace App\Http\Controllers\Admin\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Queries\Admin\Organizations\AdminOrganizationQuery;
use Illuminate\Http\Request;

class Get extends Controller
{
    protected $adminOrganizationQuery;

    public function __construct(AdminOrganizationQuery $adminOrganizationQuery)
    {
        $this->adminOrganizationQuery = $adminOrganizationQuery;
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

        $organizations = $this->adminOrganizationQuery->name($name)->get();

        $organizations->load(['projects', 'permissions.user']);

        return OrganizationResource::collection($organizations);
    }
}
