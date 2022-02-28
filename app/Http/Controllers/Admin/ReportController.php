<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\User;
use App\Vendor;
use App\Employee;
use App\PurchaseOrder;
use App\Invoice;
use App\WithoutPoInvoice;
use Auth;
use App\State;
use App\City; 
use App\Setting;
use App\InternalTransfer;
use App\EmployeePay;
use App\BulkUpload;
use App\BulkCsvUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminRequestReportExport;
use App\Exports\AdminSingleRequestExport;
use App\Exports\AdminTdsRequestExport;
use App\Exports\AdminInvoicePaymentRequestExport;
class ReportController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 5;
    }

    public function employeeInvoice($invoice_number='',$status='',$from='',$to='',$employee='',$manager='')
    {
    	extract($_GET);
    	$data=Invoice::orderBy('id','desc');
    	if ($status) {
    		$data->where('invoice_status',$status);
    	}
    	if ($invoice_number) {
    		$data->where('order_id',$invoice_number);
    	}
    	if ($from && $to=='') {
    		$data->whereDate('created_at',$from);
    	}
    	if ($from && $to) {
    		$data->whereBetween('created_at',[$from,$to]);
    	}
    	if ($employee) {
    		//$data->where('employee_id',Employee::where('employee_code',$employee)->first()->id ?? '');
            $data->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
    	}
    	if ($manager) {
    		$data->where('employee_id',Employee::where('employee_code',$manager)->first()->id ?? '');
    	}
    	$total=$data->count();
    	$data=$data->paginate($this->paginate);
    	$page=($data->perPage()*($data->currentPage() -1));
    	$emp=\App\Vendor::approvedPoVendor();//Employee::where('role_id',4)->pluck('name','employee_code');
    	$mng=Employee::where('role_id',5)->pluck('name','employee_code');
    	return view('admin.report.employeeInvoice',compact('data','total','invoice_number','page','status','from','to','emp','employee','manager','mng'));
    }

    public function employeeWithoutPoInvoice($invoice_number='',$status='',$from='',$to='',$employee='',$manager='')
    {
    	extract($_GET);
    	$data=WithoutPoInvoice::orderBy('id','desc');
    	if ($status) {
    		$data->where('invoice_status',$status);
    	}
    	if ($invoice_number) {
    		$data->where('order_id',$invoice_number);
    	}
    	if ($from && $to=='') {
    		$data->whereDate('created_at',$from);
    	}
    	if ($from && $to) {
    		$data->whereBetween('created_at',[$from,$to]);
    	}
    	if ($employee) {
    		//$data->where('employee_id',Employee::where('employee_code',$employee)->first()->id ?? '');
            $data->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
    	}
    	if ($manager) {
    		$data->where('employee_id',Employee::where('employee_code',$manager)->first()->id ?? '');
    	}
    	$total=$data->count();
    	$data=$data->paginate($this->paginate);
    	$page=($data->perPage()*($data->currentPage() -1));
    	$emp=\App\Vendor::approvedPoVendor();//Employee::where('role_id',4)->pluck('name','employee_code');
    	$mng=Employee::where('role_id',5)->pluck('name','employee_code');

    	return view('admin.report.employeeWithoutPoInvoice',compact('data','total','invoice_number','page','status','from','to','emp','employee','manager','mng'));
    }

    public function getInvoiceDetail(Request $request)
    {
        if ($request->type=='viewDetail') {
            $po=PurchaseOrder::where('order_id',$request->slug)->first();
            $data=Invoice::where('po_id',$po->id)->get();
            if($data){
                $type=$request->type;
                return view('admin/report/ajax',compact('data','type','po'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='InvoiceDetail') {
            $data=Invoice::where('invoice_number',$request->slug)->first();
            $po=PurchaseOrder::where('id',$data->po_id)->first();
            if($data){
                $type=$request->type;
                return view('admin/report/ajax',compact('data','type','po'));
            }else{
               return '<h2>Data not found.</h2>';
            }

        } 
    }
    public function getWithoutPoInvoiceDetail(Request $request)
    {
        $data=WithoutPoInvoice::where('order_id',$request->slug)->first();
        if($data){
            $type='viewWithoutPoDetail';
            return view('admin/report/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function allVendorList($name='',$status='',$from='',$to='')
    {
        extract($_GET);
        $states=State::pluck('name','id');
        $cities=City::pluck('name','id');
        $data=Vendor::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%")->orWhere('vendor_code',$name);
        }
        if ($status) {
            $data->where('account_status',$status);
        }
        if ($from && $to=='') {
            $data->whereDate('created_at',$from);
        }
        if ($from && $to) {
            $data->whereBetween('created_at',[$from,$to]);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        $currentPage=$data->currentPage();
        return view('admin/report/allVendorList',compact('data','name','page','total','states','cities','currentPage','status','from','to'));
    }

    public function vendorStatusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
        $data=Vendor::where('id',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->back()->with('success', 'Status changed successfully !');
        }else{
           return redirect()->back()->with('failed', 'Failed ! try again.');
        }
    }
    public function getVendorDetail($value='')
    {
        $data=Vendor::where('id',$_POST['slug'])->first();
        if($data){
            $type='getVendorDetail';
            return view('admin/report/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }
 
    public function allAdminRequest($order_id='',$from='',$to='',$request_type='')
    {
        extract($_GET);
        if($request_type){
            $this->paginate=10;
        }
        $invoice=Invoice::orderBy('id','desc');
        if($request_type=='inv'){
            if ($order_id) {
                $invoice->where('invoice_number',$order_id);
            }
            if ($from && $to=='') {
                $invoice->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $invoice->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $invoice->where('id','0');
        }
        $withoutPOinvoice=WithoutPoInvoice::orderBy('id','desc');
        if($request_type=='wdinv'){
            if ($order_id) {
                $withoutPOinvoice->where('invoice_number',$order_id);
            }
            if ($from && $to=='') {
                $withoutPOinvoice->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $withoutPOinvoice->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $withoutPOinvoice->where('id','0');
        }
        $po=PurchaseOrder::orderBy('id','desc');
        if($request_type=='po'){
            if ($order_id) {
                $po->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $po->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $po->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $po->where('id','0');
        }
        $bnkTrans=InternalTransfer::orderBy('id','desc');
        if($request_type=='bnkRtrn'){
            if ($order_id) {
                $bnkTrans->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $bnkTrans->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $bnkTrans->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $bnkTrans->where('id','0');
        }
        $empPay=EmployeePay::orderBy('id','desc');
        if($request_type=='empPay'){
            if ($order_id) {
                $empPay->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $empPay->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $empPay->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='bulkUp')) {
            $empPay->where('id','0');
        }
        $bulkUp=BulkUpload::orderBy('id','desc');
        if($request_type=='bulkUp'){
            if ($order_id) {
                $bulkUp->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $bulkUp->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $bulkUp->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
            $bulkUp->where('id','0');
        }

        $invTot=$invoice->count();
        $widInvTot=$withoutPOinvoice->count();
        $poTot=$po->count();
        $bnkTransTot=$bnkTrans->count();
        $empPayTot=$empPay->count();
        $bulkUpTot=$bulkUp->count();

        $invoiceData=$invoice->paginate($this->paginate);
        $withoutPOinvoiceData=$withoutPOinvoice->paginate($this->paginate);
        $poData=$po->paginate($this->paginate);
        $bnkTransData=$bnkTrans->paginate($this->paginate);
        $empPayData=$empPay->paginate($this->paginate);
        $bulkUpData=$bulkUp->paginate($this->paginate);

        $page=($poData->perPage()*($poData->currentPage()-1))+($withoutPOinvoiceData->perPage()*($withoutPOinvoiceData->currentPage()-1))+($invoiceData->perPage()*($invoiceData->currentPage()-1))+($bnkTransData->perPage()*($bnkTransData->currentPage()-1))+($empPayData->perPage()*($empPayData->currentPage()-1))+($bulkUpData->perPage()*($bulkUpData->currentPage()-1));
         //echo ($invTot >= $widInvTot) ? (($invTot >= $poTot) ? $invTot : $poTot): (($poTot >= $widInvTot) ? $poTot :  $widInvTot);
         $total=$invTot+$widInvTot+$poTot+$bnkTransTot+$empPayTot+$bulkUpTot;
        return view('admin.report.allRequest',compact('total','invoiceData','withoutPOinvoiceData','poData','page','invTot','widInvTot','poTot','bnkTransData','bnkTransTot','order_id','from','to','request_type','empPayTot','empPayData','bulkUpTot','bulkUpData'));
    }
    public function getAdminRequestRepDetail(Request $request)
    {
        $type=$request->type;
         if ($request->type=='empPay') {
            $data=EmployeePay::where('order_id',$request->slug)->first();
            if($data){
                $type='empPayDetail';
                return view('admin/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='bulkUp') {
            $data=BulkUpload::where('order_id',$request->slug)->first();
            if($data){
                $type='BulkUploadDetail';
                return view('admin/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='inv') {
            $po=PurchaseOrder::where('id',$_POST['slug'])->first();
            $data=Invoice::where('po_id',$po->id)->get();
            $type='viewDetail';
            if($data){
                return view('admin/report/ajax',compact('data','type','po'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='wdinv') {
            $data=WithoutPoInvoice::where('order_id',$request->slug)->first();
            if($data){
                $type='viewWithoutPoDetail';
                return view('admin/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }

        if ($request->type=='po') {
            $data=PurchaseOrder::with('poImage')->where('order_id',$request->slug)->first();
            if($data){
                $type='viewPoDetail';
                return view('admin/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='bnkRtrn') {
            $data=InternalTransfer::where('order_id',$request->slug)->first();
            if($data){
                $type='getInternalTrnsDetail';
                return view('admin/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
    }

    public function employeeEmployeePay($unique_id='',$status='',$from='',$to='',$employee='',$pay_for='')
    {
        //route employeePayReport employeePay
        extract($_GET);
        $data=EmployeePay::orderBy('id','desc');
        if ($status) {
            $data->where('status',$status);
        }
        if ($unique_id) {
            $data->where('order_id',$unique_id);
        }
        if ($from && $to=='') {
            $data->whereDate('created_at',$from);
        }
        if ($from && $to) {
            $data->whereBetween('created_at',[$from,$to]);
        }
        if ($employee) {
            $data->where('employee_id',Employee::where('employee_code',$employee)->first()->id ?? '');
        }
        if ($pay_for) {
            $data->where('employee_id',Employee::where('employee_code',$pay_for)->first()->id ?? '');
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page=($data->perPage()*($data->currentPage() -1));
        $emp=Employee::where('role_id',4)->pluck('name','employee_code');
        return view('admin.report.employeePay',compact('data','total','unique_id','page','status','from','to','emp','employee','pay_for'));
    }

    public function employeePaidReport($unique_id='',$status='',$from='',$to='',$employee='',$pay_for='')
    {
        //route employeePayReport employeePay
        extract($_GET);
        $data=EmployeePay::orderBy('id','desc');
        if ($status) {
            $data->where('status',$status);
        }
        if ($unique_id) {
            $data->where('order_id',$unique_id);
        }
        if ($from && $to=='') {
            $data->whereDate('date_of_payment',$from);
        }
        if ($from && $to) {
            $data->whereBetween('date_of_payment',[$from,$to]);
        }
        if ($employee) {
            $data->where('employee_id',Employee::where('employee_code',$employee)->first()->id ?? '');
        }
        if ($pay_for) {
           // $data->where('employee_id',Employee::where('employee_code',$pay_for)->first()->id ?? '');
            $accDT = $data;
            if ($accDT->count()) {
                $empId=[];
                foreach ($accDT->get() as $dtkey => $dtvalue) {
                    $item=json_decode($dtvalue->form_by_account);
                    if($dtvalue->form_by_account && $item){
                        if ($item->bank_account==$pay_for) {
                            $empId[]=$dtvalue->id;
                        }
                    }
                }
                 $data->whereIn('id',$empId);
            }
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page=($data->perPage()*($data->currentPage() -1));
        $emp=Employee::where('role_id',4)->pluck('name','employee_code');
        return view('admin.report.employeePaidReport',compact('data','total','unique_id','page','status','from','to','emp','employee','pay_for'));
    }

    public function employeePOreport($order_id='',$status='',$from='',$to='',$employee='')
    {
        //route employeePOreport
         //route employeeInternalTransferReport
        extract($_GET);
        $data=PurchaseOrder::orderBy('id','desc');
        if ($status) {
            $data->where('status',$status);
        }
        if ($order_id) {
            $data->where('order_id',$order_id);
        }
        if ($from && $to=='') {
            $data->whereDate('created_at',$from);
        }
        if ($from && $to) {
            $data->whereBetween('created_at',[$from,$to]);
        }
        if ($employee) {
            $data->where('user_id',Employee::where('employee_code',$employee)->first()->id ?? '');
        }
       
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page=($data->perPage()*($data->currentPage() -1));
        $emp=Employee::where('role_id',4)->pluck('name','employee_code');
        return view('admin.report.poReport',compact('data','total','order_id','page','status','from','to','emp','employee'));
    }

    public function employeePoVendorWiseReport($order_id='',$status='',$from='',$to='',$employee='')
    {
        //route employeePOreport
         //route employeeInternalTransferReport
        extract($_GET);
        $data=PurchaseOrder::orderBy('id','desc');
        if ($status) {
            $data->where('status',$status);
        }
        if ($order_id) {
            $data->where('order_id',$order_id);
        }
        if ($from && $to=='') {
            $data->whereDate('po_start_date',$from);
        }
        if ($from && $to) {
            $data->whereBetween('po_start_date',[$from,$to]);
        }
        if ($employee) {
            //$data->where('user_id',Employee::where('employee_code',$employee)->first()->id ?? '');
            $data->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
        }
       
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page=($data->perPage()*($data->currentPage() -1));
        $emp=\App\Vendor::approvedPoVendor();//Employee::where('role_id',5)->pluck('name','employee_code');
        return view('admin.report.poVendorWiseReport',compact('data','total','order_id','page','status','from','to','emp','employee'));
    }

    public function employeeInternalTransferReport($order_id='',$status='',$from='',$to='',$employee='')
    {
        //route employeeInternalTransferReport
        extract($_GET);
        $data=InternalTransfer::orderBy('id','desc')->where('nature_of_request','Inter bank transfer');
        if ($status) {
            $data->where('status',$status);
        }
        if ($order_id) {
            $data->where('order_id',$order_id);
        }
        if ($from && $to=='') {
            $data->whereDate('transaction_date',$from);
        }
        if ($from && $to) {
            $data->whereBetween('transaction_date',[$from,$to]);
        }
        if ($employee) {
            $data->where('employee_id',Employee::where('employee_code',$employee)->first()->id ?? '');
        }
        
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page=($data->perPage()*($data->currentPage() -1));
        $emp=Employee::where('role_id',4)->pluck('name','employee_code');
        return view('admin.report.internalTransfer',compact('data','total','order_id','page','status','from','to','emp','employee'));
    }
    public function employeeStateTransferReport($order_id='',$status='',$from='',$to='',$employee='')
    {
        //route employeeInternalTransferReport
        extract($_GET);
        $data=InternalTransfer::orderBy('id','desc')->where('nature_of_request','State requesting funds');
        if ($status) {
            $data->where('status',$status);
        }
        if ($order_id) {
            $data->where('order_id',$order_id);
        }
        if ($from && $to=='') {
            $data->whereDate('date_of_payment',$from);
        }
        if ($from && $to) {
            $data->whereBetween('date_of_payment',[$from,$to]);
        }
        if ($employee) {
            $data->where('employee_id',Employee::where('employee_code',$employee)->first()->id ?? '');
        }
       
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page=($data->perPage()*($data->currentPage() -1));
        $emp=Employee::where('role_id',4)->pluck('name','employee_code');
        return view('admin.report.internalStateTransfer',compact('data','total','order_id','page','status','from','to','emp','employee'));
    }

    public function employeeBulkUploadReport($order_id='',$status='',$from='',$to='',$employee='')
    {
        
        extract($_GET);
        $data=BulkCsvUpload::with('bulkUpload');
        if ($order_id) {
            $data->where('bulk_upload_id',BulkUpload::where('order_id',$order_id)->first()->id ?? '');
        }
        if ($from && $to=='') {
            $data->where('bulk_upload_id',BulkUpload::where('date_of_payment',$from)->first()->id ?? '');
        }
        if ($from && $to) {
             $data->where('bulk_upload_id',BulkUpload::whereBetween('date_of_payment',[$from,$to])->first()->id ?? '');
        }
       
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page=($data->perPage()*($data->currentPage() -1));
        $emp=Employee::where('role_id',4)->pluck('name','employee_code');
        return view('admin.report.bulkUpload',compact('data','total','order_id','page','status','from','to','emp','employee'));
    }

    public function employeePaymentReportInvoice($order_id='',$from='',$to='',$employee='')
    {
        extract($_GET);
        $invoice=Invoice::orderBy('id','desc');

            if ($order_id) {
                $invoice->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $invoice->whereDate('date_of_payment',$from);
            }
            if ($from && $to) {
                $invoice->whereBetween('date_of_payment',[$from,$to]);
            }
            if ($employee) {
                //$data->where('user_id',Employee::where('employee_code',$employee)->first()->id ?? '');
                $invoice->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
            }

        $withoutPOinvoice=WithoutPoInvoice::orderBy('id','desc');

            if ($order_id) {
                $withoutPOinvoice->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $withoutPOinvoice->whereDate('date_of_payment',$from);
            }
            if ($from && $to) {
                $withoutPOinvoice->whereBetween('date_of_payment',[$from,$to]);
            }
            if ($employee) {
                //$data->where('user_id',Employee::where('employee_code',$employee)->first()->id ?? '');
                $withoutPOinvoice->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
            }

        $invTot=$invoice->count();
        $widInvTot=$withoutPOinvoice->count();

        $invoiceData=$invoice->paginate($this->paginate);
        $withoutPOinvoiceData=$withoutPOinvoice->paginate($this->paginate);

        $page=($withoutPOinvoiceData->perPage()*($withoutPOinvoiceData->currentPage()-1))+($invoiceData->perPage()*($invoiceData->currentPage()-1));
         //echo ($invTot >= $widInvTot) ? (($invTot >= $poTot) ? $invTot : $poTot): (($poTot >= $widInvTot) ? $poTot :  $widInvTot);
        $emp=\App\Vendor::approvedPoVendor();//Employee::where('role_id',5)->pluck('name','employee_code');
         $total=$invTot+$widInvTot;
        return view('admin.report.invoicePaymentReport',compact('total','invoiceData','withoutPOinvoiceData','page','invTot','widInvTot','order_id','from','to','employee','emp'));
    }

    public function allTdsPayableReport($order_id='',$from='',$to='',$request_type='')
    {
        extract($_GET);
        if($request_type){
            $this->paginate=10;
        }
        $invoice=Invoice::orderBy('id','desc')->where('tds','>',0);
        //if($request_type=='inv'){
            if ($order_id) {
                $invoice->where('invoice_number',$order_id);
            }
            if ($from && $to=='') {
                $invoice->whereDate('date_of_payment',$from);
            }
            if ($from && $to) {
                $invoice->whereBetween('date_of_payment',[$from,$to]);
            }
       // }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $invoice->where('id','0');
        }
        $withoutPOinvoice=WithoutPoInvoice::orderBy('id','desc')->where('tds','>',0);
        //if($request_type=='wdinv'){
            if ($order_id) {
                $withoutPOinvoice->where('invoice_number',$order_id);
            }
            if ($from && $to=='') {
                $withoutPOinvoice->whereDate('date_of_payment',$from);
            }
            if ($from && $to) {
                $withoutPOinvoice->whereBetween('date_of_payment',[$from,$to]);
            }
        //}
        if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $withoutPOinvoice->where('id','0');
        }
        $po=PurchaseOrder::orderBy('id','desc');
        if($request_type=='po'){
            if ($order_id) {
                $po->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $po->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $po->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $po->where('id','0');
        }
        $bnkTrans=InternalTransfer::orderBy('id','desc');
        if($request_type=='bnkRtrn'){
            if ($order_id) {
                $bnkTrans->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $bnkTrans->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $bnkTrans->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='empPay' || $request_type=='bulkUp')) {
            $bnkTrans->where('id','0');
        }
        $empPay=EmployeePay::orderBy('id','desc')->where('tds','>',0);
       // if($request_type=='empPay'){
            if ($order_id) {
                $empPay->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $empPay->whereDate('date_of_payment',$from);
            }
            if ($from && $to) {
                $empPay->whereBetween('date_of_payment',[$from,$to]);
            }
       // }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='bulkUp')) {
            $empPay->where('id','0');
        }
        $bulkUp=BulkUpload::orderBy('id','desc');
        if($request_type=='bulkUp'){
            if ($order_id) {
                $bulkUp->where('order_id',$order_id);
            }
            if ($from && $to=='') {
                $bulkUp->whereDate('created_at',$from);
            }
            if ($from && $to) {
                $bulkUp->whereBetween('created_at',[$from,$to]);
            }
        }
        if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
            $bulkUp->where('id','0');
        }

        $invTot=$invoice->count();
        $widInvTot=$withoutPOinvoice->count();
        $poTot=0;//$po->count();
        $bnkTransTot=0;//$bnkTrans->count();
        $empPayTot=$empPay->count();
        $bulkUpTot=0;//$bulkUp->count();

        $invoiceData=$invoice->paginate($this->paginate);
        $withoutPOinvoiceData=$withoutPOinvoice->paginate($this->paginate);
        $poData=$po->paginate($this->paginate);
        $bnkTransData=$bnkTrans->paginate($this->paginate);
        $empPayData=$empPay->paginate($this->paginate);
        $bulkUpData=$bulkUp->paginate($this->paginate);

       // $page=($poData->perPage()*($poData->currentPage()-1))+($withoutPOinvoiceData->perPage()*($withoutPOinvoiceData->currentPage()-1))+($invoiceData->perPage()*($invoiceData->currentPage()-1))+($bnkTransData->perPage()*($bnkTransData->currentPage()-1))+($empPayData->perPage()*($empPayData->currentPage()-1))+($bulkUpData->perPage()*($bulkUpData->currentPage()-1));

        $page=($withoutPOinvoiceData->perPage()*($withoutPOinvoiceData->currentPage()-1))+($invoiceData->perPage()*($invoiceData->currentPage()-1))+($empPayData->perPage()*($empPayData->currentPage()-1));

         //echo ($invTot >= $widInvTot) ? (($invTot >= $poTot) ? $invTot : $poTot): (($poTot >= $widInvTot) ? $poTot :  $widInvTot);
         $total=$invTot+$widInvTot+$poTot+$bnkTransTot+$empPayTot+$bulkUpTot;
        return view('admin.report.allTdsPayableReport',compact('total','invoiceData','withoutPOinvoiceData','poData','page','invTot','widInvTot','poTot','bnkTransData','bnkTransTot','order_id','from','to','request_type','empPayTot','empPayData','bulkUpTot','bulkUpData'));
    }

    public function adminAllRequestExport(Request $request) 
    {
        if ($request->request_type) {
            $request->validate(['request_type'=>'in:empPay,inv,wdinv,bnkRtrn,bulkUp,po']);
        }
        //$request->validate(['request_type'=>'required|in:empPay,inv,wdinv,bnkRtrn,bulkUp']);

            $request_type=$request->request_type;
            $from=$request->from ?? '';
            $to=$request->to;


                $invoice = Invoice::orderBy('id','desc');
                if ($from && $to=='') {
                    $invoice->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('created_at',[$from,$to]);
                }
                if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
                        $invoice->where('id','0');
                    }

                 $wdinvoice= WithoutPoInvoice::orderBy('id','desc');
                 if ($from && $to=='') {
                    $wdinvoice->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $wdinvoice->whereBetween('created_at',[$from,$to]);
                }
                if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
                        $wdinvoice->where('id','0');
                    }

                $empPay = EmployeePay::orderBy('id','desc');
                if ($from && $to=='') {
                    $empPay->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $empPay->whereBetween('created_at',[$from,$to]);
                }

                if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='wdinv' || $request_type=='bulkUp')) {
                        $empPay->where('id','0');
                    }

                $purchaseOrder = PurchaseOrder::orderBy('id','desc');
                if ($from && $to=='') {
                    $purchaseOrder->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $purchaseOrder->whereBetween('created_at',[$from,$to]);
                }

                if ($request_type && ($request_type=='inv' || $request_type=='empPay' || $request_type=='bnkRtrn' || $request_type=='wdinv' || $request_type=='bulkUp')) {
                        $purchaseOrder->where('id','0');
                    }

                $internalTransfer = InternalTransfer::orderBy('id','desc');
                if ($from && $to=='') {
                    $internalTransfer->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $internalTransfer->whereBetween('created_at',[$from,$to]);
                }

                if ($request_type && ($request_type=='inv' || $request_type=='empPay' || $request_type=='po' || $request_type=='wdinv' || $request_type=='bulkUp')) {
                        $internalTransfer->where('id','0');
                    }

                $bulkUpload = BulkUpload::orderBy('id','desc');
                if ($from && $to=='') {
                    $bulkUpload->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $bulkUpload->whereBetween('created_at',[$from,$to]);
                }

                if ($request_type && ($request_type=='inv' || $request_type=='empPay' || $request_type=='po' || $request_type=='wdinv' || $request_type=='bnkRtrn')) {
                        $bulkUpload->where('id','0');
                    }
            //return $invoice->get()->toArray();
            $arrays = [$invoice->get()->toArray(),$wdinvoice->get()->toArray(),$empPay->get()->toArray(),$purchaseOrder->get()->toArray(),$internalTransfer->get()->toArray(),$bulkUpload->get()->toArray()];

            return Excel::download(new AdminRequestReportExport($request_type,$from,$to,$arrays), 'request-data-'.date('d-m-y').'.xlsx');
        
    }

    public function AdminSingleRequestExport(Request $request,$slug=null) 
    {
        if ($slug && in_array($slug, ['empPay','inv','wdinv','bnkRtrn','bulkUp','interStateRtrn','empPaidRep','po','poVendor'])) {

            $vendor=$employee=$acc_no='';
            if ($request->vendor) {
                $request->validate(['vendor'=>'exists:vendors,vendor_code']);
                //$data->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
                $vendor=$request->vendor;
            }if ($request->employee) {
                $request->validate(['employee'=>'exists:employees,employee_code']);
                //$data->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
                $employee=$request->employee;
            }if ($request->acc_no) {
                $acc_no=$request->acc_no;
            }
            $request_type=$slug;
            $from=$request->from ?? '';
            $to=$request->to;
            return Excel::download(new AdminSingleRequestExport($request_type,$from,$to,['vendor'=>$vendor,'employee'=>$employee,'acc_no'=>$acc_no]), 'request-data-'.date('d-m-y').'.xlsx');
        }else{
            return redirect()->back()->with('failed','Something error');
        }
        
            
       
    }

    public function adminTdsRequestExport(Request $request) 
    {
        if ($request->request_type) {
            $request->validate(['request_type'=>'in:empPay,inv,wdinv']);
        }
        //$request->validate(['request_type'=>'required|in:empPay,inv,wdinv,bnkRtrn,bulkUp']);

            $request_type=$request->request_type;
            $from=$request->from ?? '';
            $to=$request->to;


                $invoice = Invoice::orderBy('id','desc')->where('tds','>',0);
                if ($from && $to=='') {
                    $invoice->whereDate('date_of_payment',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('date_of_payment',[$from,$to]);
                }
                if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
                        $invoice->where('id','0');
                    }

                 $wdinvoice= WithoutPoInvoice::orderBy('id','desc')->where('tds','>',0);
                 if ($from && $to=='') {
                    $wdinvoice->whereDate('date_of_payment',$from);
                }
                if ($from && $to) {
                    $wdinvoice->whereBetween('date_of_payment',[$from,$to]);
                }
                if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay' || $request_type=='bulkUp')) {
                        $wdinvoice->where('id','0');
                    }

                $empPay = EmployeePay::orderBy('id','desc')->where('tds','>',0);
                 if ($from && $to=='') {
                    $empPay->whereDate('date_of_payment',$from);
                }
                if ($from && $to) {
                    $empPay->whereBetween('date_of_payment',[$from,$to]);
                }

                if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='wdinv' || $request_type=='bulkUp')) {
                        $empPay->where('id','0');
                    }

                
            //return $invoice->get()->toArray();
            $arrays = [$invoice->get()->toArray(),$wdinvoice->get()->toArray(),$empPay->get()->toArray()];

            return Excel::download(new AdminTdsRequestExport($request_type,$from,$to,$arrays), 'request-data-'.date('d-m-y').'.xlsx');
        
    }

    public function adminInvoicePaymentRequestExport(Request $request) 
    {
        if ($request->vendor) {
            $request->validate(['vendor'=>'exists:vendors,vendor_code']);
            //$data->where('vendor_id',Vendor::where('vendor_code',$employee)->first()->id ?? '');
            $vendor=$request->vendor;
        }
        //$request->validate(['request_type'=>'required|in:empPay,inv,wdinv,bnkRtrn,bulkUp']);

            $from=$request->from ?? '';
            $to=$request->to;


                $invoice = Invoice::orderBy('id','desc');
                if ($from && $to=='') {
                    $invoice->whereDate('date_of_payment',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('date_of_payment',[$from,$to]);
                }
                if ($request->vendor) {
                    $invoice->where('vendor_id',Vendor::where('vendor_code',$request->vendor)->first()->id ?? '');
                }
               
                 $wdinvoice= WithoutPoInvoice::orderBy('id','desc');
                 if ($from && $to=='') {
                    $wdinvoice->whereDate('date_of_payment',$from);
                }
                if ($from && $to) {
                    $wdinvoice->whereBetween('date_of_payment',[$from,$to]);
                }
                if ($request->vendor) {
                    $wdinvoice->where('vendor_id',Vendor::where('vendor_code',$request->vendor)->first()->id ?? '');
                }
               
            //return $invoice->get()->toArray();
            $arrays = [$invoice->get()->toArray(),$wdinvoice->get()->toArray()];

            return Excel::download(new AdminInvoicePaymentRequestExport($from,$to,$arrays), 'request-data-'.date('d-m-y').'.xlsx');
        
    }
    
}


