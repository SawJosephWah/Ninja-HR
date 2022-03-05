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
            'employee_id'=>'required|unique:users,employee_id',
            'name'=>'required|min:4',
            'phone'=>'required|min:9|max:11|unique:users,phone',
            'email'=>'required|email|unique:users,email',
            'pin_code'=>'required|numeric|digits_between:6,8|unique:users,pin_code',
            'password'=>'required|min:8',
            'nrc_number'=>'required|unique:users',
            'gender'=>'required',
            'birthday'=>'required',
            'image'=>'mimes:jpeg,jpg,png,gif|required|max:30000',
            'address'=>'required',
            'department_id'=>'required',
            'roles'=>'required',
            'date_of_join'=>'required',
            'is_present'=>'required',
        ];
    }
}
