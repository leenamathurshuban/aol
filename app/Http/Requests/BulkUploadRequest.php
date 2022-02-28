<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class BulkUploadRequest extends FormRequest
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
        $category=\App\BulkUpload::category();
        $category=implode(',', array_keys($category));
        $bank=\App\BulkUpload::bank();
        $bank=implode(',', array_keys($bank));
        $paymentType=\App\BulkUpload::paymentType();
        $paymentType=implode(',', array_keys($paymentType));
        return [
            'category'=>'required|in:'.$category,
            'specify_detail'=>'required',
            'bank_formate'=>'required|in:'.$bank,
            'payment_type'=>'required|in:'.$paymentType,
            'supporting_file.*'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048',
            'bulk_attachment_file'=>'required|mimes:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp|max:2048',
            'apex'=>'required|exists:apexes,id'
        ];
    }
}
