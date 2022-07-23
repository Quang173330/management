<?php

namespace App\Queries\Issues;

use App\Models\Issue;
use App\Models\Monitor;
use App\Models\Project;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

class IssuesQuery
{
    /** @var string|null */
    protected ?string $title = null;

    /** @var string|null */
    protected ?string $status = null;

    /** @var string|null */
        protected ?string $type = null;

    /** @var string|null */
    protected ?int $assign = null;

    /** @var string|null */
    protected ?string $priority = null;

    protected ?int $milestone = null;

    protected ?int $category = null;

    /**
     * @param  Project $project
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get(Project $project)
    {
        return $this->getQuery($project)
            ->latest()
            ->paginate();
    }

     /**
      * Get the base query
      *
      * @param  Project $project
      * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
      */
    protected function getQuery(Project $project)
    {
        $query = $project->issues();
        
        $this->applyAssignFilter($query);
        $this->applyTypeFilter($query);
        $this->applyPriorityFilter($query);
        $this->applyStatusFilter($query);
        $this->applyTitleFilter($query);
        $this->applyCategoryFilter($query);
        // $this->applyMilestoneFilter($query);

        return $query;
    }

    public function title(?string $title)
    {
        if (!$title) {
            return $this;
        }

        $this->title = $title;

        return $this;
    }

    public function status(?string $status)
    {
        if (!$status) {
            return $this;
        }

        $this->status = $status;

        return $this;
    }

    public function type(?string $type)
    {
        if (!$type) {
            return $this;
        }

        $this->type = $type;

        return $this;
    }

    public function assign(?int $assign)
    {
        if (!$assign) {
            return $this;
        }

        $this->assign = $assign;

        return $this;
    }

    public function priority(?string $priority)
    {
        if (!$priority) {
            return $this;
        }

        $this->priority = $priority;

        return $this;
    }

    public function milestone(?int $milestone)
    {
        if (!$milestone) {
            return $this;
        }

        $this->milestone = $milestone;

        return $this;
    }

    public function category(?int $category)
    {
        if (!$category) {
            return $this;
        }

        $this->category = $category;

        return $this;
    }


    protected function applyTitleFilter($query)
    {
        if ($this->title) {
            $query->where('title', 'LIKE', "%$this->title%");
        }

        return $query;
    }

    protected function applyStatusFilter($query)
    {
        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query;
    }

    protected function applyAssignFilter($query)
    {
        if ($this->assign) {
            $query->where('assign_id', $this->assign);
        }

        return $query;
    }

    protected function applyPriorityFilter($query)
    {
        if ($this->priority) {
            $query->where('priority', $this->priority);
        }

        return $query;
    }

    protected function applyTypeFilter($query)
    {
        if ($this->type) {
            $query->where('type', $this->type);
        }

        return $query;
    }

    protected function applyCategoryFilter($query)
    {
        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        return $query;
    }

    // protected function applyMilestoneFilter($query)
    // {
    //     if ($this->milestone) {
    //         $query->milestone()->where('id', $this);
    //     }

    //     return $query;
    // }
}
