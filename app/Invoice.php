<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\PurchaseOrder;
class Invoice extends Model
{
	public static function invoiceStatus($value='')
    {
        $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved', '5' => 'Trust Office Approved', '6' => 'Payment Office Approved', '7' => 'TDS Office Approved'];
        //$data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
 
    public static function invoiceStatusChange($value='')
    {
        if (Auth::guard('employee')->user()->role_id==5) {
            $data=['2' => 'Rejected', '3' => 'Approved'];
        }
        elseif (Auth::guard('employee')->user()->role_id==9) {
            $data=['2' => 'Rejected', '4' => 'Approved'];
        }
        else if (Auth::guard('employee')->user()->role_id==7) {
            $data=['2' => 'Rejected', '5' => 'Approved'];
        }else if (Auth::guard('employee')->user()->role_id==10) {
            //$data=['2' => 'Rejected', '6' => 'Payment Office Approved'];
            $data=['2' => 'Reject', '6' => 'Approve'];
        }
        else if (Auth::guard('employee')->user()->role_id==11) {
            //$data=['2' => 'Rejected', '7' => 'TDS Office Approved'];
            $data=['2' => 'Reject', '7' => 'Approve'];
        }else{
            $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved', '5' => 'Trust Office Approved', '6' => 'Payment Office Approve', '7' => ' TDS Office Approve'];
        }
        //$data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Manager Approved', '4' => 'Financer Approved'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public function poDetail($value='')
    {
    	return $this->hasOne('\App\PurchaseOrder','id','po_id');
    }

    public static function invoiceLimit($value='')
    {
        return round($value+($value*10/100));
    }

    public static function tdsMonth($value='')
    {
        $data=['1' => 'January', '2' => 'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function approvedPoInvoice($po_id='')
    {
        return \App\Invoice::where(['po_id'=>$po_id])->where('invoice_status',6)->sum('invoice_amount'); 
    }

    public static function proccessPoInvoice($po_id='')
    {
        return \App\Invoice::where(['po_id'=>$po_id])->whereNotIn('invoice_status',[2,6])->sum('invoice_amount'); 
    }

    public static function poBalance($value='')
    {
        $po=PurchaseOrder::where('id',$value)->first();
        $balance=$po->net_payable;//Invoice::invoiceLimit($po->net_payable);
        return ($balance-(Invoice::approvedPoInvoice($value)+Invoice::proccessPoInvoice($value)));
    }
}
