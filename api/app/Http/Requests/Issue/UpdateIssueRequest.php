<?php

namespace App\Http\Requests\Issue;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id'=> 'nullable|integer',
            'title'=> 'required|string',
            'type'=>[
                'required',
                'string',
                Rule::in(IssueType::SUPPORTED_TYPES)
            ],
            'priority' => [
                'required',
                'string',
                Rule::in(IssuePriority::SUPPORTED_PRIORITY)
            ],
            'estimated_hours' => 'required|integer',
            'actual_hours' => 'required|integer',
            'description' => 'required|string',
            'status' => [
                'required',
                'string',
                Rule::in(IssueStatus::SUPPORTED_STATUS)
            ],
            'assign_id' => 'nullable|integer',
            'category_id' => 'required|integer',
            'start_date' => 'required|string',
            'due_date' => 'required|string',
        ];
    }
}
