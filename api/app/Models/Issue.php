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
}
