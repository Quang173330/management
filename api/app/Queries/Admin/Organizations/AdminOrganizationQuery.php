<?php

namespace App\Queries\Admin\Organizations;

use App\Models\Organization;
use Illuminate\Support\Str;

class AdminOrganizationQuery
{
    /** @var string|null */
    protected ?string $name = null;

    /**
     * @param  Project $project
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get()
    {
        return $this->getQuery()
            ->paginate();
    }

    protected function getQuery()
    {
        $query = Organization::latest();

        $this->applyNameFilter($query);

        return $query;
    }

    /**
     * @param  string|null $search
     * @return self
     */
    public function name(?string $name)
    {
        if (!$name) {
            return $this;
        }

        $this->name = $name;

        return $this;
    }

    protected function applyNameFilter($query)
    {
        if ($this->name) {
            $slug = Str::slug($this->name);
            $query->where('slug', 'LIKE', "%$slug%");
        }

        return $query;
    }
}
