<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
        $data=\App\Vendor::where('vendor_code',$this->slug)->first();
        $id=$data->id ?? '';
        if ($id=='') {
            $pan ='required';
             $cheq ='required';
        }else{
            $pan ='';
            $cheq ='';
        }
        $valid='';
        if ($this->constitution=='Others') {
            $valid='required';
        }
        return [
                'name'=>'required',
                'email'=>'required|email|unique:vendors,email,'.$id,
                'password'=>'required|min:6',
                'phone'=>'required|numeric|digits:10',
                'state'=>'required|exists:states,id',
                'city'=>'required|exists:cities,id',
                'bank_account_type'=>'required|in:Saving,Current',
                'bank_account_number'=>'required',
                'ifsc'=>'required',
                'pan'=>'required|max:10|min:10|unique:vendors,pan,'.$id,
                'specified_person'=>'',
                'address'=>'required',
                'location'=>'required',
                'specify_if_other'=>'',
                'gst'=>'',
                'constitution'=>'required|in:Sole Propritor,Partnership,Company,Trust,AOP,Others',
                'specify_if_other'=>$valid,
                'pan_file' => $pan.'|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'cancel_cheque_file' => $cheq.'|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048'
            ];
    }
}
