<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternalTransferRequest extends FormRequest
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
        $state=$state_bank_id=$ifsc=$project_name=$project_id=$reason=$cost_center=$transfer_from=$transfer_to='';
        if ($this->pay_for=='State requesting funds') {
            $state='required|exists:apexes,id';
            $state_bank_id='required|exists:bank_accounts,id';
            $ifsc=$project_name=$project_id=$reason=$cost_center='required';
        }
        if ($this->pay_for=='Inter bank transfer') {
            $transfer_from=$transfer_to='required|exists:bank_accounts,id';
        }
        return [
            'pay_for'=>'required|in:State requesting funds,Inter bank transfer',
            'state'=>$state,
            'state_bank_id'=>$state_bank_id,
            'ifsc'=>$ifsc,
            'project_name'=>$project_name,
            'project_id'=>$project_id,
            'reason'=>$reason,
            'cost_center'=>$cost_center,
            'transfer_from'=>$transfer_from,
            'transfer_to'=>$transfer_to,
            'amount'=>'required|numeric|min:0',
            'apex'=>'required|exists:apexes,id',
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048'
        ];
    }
}
