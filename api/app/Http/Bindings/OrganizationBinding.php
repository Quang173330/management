<?php

namespace App\Http\Bindings;

use App\Models\Organization;
use App\Queries\Organizations\OrganizationQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Route;

class OrganizationBinding
{
    /** @var OrganizationQuery */
    protected $organizationQuery;

    public function __construct(OrganizationQuery $organizationQuery)
    {
        $this->organizationQuery = $organizationQuery;
    }

    public function bind(string $value, Route $route)
    {
        $organizationSlug = $route->parameter('organization');

        // If this isn't slug, fallback to find by key
        if (is_numeric($organizationSlug)) {
            return Organization::find($value);
        }

        // Remove unused variables so we don't have to put them in controller
        $organization = $this->organizationQuery->getBySlug($organizationSlug);

        if ($organization === null) {
            throw (new ModelNotFoundException())->setModel(Organization::class);
        }

        return $organization;
    }
}
