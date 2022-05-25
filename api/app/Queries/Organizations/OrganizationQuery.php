<?php

namespace App\Queries\Organizations;

use App\Models\Organization;

class OrganizationQuery
{
    /**
     * @param  string $slug
     * @return Organization|null
     */
    public function getBySlug(string $slug)
    {
        return Organization::where('slug', $slug)->first();
    }
}
