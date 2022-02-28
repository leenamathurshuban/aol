<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BulkUpload extends Model
{
    public static function requestStatus($value='')
    {
        $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Account Office Approved', '5' => 'Trust Office Approved', '6' => 'Payment Office Approved', '7' => 'TDS Office Approved'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function bulkUploadStatusChange($value='')
    {
        if (Auth::guard('employee')->user()->role_id==5) {
            //$data=['2' => 'Rejected', '3' => 'Manager Approved'];
            $data=['2' => 'Reject', '3' => 'Approve'];
        }
        elseif (Auth::guard('employee')->user()->role_id==9) {
            //$data=['2' => 'Rejected', '4' => 'Account office Approved'];
            $data=['2' => 'Reject', '4' => 'Approve'];
        }
        else if (Auth::guard('employee')->user()->role_id==7) {
            //$data=['2' => 'Rejected', '5' => 'Trust Office Approved'];
            $data=['2' => 'Reject', '5' => 'Approve'];
        }
        else if (Auth::guard('employee')->user()->role_id==10) {
            //$data=['2' => 'Rejected', '6' => 'Payment Office Approved'];
            $data=['2' => 'Reject', '6' => 'Approve'];
        }else if (Auth::guard('employee')->user()->role_id==11) {
            //$data=['2' => 'Rejected', '6' => 'Payment Office Approved'];
            $data=['2' => 'Reject', '7' => 'Approve'];
        }else{
            $data=['1' => 'Pending', '2' => 'Reject', '3' => 'Approve', '4' => 'Approve', '5' => 'Approve', '6' => 'Approve', '7' => 'Approve'];
        }
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function category($value='')
    {
    	$data=['1' => 'Teachers Honorarium', '2' => 'Staff Salary & Honorarium', '3' => 'Debit / Credit Card', '4' => 'Course Expenses', '5' => 'TDS Payments', '6' => 'Others'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
    public static function categoryView($value='')
    {
        $data=['1' => 'Teachers Honorarium', '2' => 'Staff Salary & Honorarium', '3' => 'Debit / Credit Card', '4' => 'Course Expenses', '5' => 'TDS Payments', '6' => 'Others'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function bank($value='')
    {
    	$data=['1' => 'SBI', '2' => 'ICICI', '3' => 'HDFC', '4' => 'FEDERAL', '5' => 'IDBI'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
    public static function bankView($value='')
    {
        $data=['1' => 'SBI', '2' => 'ICICI', '3' => 'HDFC', '4' => 'FEDERAL', '5' => 'IDBI'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function paymentType($value='')
    {
    	$data=['1' => 'Within SBI Bank', '2' => 'SBI Outside Bank', '3' => 'Combined ICICI' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function paymentTypeView($value='')
    {
        $data=['1' => 'Within SBI Bank', '2' => 'SBI Outside Bank', '3' => 'Combined ICICI' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public function bulkReqImage($value='')
    {
        return $this->hasMany('\App\BulkUploadFile','bulk_upload_id','id');
    }

    public function bulkCsv($value='')
    {
        return $this->hasMany('\App\BulkCsvUpload','bulk_upload_id','id');
    }
    
    public static function transaction_type($value='')
    {
        $data=['WIB','NFT','RTG','IFC'];
        return $data;
    }

    public static function totCSVAmount($type='',$id='')
    {
        if ($type==3) {
           return \App\BulkCsvUpload::where(['bulk_upload_id'=>$id])->sum('amount');
        }else{
            return \App\BulkCsvUpload::where(['bulk_upload_id'=>$id])->sum('dr_amount');
        }
        
    }
}
