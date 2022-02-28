<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class PurchaseOrder extends Model
{
    public static function orderStatus($value='')
    {
        if (Auth::guard('employee')->user()->role_id==5) {
            $data=[ '2' => 'Rejected', '3' => 'Approved'];
        }
        else if (Auth::guard('employee')->user()->role_id==7) {
            $data=[ '2' => 'Rejected', '4' => 'Approved'];
        }else{
            $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved'];
        }
        //$data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
    public static function orderStatusView($value='')
    {
        $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function status($value='')
    {
        $data=['1'=>'Active','2'=>'Inactive'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public function poImage($value='')
    {
        return $this->hasMany('\App\PurchaseOrderFile','po_id');
    }

    public static function paymentMethod($value='')
    {
        $data=['1'=>'One Time Payment','2'=>'Recurring Payment'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function natureOfService($value='')
    {
        $data=['Goods'=>'Goods','Services'=>'Services','Both'=>'Goods & Services'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function unit($value='')
    {
        $data = 
        [ 
            "CENTIMETER" => "CENTIMETER",
            "CENTIMETER_SQUARE" => "CENTIMETER-SQUARE",
            "CENTIMETER_CUBE" => "CENTIMETER-CUBE",
            "GALLON" => "GALLON",
            "GRAM" => "GRAM",
            "ITEM" => "ITEM",
            "KILOGRAM" => "KILOGRAM",
            "LBM" => "LBM",
            "LITER" => "LITER",
            "MILLIGRAM" => "MILLIGRAM",
            "MILLIMETER" => "MILLIMETER",
            "MILLIMETER_SQUARE" => "MILLIMETER-SQUARE",
            "MILLIMETER_CUBE" => "MILLIMETER-CUBE",
            "METER" => "METER",
            "METER_SQUARE" => "METER-SQUARE",
            "METER_CUBE" => "METER-CUBE",
            "OUNCE" => "OUNCE",
            "TON" => "TON" 
        ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public function invoice($value='')
    {
        return $this->hasMany('\App\Invoice','po_id');
    }

    public static function chkOrderInvoiceStatus($value='')
    {
        return $approvedIvoice=\App\Invoice::where(['po_id'=>$value])->where('invoice_status','5')->sum('invoice_amount');
    }
}
