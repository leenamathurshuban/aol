<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
        $data=\App\BankAccount::where('slug',$this->slug)->first();
        $id=$data->id ?? '';
        return [
                'apex'=>'required|exists:apexes,slug',
                'bank_account_number'=>'required|unique:bank_accounts,bank_account_number,'.$id,
                'bank_name'=>'required',
                'branch_address'=>'required',
                'branch_code'=>'',
                'bank_account_holder'=>'required',
                'ifsc'=>'required'
            ];
    }
}
