<?php

namespace App\Http\Resources;

use App\Models\Milestone;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'priority' => $this->priority,
            'estimated_hours' => $this->estimated_hours,
            'actual_hours' => $this->actual_hours,
            'description' => $this->description,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'due_date' => $this->due_date,
            'assign' => UserResource::make($this->whenLoaded('assign')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'milestones' => MilestoneResource::collection($this->whenLoaded(('milestones'))),
            'project' => ProjectResource::make($this->whenLoaded('project')),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
