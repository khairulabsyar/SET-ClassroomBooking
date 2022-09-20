<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // check user by certain condition and return bool
        // usually with some logic
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         *  validate payload body:
         * length / size of item eg: 8 character
         * data type of item eg: string, numering
         * data format of item eg: data, regex
         */

        return [
            'name' => 'required|string|max:255',
            // 2 ways of writting rules
            'password' => [
                'required',
                'string',
                'alpha_num',
                'min:5'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => "Hey, your name is Unacceptable",
            'password.string' => "The password must consist of string and alpha numeric"
        ];
    }
}
