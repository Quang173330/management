<?php

namespace App\Queries\Users;

use App\Models\User;

class UserQuery
{
    /** @var string|null */
    protected ?string $email = null;

    /** @var bool|null */
    protected ?bool $isActive = null;

    /**
     * @param  User $user
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get()
    {
        return $this->getQuery()
            ->paginate();
    }

    /**
     * Get the base query
     *
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    protected function getQuery()
    {
        $query = User::latest();

        if ($this->email) {
            $this->applyEmailFilter($query);
        }

        if ($this->isActive) {
            $this->applyActiveFilter($query);
        }

        return $query;
    }

    /**
     * @param  bool|null $type
     * @return self
     */
    public function isActive(?bool $isActive)
    {
        if (is_bool($isActive)) {
            $this->isActive = $isActive;

            return $this;
        }

        return $this;
    }

    /**
     * @param  string|null $search
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

    protected function applyActiveFilter($query)
    {
        if (is_bool($this->isActive)) {
            $query->where('is_active', $this->isActive);
        }

        return $query;
    }

    protected function applyEmailFilter($query)
    {
        if ($this->email) {
            $query->where('email', $this->email);
        }

        return $query;
    }
}
