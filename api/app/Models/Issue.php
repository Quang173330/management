<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'parent_id',
        'assign_id',
        'category_id',
        'title',
        'type',
        'priority',
        'estimated_hours',
        'actual_hours',
        'description',
        'status',
        'start_date',
        'due_date',
    ];

    public function milestones() {
        return $this->belongsToMany(Milestone::class, 'issue_milestones')->withTimestamps();
    }

    public function assign()
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
