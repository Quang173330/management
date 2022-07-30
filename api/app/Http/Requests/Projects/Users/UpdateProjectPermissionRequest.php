<?php

namespace App\Http\Requests\Projects\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectPermissionRequest extends FormRequest
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
            'admin' => 'required|boolean',
            'write' => 'required|boolean',
            'read' => 'required|boolean',
        ];
    }
}
