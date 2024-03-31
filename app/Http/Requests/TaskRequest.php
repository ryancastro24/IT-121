<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        if (request()->routeIs('task.store')) {
            return [
                "task_title" => 'required|string|max:255',
                "description" => 'required|string',
                'priority' => 'required|string',
                'content' => 'required',
                'user_id' => 'required|integer',
            ];
        }

         if(request()->routeIs('task.complete')){
            return [
                'completed' =>  'required|boolean',
            ];
        }
        
        if (request()->routeIs('task.taskUpdate')) {
            return [
                "task_title" => 'required|string|max:255',
                "description" => 'required|string',
                'priority' => 'required|string',
                'content' => 'required',
                
            ];
        }



       
    }
}
