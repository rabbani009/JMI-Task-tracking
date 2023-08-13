<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'sbu_id' => 'required|exists:sbus,id',
            'task_title' => 'required|string|max:255',
            'user_id' => 'required',
            'task_approved_steps' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'p_type' => 'required|string|max:255',
            'p_class' => 'required|string|max:255',
            'a_office' => 'required|array',
            
        ];
    }
}
