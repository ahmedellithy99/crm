<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [Rule::when($this->project, 'sometimes' , 'required'), 'max:40'],
            'description' => [Rule::when($this->project, 'sometimes'),'required' ,'max:1000'],
            'deadline' => ['required' , 'date'],
            'user_id' => ['sometimes','required', 'numeric' ,'exists:users,id'],
            'client_id' => ['required', 'numeric' ,'exists:clients,id'],
            'status' => ['required' , Rule::in(Project::STATUS)]
        ];
    }
}
