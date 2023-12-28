<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task;


class TaskRequest extends FormRequest
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
            'title' => [Rule::when($this->task, 'sometimes' ),'required', 'max:40'],
            'description' => [Rule::when($this->task, 'sometimes'),'required' ,'max:1000'],
            'deadline' => ['required' , 'date' , 'after_or_equal:today'],
            'user_id' => ['sometimes','required', 'numeric' ,'exists:users,id'],
            'project_id' => ['required', 'numeric' ,'exists:projects,id'],
            'status' => ['required' , Rule::in(Task::STATUS)]
        ];
    }
}
