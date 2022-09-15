<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreclassroomsRequest extends FormRequest
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
            // 'teachers_id' => 'required|exists:teacher,id',
            'type_id' => 'required|exists:classroom_types,id',
            'date' => 'string',
            'time_start' => 'string',
            'time_end' => 'string'
        ];
    }
}