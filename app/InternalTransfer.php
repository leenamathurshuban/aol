<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class InternalTransfer extends Model
{
    public function internalTransferImage($value='')
    {
        return $this->hasMany('\App\InternalTransferFile','internal_transfer_id','id');
    }

    public static function requestStatus($value='')
    {
        $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Account Office Approved', '4' => 'Trust Office Approved', '5' => 'Payment Office Approved'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function EmpPayStatusChange($value='')
    {
        if (Auth::guard('employee')->user()->role_id==9) {
            $data=['2' => 'Rejected', '3' => 'Approved'];
        }
        else if (Auth::guard('employee')->user()->role_id==7) {
            $data=['2' => 'Rejected', '4' => 'Approved'];
        }
        else if (Auth::guard('employee')->user()->role_id==10) {
            $data=['2' => 'Rejected', '5' => 'Approved'];
        }else{
            $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Account Office Approved', '4' => 'Trust Office Approved', '5' => 'payment Office Approved'];
        }
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
}
