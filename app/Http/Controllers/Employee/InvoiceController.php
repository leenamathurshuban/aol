<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\InvoiceRequest;
use App\Helpers\Helper;
use App\Invoice;
use App\Vendor;
use App\Employee;
use App\PurchaseOrder;
use App\Setting;
use Auth;
use Mail;
use PDF;
use App\Apex;
class InvoiceController extends Controller
{ 
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->time = time().rand(111111,999999); 
        $this->path='invoice/';
        $this->date=Helper::importDateInFormat();
    }
     
    public function index($po_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5 || $roleId==9 || $roleId==7 || $roleId==10 || $roleId==11)) {
            extract($_GET);
            $data=Invoice::where('invoice_status',6)->orderBy('id','DESC');
            if( $roleId==11){
                 $data->where('tds_amount', '>', 0);
            }
            if(isset($po_number) && !empty($po_number)){
                $po=PurchaseOrder::where('order_id',$po_number)->first()->id ?? '';
                 $data->where('po_id', $po)->orWhere('invoice_number',$po_number);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            
            $total=$data->count();
            $data=$data->paginate($this->paginate);
        	$page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
           if ($roleId==4) {
               return view('employee/Invoice/list',compact('data','po_number','page','total','currentPage'));
           }else{
                 return view('employee/Invoice/ListForApprover',compact('data','po_number','page','total','currentPage'));
           }
        	
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }

    }

    public function pendingInvoice($po_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5 || $roleId==9 || $roleId==7 || $roleId==10 || $roleId==11)) {
            extract($_GET);
            $data=Invoice::orderBy('id','DESC');
            if ($roleId==5) {
                $aplst=[$empId];
                $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                foreach ($emplst as $emplstkey => $emplstvalue) {
                    $aplst[]=$emplstvalue->id;
                }
                $data->whereIn('employee_id',$aplst);
            }
            if(isset($po_number) && !empty($po_number)){
                $po=PurchaseOrder::where('order_id',$po_number)->first()->id ?? '';
                 $data->where('po_id', $po)->orWhere('invoice_number',$po_number);
            }
             if ($roleId==4) {
                 $data->where('employee_id',$empId);
             }
            $data->whereNotIn('invoice_status', [2,6]);
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/Invoice/pendingInvoice',compact('data','po_number','page','total','currentPage'));
           
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }

    }

    public function add($value='')
    {
        $vendors = Vendor::approvedVendor();
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
        	return view('employee/Invoice/add',compact('vendors','apexes'));
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function edit($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $vendors = Vendor::approvedVendor();
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            $po=PurchaseOrder::where('order_id',$slug)->first();
            if ($roleId==5) {
                $data=Invoice::where(['po_id'=>$po->id,'employee_id'=>$empId])->whereIn('invoice_status',[3,2]);
            }else{
                $data=Invoice::where(['po_id'=>$po->id,'employee_id'=>$empId])->whereIn('invoice_status',[1]);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                return view('employee/Invoice/edit',compact('data','page','vendors','po','apexes'));
            }else{
               return redirect()->route('employee.invoices')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
           
    }

    public function insert(InvoiceRequest $request,$slug=null)
    {   
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            $purOrder = PurchaseOrder::where(['order_id'=>$request->po_number,'account_status'=>'4'])->select('id','order_id','po_start_date','po_end_date', 'item_detail', 'total', 'discount', 'net_payable', 'advance_tds', 'user_id', 'user_ary', 'account_status', 'level2_user_id', 'approved_user_id' )->first();

            $invc=\App\Invoice::where(['po_id'=>$purOrder->id])->where('invoice_status','!=','2')->sum('invoice_amount');
            $totInvAmt = $invc+($request->invoice_amount);
            if ($totInvAmt > \App\Invoice::invoiceLimit($purOrder->net_payable)) {
              return redirect()->back()->with('failed', 'Your PO Balance amount is '.($purOrder->net_payable-$invc).' , invoice amount cannot be more than this, please check.');
                 
            }
            $path = $this->path;
            $time = $this->time;
            if ($request->image) {
                        $data=new Invoice;
                        $data->vendor_id=$request->vendor;
                        $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                        $data->po_id=$purOrder->id;
                        $data->po_ary=json_encode($purOrder);
                        $data->employee_id=Auth::guard('employee')->user()->id;
                        $data->employee_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                        $data->invoice_status='1';
                        $imgName=($time.$data->id).'.'.$request->image->extension();
                        $data->invoice_date  = $request->invoice_date;
                        $data->invoice_number  = $request->invoice_number;
                        $data->advance_payment_mode  = $request->advance_payment_mode;

                        $data->amount  = $request->amount;
                        $data->tax  = $request->tax;
                        $tax_amount=($request->amount*$request->tax)/100;
                        $data->tax_amount  = $tax_amount;
                        $data->invoice_amount  = $request->amount+$tax_amount;

                        $data->invoice_file_path = $path.$imgName;
                        $data->po_file_type = $request->image->extension();
                        if ($roleId==5) {
                            $data->invoice_status=3;
                            $data->approver_manager=Auth::guard('employee')->user()->id;
                            $data->manager_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                            $data->manager_date = $this->date;
                        }
                        $data->apexe_id = $request->apex;
                        $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
                        if ($data->save()) {
                            $data->order_id=Helper::invoiceUniqueNo($data->id);
                            $data->save();
                            $request->image->move(public_path($path),$imgName);
                            return redirect()->route('employee.pendingInvoice')->with('success', 'Saved successfully !');
                        }else{
                            return redirect()->back()->with('error', 'Failed ! try again.');
                        }
            }else{
                return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
                }
        	
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function update(InvoiceRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4)) {
            $path = $this->path;
            $time = $this->time;
            $data=Invoice::where('invoice_number',$slug)->whereIn('invoice_status',[1]);
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            } 
            $data=$data->first();
            if ($data) {
                $data->vendor_id=$request->vendor;
                $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                $data->po_start_date=$request->po_start_date;
                $data->po_end_date=$request->po_end_date;
                $data->payment_method=$request->payment_method;
                $data->nature_of_service=$request->nature_of_service;
                $data->service_detail=$request->service_detail;
                if ($roleId=='5') {
                    $data->advance_tds=$request->advance_tds;
                    $data->level2_user_id=Auth::guard('employee')->user()->id;
                    $data->level2_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                }
                $data->user_id=Auth::guard('employee')->user()->id;
                $data->user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                $itemDetail =[];
                $grandTotal=0;
                if ($request->quantity) {
                    foreach ($request->quantity as $qkey => $qvalue) {
                        if ($qvalue > 0) {
                            $total = $qvalue*$request->rate[$qkey];
                            $itemDetail[]=['item_name'=>$request->item_name[$qkey],'quantity'=>$qvalue,'unit'=>$request->unit[$qkey],'rate'=>$request->rate[$qkey],'total'=>$total,'price_unit'=>$request->price_unit[$qkey]];
                            $grandTotal=$grandTotal+$total;
                        }
                    }
                }
                $data->item_detail=json_encode($itemDetail);
                $data->total=$grandTotal ?? 0;
                $data->discount=$request->discount ?? 0;
                $data->net_payable=$grandTotal-$request->discount ?? 0;
                $data->apexe_id = $request->apex;
                $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
                if($data->save()){
                    if ($request->po_file) {
                        foreach ($request->po_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $poImg=new PurchaseOrderFile;
                                $poImg->po_id = $data->id;
                                $poImg->po_file_path = $path.$imgName;
                                $poImg->po_file_type = $img->extension();
                                $poImg->po_file_description = $request->po_file_description[$key];
                                if ($poImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                    return redirect()->route('employee.invoices')->with('success', 'Saved successfully !');
                }else{
                    return redirect()->route('employee.invoices')->with('error', 'Failed ! try again.');
                }
            }else{
                return redirect()->route('employee.invoices')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            
            if ($roleId==5) {
                $data=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[3,2]);
            }else{
                $data=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[1,2]);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            $path = $this->path;
            if($data){
                $id=$data->id;
                if ($data->invoice_file_path) {
                    $pre_img=public_path($data->invoice_file_path);
                      if(file_exists($pre_img) && $data->invoice_file_path){
                            unlink($pre_img);
                        }
                }
                $data->delete();
                return redirect()->back()->with('success', 'Removed successfully !');
            }else{
               return redirect()->back()->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }


    public function getInvoiceDetail(Request $request)
    {
        if ($request->type=='viewDetail') {
            $po=PurchaseOrder::where('order_id',$request->slug)->first();
            $data=Invoice::where('po_id',$po->id)->get();
            if($data){
                $type=$request->type;
                return view('employee/Invoice/ajax',compact('data','type','po'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
        if ($request->type=='InvoiceDetail') {
            $data=Invoice::where('order_id',$request->slug)->first();
            $po=PurchaseOrder::where('id',$data->po_id)->first();
            if($data){
                $type=$request->type;
                return view('employee/Invoice/ajax',compact('data','type','po'));
            }else{
               return '<h2>Data not found.</h2>';
            }

        }
    }

    public function invoiceStatusApprove($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==5 || $roleId==9 || $roleId==7 || $roleId==10)) {
            $data=Invoice::where('order_id',$slug);
            $data->whereNotIn('invoice_status', [2,6]);
           
             $data=$data->first();
             $po=PurchaseOrder::where('id',$data->po_id)->first();
            if($po && $data){
                return view('employee/Invoice/invoiceApproval',compact('data','page','po'));
            }else{
               return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function changeInvoiceStatus(Request $request,$slug=null,$page=null)
    {
        if (Auth::guard('employee')->user()->role_id==5) {
            $request->validate(['invoice_status'=>'required|in:2,3']);
        }
        if (Auth::guard('employee')->user()->role_id==9) {
            $request->validate(['invoice_status'=>'required|in:2,4','specified_person.*'=>'required|in:Yes,No']);
        }
        if (Auth::guard('employee')->user()->role_id==7) {
            $request->validate(['invoice_status'=>'required|in:2,5']);
        }
        if (Auth::guard('employee')->user()->role_id==10) {
            $request->validate(['invoice_status'=>'required|in:2,6']);
        }
        if (Auth::guard('employee')->user()->role_id==11) {
            $request->validate(['invoice_status'=>'required|in:2,7']);
        }
        //$request->validate(['invoice_status'=>'required|in:2,3']);
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==5 || $roleId==9 || $roleId==7 || $roleId==10)) {

            $data=Invoice::where('order_id',$slug)->whereNotIn('invoice_status', [2,6])->first();
            $po=PurchaseOrder::where('id',$data->po_id)->where('account_status',4)->first();
            if ($po && $data) {
                        if ($roleId==5) {
                            $data->invoice_status=$request->invoice_status;
                            $data->approver_manager=Auth::guard('employee')->user()->id;
                            $data->manager_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                            $data->manager_comment=$request->invoice_status_comment;
                            $data->manager_date = $this->date;
                        }
                        if ($roleId==9) {
                            $data->invoice_status=$request->invoice_status;
                            $data->approver_financer=Auth::guard('employee')->user()->id;
                            $data->financer_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                            $data->financer_comment=$request->invoice_status_comment;
                            $data->financer_date = $this->date;
                            $data->specified_person=$request->specified_person;
                            $formAccount=[];
                            if ($request->debit_account) {
                                    foreach ($request->debit_account as $f_key => $f_value) {
                                         $formAccount[] = ['debit_account'=>$f_value,'amount'=>$request->amount[$f_key],'cost_center'=>$request->cost_center[$f_key],'category'=>$request->category[$f_key]];
                                    }
                                $data->form_by_account=json_encode(['form_by_account'=>$formAccount,'bank_account'=>$request->bank_account,'ifsc'=>$request->ifsc,'bank_name'=>$request->bank_name]);
                            }

                            $data->tds=$request->tds;
                            $b_amt=$data->amount;
                            $tds_amount=ceil($b_amt*$request->tds/100);
                            $data->tds_amount=($tds_amount);
                            $data->tds_payable=ceil($data->invoice_amount-$tds_amount);
                            $data->tds_month=$request->tds_month;

                            if ($data->invoice_amount!=array_sum($request->amount)) {
                                return redirect()->back()->with('failed','Invoice amount is ₹'.$data->invoice_amount.'. So debit account must be equal according to invoice amount. Your current debit account amount is ₹'.array_sum($request->amount));
                            }
                        }
                        if ($roleId==7) {
                            $data->invoice_status=$request->invoice_status;
                            $data->approver_trust=Auth::guard('employee')->user()->id;
                            $data->approver_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                            $data->trust_comment=$request->invoice_status_comment;
                            $data->trust_date = $this->date;
                        }
                        if ($roleId==10) {
                           $data->invoice_status=$request->invoice_status;
                           $data->payment_ofc_id = Auth::guard('employee')->user()->id;
                           $data->payment_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                           $data->payment_ofc_comment = $request->invoice_status_comment;
                           $data->payment_date=$this->date;
                        }
                        if ($roleId==11) {
                           $data->invoice_status=$request->invoice_status;
                           $data->tds_ofc_id = Auth::guard('employee')->user()->id;
                           $data->tds_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                           $data->tds_ofc_comment = $request->invoice_status_comment;
                           $data->tds_date=$this->date;
                           if ($value==7) {
                                $data->invoice_approval_date=date('Y-m-d h:i:s');
                            }
                        }
                        if ($data->save()) {
                           
                            return redirect()->route('employee.pendingInvoice')->with('success', 'Invoice request status changed successfully !');
                        }else{
                            return redirect()->back()->with('error', 'Failed ! try again.');
                        }
            }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
            }
        }else{
            return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
   
    public function editPendingInvoice($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $vendors = Vendor::approvedVendor();
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            $po=PurchaseOrder::where('order_id',$slug)->first();
            
            if ($roleId==5) {
                $data=Invoice::where(['po_id'=>$po->id,'employee_id'=>$empId])->whereIn('invoice_status',[3]);
            }else{
                $data=Invoice::where(['po_id'=>$po->id,'employee_id'=>$empId])->whereIn('invoice_status',[1]);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                return view('employee/Invoice/editPending',compact('data','page','vendors','po','apexes'));
            }else{
               return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function updatePendingInvoice(InvoiceRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
            $path = $this->path;
            $time = $this->time;
            $purOrder = PurchaseOrder::where(['order_id'=>$request->po_number,'account_status'=>'4'])->select('id','order_id','po_start_date','po_end_date', 'item_detail', 'total', 'discount', 'net_payable', 'advance_tds', 'user_id', 'user_ary', 'account_status', 'level2_user_id', 'approved_user_id' )->first();
            $invc=\App\Invoice::where(['po_id'=>$purOrder->id])->where('invoice_status','!=','2')->sum('invoice_amount');
            $arysum=0;
            if ($request->invoice_amount) {
                $arysum=array_sum($request->invoice_amount);
            }
            $totInvAmt = $invc+$arysum;
            if ($totInvAmt > \App\Invoice::invoiceLimit($purOrder->net_payable)) {
               
                return redirect()->back()->with('failed', 'Your PO Balance amount is '.($purOrder->net_payable-$invc).' , invoice amount cannot be more than this, please check.');
            }
            if ($purOrder) {
                if ($request->image) {
                    foreach ($request->image as $key => $img) {
                        if($img){
                             $data=new Invoice;
                            $data->vendor_id=$request->vendor;
                            $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                            $data->po_id=$purOrder->id;
                            $data->po_ary=json_encode($purOrder);
                            $data->employee_id=Auth::guard('employee')->user()->id;
                            $data->employee_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                            $data->invoice_status='1';
                            $imgName=($time.$key.$data->id).'.'.$img->extension();
                            $data->invoice_date  = $request->invoice_date[$key];
                             $data->advance_payment_mode  = $request->advance_payment_mode[$key];

                            $data->amount  = $request->amount[$key];
                            $data->tax  = $request->tax[$key];
                            $tax_amount=($request->amount[$key]*$request->tax[$key])/100;
                            $data->tax_amount  = $tax_amount;
                            $data->invoice_amount  = $request->amount[$key]+$tax_amount;
                            $data->invoice_number  = $request->invoice_number[$key];
                            $data->invoice_file_path = $path.$imgName;
                            $data->po_file_type = $img->extension();
                            if ($roleId==5) {
                                $data->invoice_status=3;
                                $data->approver_manager=Auth::guard('employee')->user()->id;
                                $data->manager_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                                $data->manager_date = $this->date;
                            }
                            $data->apexe_id = $request->apex;
                            $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
                            if ($data->save()) {
                                 $data->order_id=Helper::invoiceUniqueNo($data->id);
                                $data->save();
                                $img->move(public_path($path),$imgName);
                            }
                        }
                    }
                    return redirect()->route('employee.pendingInvoice')->with('success', 'Saved successfully !');
                }else{
                    return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
                    }
            }else{
                return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function vendorAjaxResponse(Request $request)
    {
        $data = PurchaseOrder::where(['vendor_id'=>$request->vId,'account_status'=>'4','user_id'=>Auth::guard('employee')->user()->id])->pluck('order_id','order_id');
        if($data){
            $type='vendorOrderList';
            return view('employee/Invoice/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function InvoicePOAjaxResponse(Request $request)
    {
        $data = PurchaseOrder::where('order_id',$request->order_id)->first();
        if($data){
            $type='poDetail';
            $data=$data;
            return view('employee/Invoice/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function editPendingEditInvoice($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $vendors = Vendor::approvedVendor();
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            if ($roleId==5) {
                $indata=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[3]);
            }else{
                $indata=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[1]);
            }
            if ($roleId==4 || $roleId==5) {
                 $indata->where('employee_id', $empId);
            }
            $indata=$indata->first();
            
            if($indata){
                $po=PurchaseOrder::where('id',$indata->po_id)->first();
                return view('employee/Invoice/editInvoicePending',compact('indata','page','vendors','po','apexes'));
            }else{
               return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function updatePendingUpdateInvoice(InvoiceRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
            $path = $this->path;
            $time = $this->time;
            $purOrder = PurchaseOrder::where(['order_id'=>$request->po_number,'account_status'=>'4'])->select('id','order_id','po_start_date','po_end_date', 'item_detail', 'total', 'discount', 'net_payable', 'advance_tds', 'user_id', 'user_ary', 'account_status', 'level2_user_id', 'approved_user_id' )->first();
            $invc=\App\Invoice::where(['po_id'=>$purOrder->id])->where('id','!=',$slug)->where('invoice_status','!=','2')->sum('invoice_amount');
            $totInvAmt = $invc+$request->invoice_amount;
            if ($totInvAmt > \App\Invoice::invoiceLimit($purOrder->net_payable)) {
                return redirect()->back()->with('failed', 'Failed ! PO amount is '.$purOrder->net_payable.'. So invoices amount must be equal or less than '.$purOrder->net_payable.'. Your all pending or new invoices amount is '.$totInvAmt);
            }
            if ($purOrder) {
                if ($roleId==5) {
                    $data=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[3]);
                }else{
                    $data=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[1]);
                }
                if ($roleId==4 || $roleId==5) {
                     $data->where('employee_id', $empId);
                }
                $data=$data->first();

                        if($data){
                            $img=$request->image;
                            
                            if ($data) {
                               $data->vendor_id=$request->vendor;
                                $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                                $data->po_id=$purOrder->id;
                                $data->po_ary=json_encode($purOrder);
                                $data->employee_id=Auth::guard('employee')->user()->id;
                                $data->employee_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                                $data->invoice_status='1';
                                
                                $data->invoice_date  = $request->invoice_date;

                                $data->advance_payment_mode  = $request->advance_payment_mode;
                                $data->amount  = $request->amount;
                                $data->tax  = $request->tax;
                                $tax_amount=($request->amount*$request->tax)/100;
                                $data->tax_amount  = $tax_amount;
                                $data->invoice_amount  = $request->amount+$tax_amount;

                                $data->invoice_number  = $request->invoice_number;
                                if ($img) {
                                    $imgName=($time.$key.$data->id).'.'.$img->extension();
                                    $data->invoice_file_path = $path.$imgName;
                                    $data->po_file_type = $img->extension();
                                }
                                if ($roleId==5) {
                                    $data->invoice_status=3;
                                    $data->approver_manager=Auth::guard('employee')->user()->id;
                                    $data->manager_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                                    $data->manager_date = $this->date;
                                }
                                $data->apexe_id = $request->apex;
                                $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
                                if ($data->save()) {
                                    if ($img) {
                                        $img->move(public_path($path),$imgName);
                                    }
                                }
                            }
                        }
                    return redirect()->route('employee.pendingInvoice')->with('success', 'Saved successfully !');
               
            }else{
                return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function addItemView($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $vendors = Vendor::approvedVendor();
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            
            if ($roleId==5) {
                    $indata=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[3,2]);
                }else{
                    $indata=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[1,2]);
                }
                if ($roleId==4 || $roleId==5) {
                     $indata->where('employee_id', $empId);
                }
                $indata=$indata->first();
            if($indata){
                $po=PurchaseOrder::where('id',$indata->po_id)->first();
                return view('employee/Invoice/addItemView',compact('indata','page','vendors','po'));
            }else{
               return redirect()->route('employee.pendingInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function saveItemDetail(Request $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
            $path = $this->path;
            $time = $this->time;
              if ($roleId==5) {
                    $data=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[3]);
                }else{
                    $data=Invoice::where(['order_id'=>$slug,'employee_id'=>$empId])->whereIn('invoice_status',[1]);
                } 
                if ($roleId==4 || $roleId==5) {
                     $data->where('employee_id', $empId);
                }
                $data=$data->first();             
                if ($data) {
                        $itemDetail =[];
                        $grandTotal=0;
                        if ($request->quantity) {
                            foreach ($request->quantity as $qkey => $qvalue) {
                                if ($qvalue > 0) {
                                    $total = $qvalue*$request->rate[$qkey];
                                    $tax=($total*$request->tax[$qkey])/100;
                                    $total=$total+$tax;
                                    $itemDetail[]=['item_name'=>$request->item_name[$qkey],'quantity'=>$qvalue,'unit'=>$request->unit[$qkey],'rate'=>$request->rate[$qkey],'total'=>$total,'price_unit'=>$request->price_unit[$qkey],'tax'=>$request->tax[$qkey],'tax_amt'=>$tax];
                                    $grandTotal=$grandTotal+$total;
                                }
                            }
                        }
                        $data->item_detail=json_encode($itemDetail);
                        if ($data->invoice_amount < $grandTotal) {
                            return redirect()->back()->with('failed', 'Failed ! Item amount should be equal or less than invoice amount.');
                        }
                        if ($data->save()) {
                                return redirect()->route('employee.pendingInvoice')->with('success', 'Item added successfully !');
                        }else{
                            return redirect()->back()->with('failed', 'Failed ! try again.');
                        }     
                                
                }else{
                    return redirect()->back()->with('failed', 'Wrong input ! try again.');
                }

        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function PoInvoicePDF($value='')
    {
        $po=PurchaseOrder::where('order_id',$value)->first();
        $data['po']=$po;
        $data['data']=Invoice::where('po_id',$po->id)->get();
        if ($data) {
            $pdf = PDF::loadView('employee/Invoice/invoicePDF', $data);
            return $pdf->download('po-invoice-'.date('d-m-Y').'.pdf');
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }

    public function getInvoiceItemRow(Request $request)
    {
        if($request->dataId){
            $type='getInvoiceItemRow';
            $dataId=$request->dataId;
            $cls=$request->cls;
            return view('employee/Invoice/ajax',compact('dataId','type','cls'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }
    
}
