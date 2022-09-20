<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateclassroomsRequest extends FormRequest
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
            // 'teachers_id' => 'exists:teachers,id',
            'type_id' => 'exists:classroom_types,id',
            'date' => 'string',
            'time_start' => 'string',
            'time_end' => 'string',
            'uri' => 'string'
        ];
    }
}
