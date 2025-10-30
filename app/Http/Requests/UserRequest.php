<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'company' => ['required', 'exists:companies,id'],
            'department' => ['required', 'exists:departments,id'],
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'sometimes'],
            'email' => ['required', 'email', Rule::unique('users','email')->ignore($this->id)],
            'role' => ['required', 'exists:roles,id']
        ];
    }
}
