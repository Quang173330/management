<?php

namespace App\Queries\Admin\Projects;

use App\Models\Project;
use Illuminate\Support\Str;

class AdminProjectQuery
{
    /** @var string|null */
    protected ?string $name = null;

    /** @var string|null */
    protected ?string $email = null;

    /**
     * @param  Project $project
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get()
    {
        return $this->getQuery()
            ->latest()
            ->paginate();
    }

    protected function getQuery()
    {
        $query = Project::select('projects.*')->join('users', 'users.id', 'projects.user_id');

        $this->applyNameFilter($query);
        $this->applyEmailFilter($query);

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

    /**
     * @param  string|null $type
     * @return self
     */
    public function email(?string $email)
    {
        if (!$email) {
            return $this;
        }

        $this->email = $email;

        return $this;
    }

    protected function applyNameFilter($query)
    {
        if ($this->name) {
            $slug = Str::slug($this->name);
            $query->where('projects.slug', 'LIKE', "%$slug%");
        }

        return $query;
    }

    protected function applyEmailFilter($query)
    {
        if ($this->email) {
            $query->where('users.email', $this->email);
        }

        return $query;
    }
}
