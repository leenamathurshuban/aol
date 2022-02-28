<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebitAccountRequest extends FormRequest
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
        $data=\App\DebitAccount::where('slug',$this->slug)->first();
        $id=$data->id ?? '';
        return [
                'debit_account_number'=>'required|unique:debit_accounts,name,'.$id
            ];
    }
}
