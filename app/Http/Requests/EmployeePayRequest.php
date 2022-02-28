<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class EmployeePayRequest extends FormRequest
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
        $empl='';
        if ($this->pay_for=='other') {
            $empl='required|exists:employees,id';
        }
        return [
            'pay_for'=>'required|in:self,other',
            'employee'=>$empl,
            'address'=>'required',
            'bank_account_number'=>'required|exists:employee_bank_accounts,bank_account_number',
           // 'ifsc'=>'required',
            'pan'=>'required',
            'nature_of_claim'=>'required|exists:claim_types,id',
            'apex'=>'required|exists:apexes,id',
            'description'=>'required|max:250',
            'amount_requested'=>'required|numeric|min:0',
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048'
        ];
    }
}
