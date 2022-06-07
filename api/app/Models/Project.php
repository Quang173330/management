<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'organization_id',
        'name',
        'slug',
        'description',
    ];

    /**
     * Return the sluggable configuration array for project.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_permissions')
            ->as('permission')
            ->withPivot('read', 'write', 'admin')
            ->withTimestamps();
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
