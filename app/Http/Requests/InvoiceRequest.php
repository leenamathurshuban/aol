<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class InvoiceRequest extends FormRequest
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
        $order=\App\PurchaseOrder::where(['account_status'=>'4','status'=>'1','order_id'=>$this->po_number])->first();
        $debit_account=$amount=$cost_center=$category='';
        
        if (Auth::guard('employee')->user()->role_id==9) {
            $debit_account=$cost_center=$category='required';
            $amount='required|numeric';
        }
        $invoiceId=\App\Invoice::where(['invoice_number'=>$this->slug])->first()->id ?? '0';
        $img='required|mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048';
        if ($this->slug) {
           $img='mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048';
        }
        return [
            'vendor'=>'required|exists:vendors,id|in:'.implode(',', $array),
            'po_number'=>'required|exists:purchase_orders,order_id',
            'invoice_date'=>'required|date|after_or_equal:'.$order->po_start_date.'|before_or_equal:'.$order->po_end_date,
            'invoice_number'=>'required|unique:invoices,invoice_number,'.$invoiceId,
            'invoice_amount'=>'required|numeric|min:0',
            'image'=>$img,
            'debit_account'=>$debit_account,
            'amount'=>$amount,
            'cost_center'=>$cost_center,
            'category'=>$category,
            'bank_account'=>'',
            'ifsc'=>'',
            'bank_name'=>'',
            'advance_payment_mode'=>'required|in:Yes,No',
            'apex'=>'required|exists:apexes,id'
        ];
    }
}
 