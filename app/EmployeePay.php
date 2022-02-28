<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class EmployeePay extends Model
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

    public static function EmpPayStatusChange($value='')
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
        }
        else if (Auth::guard('employee')->user()->role_id==11) {
            //$data=['2' => 'Rejected', '7' => 'TDS Office Approved'];
            $data=['2' => 'Reject', '7' => 'Approve'];
        }else{
           // $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved', '5' => 'Trust Office Approved'];
            $data=['1' => 'Pending', '2' => 'Reject', '3' => 'Approve', '4' => 'Approve', '5' => 'Approve', '6' => 'Approve', '7' => 'Approve'];
        }
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
    public static function tdsMonth($value='')
    {
        // $data=['1' => 'January', '2' => 'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'];
        // if ($value) {
        //     return $data[$value];
        // }else{
        //     return $data;
        // }
        return $value;
    }

    public function empReqImage($value='')
    {
        return $this->hasMany('\App\EmployeePayFile','emp_req_id','id');
    }

    public static function medicalCategory($value='')
    {
       $data=['Hospitalization' => 'Hospitalization', 'Prophylactic' => 'Prophylactic','Others'=>'Others'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
}
