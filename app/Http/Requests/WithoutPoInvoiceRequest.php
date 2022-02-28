<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class WithoutPoInvoiceRequest extends FormRequest
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
        $vendor=\App\Vendor::where(['account_status'=>'3','status'=>'1']);
        $array=[];
        if ($vendor->count()) {
           foreach ($vendor->get() as $key => $value) {
               $array[]=$value->id;
           }
        }
        $debit_account=$amount=$cost_center=$category='';
        if (Auth::guard('employee')->user()->role_id==9) {
            $debit_account=$cost_center=$category='required';
            $amount='required|numeric';
        }
        $data=\App\WithoutPoInvoice::where('order_id',$this->slug)->first();
        $id=$data->id ?? '';
        return [
            'vendor'=>'required|exists:vendors,id|in:'.implode(',', $array),
            'invoice_date.*'=>'required|before_or_equal:'.date('Y-m-d'),
            'invoice_number.*'=>'required|unique:without_po_invoices,invoice_number,'.$id,
            'invoice_amount.*'=>'required|numeric|min:0',
            'image.*'=>'required|mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048',
            'debit_account.*'=>$debit_account,
            'amount.*'=>$amount,
            'cost_center.*'=>$cost_center,
            'category.*'=>$category,
            'bank_account.*'=>'',
            'ifsc.*'=>'',
            'bank_name.*'=>'',
            'advance_payment_mode.*'=>'',
            'apex'=>'required|exists:apexes,id'
        ];
    }
}
