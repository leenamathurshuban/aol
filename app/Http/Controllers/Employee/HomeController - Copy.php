<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeAllRequestExport;
 
use App\Employee;
use App\Invoice;
use App\WithoutPoInvoice;
use App\PurchaseOrder;
use App\InternalTransfer;
use App\BulkUpload;
use App\EmployeePay;//empPay
use App\AssignProcess;
use Auth;
use DB;
use App\Imports\PaymentOfcEmpAppImport;
use App\Imports\PaymentOfcInvAppvImport;
use App\Imports\PaymentOfcWidInvAppvImport;
use App\Imports\PaymentOfcIntrTransfAppvImport;
use App\Imports\PaymentOfcBulkUploadAppvImport;

use App\Helpers\Helper;
class HomeController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 10;
    }
    public function index($order_id='',$from='',$to='',$request_type='')
    {
        extract($_GET);
        
        
        if (Auth::guard('employee')->user()->role_id==10) {
            $invoice=Invoice::where('invoice_status',5)->orderBy('id','desc');
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
            $withoutPOinvoice=WithoutPoInvoice::where('invoice_status',5)->orderBy('id','desc');
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
            $po=PurchaseOrder::where('account_status',5)->orderBy('id','desc');
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
            $bnkTrans=InternalTransfer::where('status',4)->orderBy('id','desc');
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
            $empPay=EmployeePay::where('status',5)->orderBy('id','desc');
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

            $bulkUp=BulkUpload::where('status',5)->orderBy('id','desc');
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
            //$data=Auth::guard('employee')->user();
            return view('employee.paymentDashboard',compact('total','invoiceData','withoutPOinvoiceData','poData','page','invTot','widInvTot','poTot','bnkTransData','bnkTransTot','order_id','from','to','request_type','empPayTot','empPayData','bulkUpTot','bulkUpData'));
            //payment dashboard
        }elseif (Auth::guard('employee')->user()->role_id==11) {
            $invoice=Invoice::where('invoice_status',6)->where('tds_amount', '>', 0)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
                $invoice->where('id','0');
            }
            $withoutPOinvoice=WithoutPoInvoice::where('invoice_status',6)->where('tds_amount', '>', 0)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
                $withoutPOinvoice->where('id','0');
            }
            $po=PurchaseOrder::where('account_status',6)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
                $po->where('id','0');
            }
            $bnkTrans=InternalTransfer::where('status',5)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='empPay')) {
                $bnkTrans->where('id','0');
            }
            $empPay=EmployeePay::where('status',6)->where('tds_amount', '>', 0)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='bnkRtrn')) {
                $empPay->where('id','0');
            }

            $invTot=$invoice->count();
            $widInvTot=$withoutPOinvoice->count();
            $poTot=$po->count();
            $bnkTransTot=$bnkTrans->count();
            $empPayTot=$empPay->count();

            $invoiceData=$invoice->paginate($this->paginate);
            $withoutPOinvoiceData=$withoutPOinvoice->paginate($this->paginate);
            $poData=$po->paginate($this->paginate);
            $bnkTransData=$bnkTrans->paginate($this->paginate);
            $empPayData=$empPay->paginate($this->paginate);

             $page=($poData->perPage()*($poData->currentPage()-1))+($withoutPOinvoiceData->perPage()*($withoutPOinvoiceData->currentPage()-1))+($invoiceData->perPage()*($invoiceData->currentPage()-1))+($bnkTransData->perPage()*($bnkTransData->currentPage()-1))+($empPayData->perPage()*($empPayData->currentPage()-1));
             //echo ($invTot >= $widInvTot) ? (($invTot >= $poTot) ? $invTot : $poTot): (($poTot >= $widInvTot) ? $poTot :  $widInvTot);
             $total=$invTot+$widInvTot+$poTot+$bnkTransTot+$empPayTot;
            //$data=Auth::guard('employee')->user();
            return view('employee.tdsDashboard',compact('total','invoiceData','withoutPOinvoiceData','poData','page','invTot','widInvTot','poTot','bnkTransData','bnkTransTot','order_id','from','to','request_type','empPayTot','empPayData'));
            //TDS dashboard
        }else{
            $invoice=Invoice::where('invoice_status',6)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
                $invoice->where('id','0');
            }
            $withoutPOinvoice=WithoutPoInvoice::where('invoice_status',6)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='inv' || $request_type=='po' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
                $withoutPOinvoice->where('id','0');
            }
            $po=PurchaseOrder::where('account_status',6)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='inv' || $request_type=='bnkRtrn' || $request_type=='empPay')) {
                $po->where('id','0');
            }
            $bnkTrans=InternalTransfer::where('status',5)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='empPay')) {
                $bnkTrans->where('id','0');
            }
            $empPay=EmployeePay::where('status',6)->orderBy('id','desc');
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
            if ($request_type && ($request_type=='wdinv' || $request_type=='po' || $request_type=='inv' || $request_type=='bnkRtrn')) {
                $empPay->where('id','0');
            }

            $invTot=$invoice->count();
            $widInvTot=$withoutPOinvoice->count();
            $poTot=$po->count();
            $bnkTransTot=$bnkTrans->count();
            $empPayTot=$empPay->count();

            $invoiceData=$invoice->paginate($this->paginate);
            $withoutPOinvoiceData=$withoutPOinvoice->paginate($this->paginate);
            $poData=$po->paginate($this->paginate);
            $bnkTransData=$bnkTrans->paginate($this->paginate);
            $empPayData=$empPay->paginate($this->paginate);

             $page=($poData->perPage()*($poData->currentPage()-1))+($withoutPOinvoiceData->perPage()*($withoutPOinvoiceData->currentPage()-1))+($invoiceData->perPage()*($invoiceData->currentPage()-1))+($bnkTransData->perPage()*($bnkTransData->currentPage()-1))+($empPayData->perPage()*($empPayData->currentPage()-1));
             //echo ($invTot >= $widInvTot) ? (($invTot >= $poTot) ? $invTot : $poTot): (($poTot >= $widInvTot) ? $poTot :  $widInvTot);
             $total=$invTot+$widInvTot+$poTot+$bnkTransTot+$empPayTot;
            //$data=Auth::guard('employee')->user();
    	   return view('employee.home',compact('total','invoiceData','withoutPOinvoiceData','poData','page','invTot','widInvTot','poTot','bnkTransData','bnkTransTot','order_id','from','to','request_type','empPayTot','empPayData'));
        }
    }

    public function profile()
    {
        $data=Auth::guard('employee')->user();
    	return view('employee.profile',compact('data'));
    	
    }
   
    public function profileSave(Request $request)
    {
        $request->validate(['name'=>'required','email'=>'required|email|unique:vendors,email,'.Auth::guard('employee')->user()->id]);
        $data=Employee::where(['id'=>Auth::guard('employee')->user()->id])->first();
        $data->name=$request->name;
        $data->email=$request->email;
        if ($data->save()) {
           return redirect()->route('employee.profile')->with('success','Profile updated Successfully');
        }else{
            return redirect()->route('employee.profile')->with('failed','Sorry ! Please try again');
        }
    }

    public function passwordSave(Request $request)
    {
       $request->validate(['current_password'=>'required','new_password'=>'required|min:6|different:current_password','confirm_password'=>'required|same:new_password']);
       if (Hash::check($request->current_password, Auth::guard('employee')->user()->password)) 
       { 
            $user=Employee::where(['id'=>Auth::guard('employee')->user()->id])->first();
           $user->fill([
            'password' => Hash::make($request->new_password)
            ])->save();

            return redirect()->route('employee.profile')->with('success', 'Password changed Successfully');

        } else {

            return redirect()->route('employee.profile')->with('failed','Sorry ! Old Password does not match');
        }

    }

    public function userForm($slug='')
    {
        $pdata = AssignProcess::where('slug',$slug)->first()->id;
        $empId = Auth::guard('employee')->user()->id;
        $role_Id = Auth::guard('employee')->user()->role_id;
        $managers = Employee::select(DB::raw('CONCAT(name, " ", employee_code) AS name, id'))
           ->pluck('name','id');
        if (Employee::chkProccess($empId,$pdata)) {
            if ($pdata==2 && $role_Id==4) {
              return view('employee.userForm.userForm',compact('managers'));
            }/*else if($pdata==3){
                echo 'Vendor Pay in proccess';
            }else if($pdata==5){
                echo 'Bulk Pay in proccess';
            }else if($pdata==6){
                echo 'Transfers in proccess';
            }*/else{
                return redirect()->route('employee.home')->with('failed','Contact to admin for access this form');
            }
        }else{
            return redirect()->route('employee.home')->with('failed','Contact to admin for access this form');
        }
        
    }

    public function getEmpRequestRepDetail(Request $request)
    {
        $type=$request->type;
        if ($request->type=='empPay') {
            $data=EmployeePay::where('order_id',$request->slug)->first();
            if($data){
                $type='empPayDetail';
                return view('employee/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='inv') {
            $po=PurchaseOrder::where('id',$_POST['slug'])->first();
            $data=Invoice::where('po_id',$po->id)->get();
            $type='viewDetail';
            if($data){
                return view('employee/report/ajax',compact('data','type','po'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='wdinv') {
            $data=WithoutPoInvoice::where('order_id',$request->slug)->first();
            if($data){
                $type='viewWithoutPoDetail';
                return view('employee/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }

        if ($request->type=='po') {
            $data=PurchaseOrder::with('poImage')->where('order_id',$request->slug)->first();
            if($data){
                $type='viewPoDetail';
                return view('employee/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='bnkRtrn') {
            $data=InternalTransfer::where('order_id',$request->slug)->first();
            if($data){
                $type='getInternalTrnsDetail';
                return view('employee/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='bulkUp') {
            $data=BulkUpload::where('order_id',$request->slug)->first();
            if($data){
                $type='BulkUploadDetail';
                return view('employee/report/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
    }

    public function employeeAllRequestExport(Request $request) 
    {
        $request->validate(['request_type'=>'required|in:empPay,inv,wdinv,bnkRtrn,bulkUp']);
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if ($roleId==10 || $roleId==11) {
            $request_type=$request->request_type;
            $from=$request->from ?? '';
            $to=$request->to ?? date('Y-m-d');
            return Excel::download(new EmployeeAllRequestExport($request_type,$from,$to), 'request-data-'.date('d-m-y').'.xlsx');
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function paymentOfficeApproval(Request $request)
    {
        $request->validate(['type'=>'required|in:empPay,inv,wdinv,bnkRtrn,bulkUp','data_request_file'=>'required|mimes:csv,xlsx,xls,docx|max:2048']);
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if ($roleId==10) {
            if ($request->type=='empPay') {
                $file = new PaymentOfcEmpAppImport();
                $file->import(request()->file('data_request_file'));
                foreach ($file->failures() as $failure) {
                        $failure->row(); 
                        $failure->attribute(); 
                        $failure->errors(); 
                        $failure->values();
                        if($failure->errors() && !empty($failure->errors())) {
                            return redirect()->back()->with('success', 'Data approved Successfully')->with('sheeterror', $failure);
                        }
                    }
                return redirect()->back()->with('success', 'Data imported Successfully');
            }
            if ($request->type=='inv') {
                $file = new PaymentOfcInvAppvImport();
                $file->import(request()->file('data_request_file'));
                foreach ($file->failures() as $failure) {
                        $failure->row(); 
                        $failure->attribute(); 
                        $failure->errors(); 
                        $failure->values();
                        if($failure->errors() && !empty($failure->errors())) {
                            return redirect()->back()->with('success', 'Data approved Successfully')->with('sheeterror', $failure);
                        }
                    }
                return redirect()->back()->with('success', 'Data imported Successfully');
            }
            if ($request->type=='wdinv') {
                $file = new PaymentOfcWidInvAppvImport();
                $file->import(request()->file('data_request_file'));
                foreach ($file->failures() as $failure) {
                        $failure->row(); 
                        $failure->attribute(); 
                        $failure->errors(); 
                        $failure->values();
                        if($failure->errors() && !empty($failure->errors())) {
                            return redirect()->back()->with('success', 'Data approved Successfully')->with('sheeterror', $failure);
                        }
                    }
                return redirect()->back()->with('success', 'Data imported Successfully');
            }
            if ($request->type=='bnkRtrn') {
                $file = new PaymentOfcIntrTransfAppvImport();
                $file->import(request()->file('data_request_file'));
                foreach ($file->failures() as $failure) {
                        $failure->row(); 
                        $failure->attribute(); 
                        $failure->errors(); 
                        $failure->values();
                        if($failure->errors() && !empty($failure->errors())) {
                            return redirect()->back()->with('success', 'Data approved Successfully')->with('sheeterror', $failure);
                        }
                    }
                return redirect()->back()->with('success', 'Data imported Successfully');
            }
            if ($request->type=='bulkUp') {
                $file = new PaymentOfcBulkUploadAppvImport();
                $file->import(request()->file('data_request_file'));
                foreach ($file->failures() as $failure) {
                        $failure->row(); 
                        $failure->attribute(); 
                        $failure->errors(); 
                        $failure->values();
                        if($failure->errors() && !empty($failure->errors())) {
                            return redirect()->back()->with('success', 'Data approved Successfully')->with('sheeterror', $failure);
                        }
                    }
                return redirect()->back()->with('success', 'Data imported Successfully');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function getBankCommonDetail(Request $request)
    {
        if ($request->accNo) {
            return \App\BankAccount::where('bank_account_number',$request->accNo)->first();
        }
    }
}
