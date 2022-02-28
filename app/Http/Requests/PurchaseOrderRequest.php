<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class PurchaseOrderRequest extends FormRequest
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
        $advance_tds='';
        if (Auth::guard('employee')->user()->role_id==5) {
            $advance_tds='required|in:Yes,No';
        }
       $rate=$quantity=$discount='';
       
        if ($this->discount) {
            $discount='numeric|min:0';
        }
        
        $vendor=\App\Vendor::where(['account_status'=>'3','status'=>'1']);
        $array=[];
        if ($vendor->count()) {
           foreach ($vendor->get() as $key => $value) {
               $array[]=$value->id;
           }
        }
        if ($this->quantity) {
            $quantity='numeric|min:0';
        }
        if ($this->rate) {
            $rate='numeric|min:0';
        }
        return [
            'vendor'=>'required|exists:vendors,id|in:'.implode(',', $array),
            'po_start_date'=>'date|required',
            'po_end_date'=>'date|required|after_or_equal:po_start_date',
            'payment_method'=>'required|in:1,2',
            'nature_of_service'=>'required|in:Goods,Services,Both',
            'service_detail'=>'',
            'total'=>'',
            'discount'=>$discount,
            'net_payable'=>'',
            'po_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:4048',
            'advance_tds'=>$advance_tds,
            'rate[]'=>$rate,
            'quantity[]'=>$quantity,
            'apex'=>'required|exists:apexes,id'
        ];
    }
}