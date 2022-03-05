<?php

namespace App\Http\Requests;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployee extends FormRequest
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

        $id = $this->route('employee');
        return [
            'employee_id'=>'required|unique:users,employee_id,'.$id,
            'name'=>'required|min:4',
            'phone'=>'required|min:9|max:11|unique:users,phone,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'pin_code'=>'required|numeric|digits_between:6,6|unique:users,pin_code,'.$id,
            'nrc_number'=>'required|unique:users,nrc_number,'.$id,
            'gender'=>'required',
            'birthday'=>'required',
            'address'=>'required',
            'department_id'=>'required',
            'roles'=>'required',
            'date_of_join'=>'required',
            'is_present'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'pin_code.digits_between' => 'Pin Code must be exactly 6',
        ];
    }
}
