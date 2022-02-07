<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
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
            'employee_id'=>'required',
            'name'=>'required',
            'phone'=>'required|min:7|max:12',
            'email'=>'required|email',
            'nrc_number'=>'required',
            'birthday'=>'required',
            'gender'=>'required',
            'department_id'=>'required',
            'date_of_join'=>'required',
            'is_present'=>'required',
            'address'=>'required',
            'password'=>'required',

            'pin_code'=>'nullable|min:6|max:6'
        ];
    }
}
