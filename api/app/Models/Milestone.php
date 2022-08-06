<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'project_id',
        'name',
    ];

    public function issues() {
        return $this->belongsToMany(Issue::class, 'issue_milestones');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
