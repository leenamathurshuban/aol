<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        $data=\App\Employee::where('employee_code',$this->slug)->first();
        $id=($data->id ?? '') ? $data->id : 0;
        $manager=$medical_welfare='';
        if ($this->role==4) {
            $manager='required|numeric|exists:employees,id';
        }
        if ($this->medical_welfare=='Yes') {
            $medical_welfare='required|in:Yes';
        }
        $pass=$c_pass='';
        if ($this->password && $id) {
            $pass='required|min:6';
            $c_pass='required|min:6|same:password';
        }
        if ($id < 1) {
             $pass='required|min:6';
            $c_pass='required|min:6|same:password';
        }

        return [   
                    'role'=>'required',
                    'assign_process'=>'required|array|exists:assign_processes,id',
                    'name'=>'required',
                    'employee_code'=>'required|unique:employees,employee_code,'.$id,
                    'email'=>'required|email|unique:employees,email,'.$id,
                    'password'=>$pass,
                    'tag'=>'',
                    'phone'=>'required|numeric|digits:10',
                    'state'=>'required|exists:states,id',
                    'city'=>'required|exists:cities,id',
                    'bank_account_type'=>'required|in:Saving,Current',
                    'bank_account_number.*'=>'required',
                    'ifsc.*'=>'required',
                    'pan'=>'',
                    'approver_manager'=>$manager,
                    'specified_person'=>'required|in:Yes,No',
                    'address'=>'required',
                    'location'=>'required',
                    'zip'=>'required',
                    'medical_welfare'=>$medical_welfare,
                    'bank_name.*'=>'required',
                    'branch_code.*'=>'required',
                    'confirm_password'=>$c_pass,
                ];
    }
}
