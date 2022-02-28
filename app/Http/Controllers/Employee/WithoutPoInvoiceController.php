<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\WithoutPoInvoiceRequest;
use App\Helpers\Helper;
use App\WithoutPoInvoice;
use App\Vendor;
use App\Employee;
use App\PurchaseOrder;
use App\Setting;
use Auth;
use Mail;
use PDF;
use App\Apex;
class WithoutPoInvoiceController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->time = time().rand(111111,999999); 
        $this->path='WithoutPoInvoice/';
        $this->date=Helper::importDateInFormat();
    } 
     
    public function index($search='',$date=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5 || $roleId==9 || $roleId==7 || $roleId==10 || $roleId==11)) {
            extract($_GET);
            $data=WithoutPoInvoice::where('invoice_status',6)->orderBy('id','DESC');
            if(isset($search) && !empty($search)){
                $po=Vendor::where(['account_status'=>'3','status'=>'1'])->where('vendor_code',$search)->orWhere('name',$search)->first()->id ?? '';
                $data->where('vendor_id', $po)->orWhere('invoice_number',$search);
            }
            if(isset($date) && !empty($date)){
                $data->where('invoice_date', $date);
            }
            if( $roleId==11){
                 $data->where('tds_amount', '>', 0);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $total=$data->count();
            $data=$data->paginate($this->paginate);
        	$page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
           if ($roleId==4) {
               return view('employee/WithoutPoInvoice/list',compact('data','search','page','total','currentPage','date'));
           }else{
                 return view('employee/WithoutPoInvoice/ListForApprover',compact('data','search','page','total','currentPage','date'));
           }
        	
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }

    }

    public function pendingInvoice($search='',$date=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5 || $roleId==9 || $roleId==7 || $roleId==10 || $roleId==11)) {
            extract($_GET);
            $data=WithoutPoInvoice::orderBy('id','DESC');
            if ($roleId==5) {
                $aplst=[$empId];
                $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                foreach ($emplst as $emplstkey => $emplstvalue) {
                    $aplst[]=$emplstvalue->id;
                }
                $data->whereIn('employee_id',$aplst);
            }
            if(isset($search) && !empty($search)){
                $po=Vendor::where(['account_status'=>'3','status'=>'1'])->where('vendor_code',$search)->orWhere('name',$search)->first()->id ?? '';
                $data->where('vendor_id', $po)->orWhere('invoice_number',$search);
            }
            if(isset($date) && !empty($date)){
                $data->where('invoice_date', $date);
            }
             if ($roleId==4) {
                 $data->where('employee_id',$empId);
             }
             
            $data->whereNotIn('invoice_status', [2,6]);
           
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/WithoutPoInvoice/pendingInvoice',compact('data','search','page','total','currentPage','date'));
           
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
        if (\App\Employee::chkProccess($empId,3) && ($roleId==5 || $roleId==4)) {
        	return view('employee/WithoutPoInvoice/add',compact('vendors','apexes'));
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function insert(WithoutPoInvoiceRequest $request,$slug=null)
    {   
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
           
            $path = $this->path;
            $time = $this->time;
            if ($request->image) {
                foreach ($request->image as $key => $img) {
                    if($img){
                        $data=new WithoutPoInvoice;
                        $data->vendor_id=$request->vendor;
                        $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                        $data->employee_id=Auth::guard('employee')->user()->id;
                        $data->employee_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                        $data->invoice_status='1';
                        $imgName=($time.$key.$data->id).'.'.$img->extension();
                        $data->invoice_date  = $request->invoice_date[$key];
                        $data->amount  = $request->amount[$key];
                        $data->tax  = $request->tax[$key];
                        $tax_amount=($request->amount[$key]*$request->tax[$key])/100;
                        $data->tax_amount  = $tax_amount;
                        $data->invoice_amount  = $request->amount[$key]+$tax_amount;
                        //$data->invoice_amount  = $request->invoice_amount[$key];
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
                            $data->order_id=Helper::withoutpoInvoiceUniqueNo($data->id);
                            $data->save();
                            $img->move(public_path($path),$imgName);
                        }
                    }
                }
                return redirect()->route('employee.pendingWithoutPoInvoice')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('employee.pendingWithoutPoInvoice')->with('error', 'Failed ! try again.');
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
                $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[3]);
            }else{
                $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[1]);
            }
            $path = $this->path;
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
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
        $data=WithoutPoInvoice::where('order_id',$request->slug)->first();
        if($data){
            $type='viewDetail';
            return view('employee/WithoutPoInvoice/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function invoiceStatusApprove($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==5 || $roleId==9 || $roleId==7 || $roleId==10)) {
            $data=WithoutPoInvoice::where('order_id',$slug)->whereNotIn('invoice_status', [2,6]);

            if ($roleId==5) {
                 $data->where('invoice_status', '1');
             }
             if ($roleId==9) {
                 $data->where('invoice_status', '3');
             }
             if ($roleId==7) {
                 $data->where('invoice_status', '4');
             }
             if ($roleId==10) {
                 $data->where('invoice_status', '5');
             }
             if ($roleId==11) {
                 $data->where('invoice_status', '6');
             }

            $data=$data->first();
            if ($data) {
                return view('employee/WithoutPoInvoice/invoiceApproval',compact('data','page'));
            }else{
               return redirect()->route('employee.pendingWithoutPoInvoice')->with('error', 'Failed ! try again.');
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
            $request->validate(['invoice_status'=>'required|in:2,4','specified_person'=>'required|in:Yes,No']);
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
                   $data = WithoutPoInvoice::where('order_id',$slug)->whereNotIn('invoice_status', [2,6]);

                    if ($roleId==5) {
                         $data->where('invoice_status', '1');
                     }
                     if ($roleId==9) {
                         $data->where('invoice_status', '3');
                     }
                     if ($roleId==7) {
                         $data->where('invoice_status', '4');
                     }
                     if ($roleId==10) {
                         $data->where('invoice_status', '5');
                     }
                     if ($roleId==11) {
                         $data->where('invoice_status', '6');
                     }

                    $data=$data->first();
                    if ($data) {
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
                                 $data->form_by_account=json_encode(['form_by_account'=>$formAccount,'bank_account'=>$request->bank_account[$data->id],'ifsc'=>$request->ifsc[$data->id],'bank_name'=>$request->bank_name[$data->id]]);
                            }

                            $b_amt=$data->amount;
                            $data->tds=$request->tds;
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
                           if ($request->invoice_status==7) {
                                $data->invoice_approval_date=date('Y-m-d h:i:s');
                            }
                        }
                         $data->save();
                        return redirect()->route('employee.pendingWithoutPoInvoice')->with('success', 'Invoice request status changed successfully !');
                    }else{
                       return redirect()->back()->with('failed', 'Failed ! Wrong request try again.');
                    }
                    
        }else{
            return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
   
    public function editPendingInvoice($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $vendors = Vendor::approvedVendor();
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            if ($roleId==4) {
                $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[1]);
            }
            if ($roleId==5) {
                $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[3]);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                return view('employee/WithoutPoInvoice/editPending',compact('data','page','vendors','apexes'));
            }else{
               return redirect()->route('employee.pendingWithoutPoInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function updatePendingInvoice(WithoutPoInvoiceRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
            $path = $this->path;
            $time = $this->time;
            
            if ($purOrder) {
                if ($request->image) {
                    foreach ($request->image as $key => $img) {
                        if($img){
                             $data=new Invoice;
                            $data->vendor_id=$request->vendor;
                            $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                            $data->employee_id=Auth::guard('employee')->user()->id;
                            $data->employee_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                            $data->invoice_status='1';
                            $imgName=($time.$key.$data->id).'.'.$img->extension();
                            $data->invoice_date  = $request->invoice_date[$key];
                            $data->invoice_amount  = $request->invoice_amount[$key];
                            $data->invoice_number  = $request->invoice_number[$key];
                            $data->invoice_file_path = $path.$imgName;
                            $data->po_file_type = $img->extension();
                            $data->apexe_id = $request->apex;
                            $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
                            if ($data->save()) {
                                $data->order_id=Helper::withoutpoInvoiceUniqueNo($data->id);
                                $data->save();
                                $img->move(public_path($path),$imgName);
                            }
                        }
                    }
                    return redirect()->route('employee.pendingWithoutPoInvoice')->with('success', 'Saved successfully !');
                }else{
                    return redirect()->route('employee.pendingWithoutPoInvoice')->with('error', 'Failed ! try again.');
                    }
            }else{
                return redirect()->route('employee.pendingWithoutPoInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
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
                $indata=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[3]);
            }else{
              $indata=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[1]);  
            }
            if ($roleId==4 || $roleId==5) {
                 $indata->where('employee_id', $empId);
            }
            $indata=$indata->first();
            
            if($indata){
                return view('employee/WithoutPoInvoice/editInvoicePending',compact('indata','page','vendors','apexes'));
            }else{
               return redirect()->route('employee.pendingWithoutPoInvoice')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function updatePendingUpdateInvoice(WithoutPoInvoiceRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
            $path = $this->path;
            $time = $this->time;
            if ($roleId==5) {
                $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[3]);
            }else{
              $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[1]);  
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
               $img=$request->image;
                            
                 if ($data) {
                               $data->vendor_id=$request->vendor;
                                $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                                $data->employee_id=Auth::guard('employee')->user()->id;
                                $data->employee_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                                $data->invoice_status='1';
                                $data->invoice_date  = $request->invoice_date;
                                
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
                    return redirect()->route('employee.pendingWithoutPoInvoice')->with('success', 'Saved successfully !');
               
            
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function vendorAjaxResponse(Request $request)
    {
        $vendor = Vendor::approvedVendor($request->vId);
        if ($vendor) {
           return json_encode($vendor);
        }else{
            return '';
        }
    }
    
    public function addItemView($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $vendors = Vendor::approvedVendor();
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            
            if ($roleId==5) {
                $indata=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[3]);
            }else{
              $indata=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[1]);  
            }
            if ($roleId==4 || $roleId==5) {
                 $indata->where('employee_id', $empId);
            }
            $indata=$indata->first();
            if($indata){
                return view('employee/WithoutPoInvoice/addItemView',compact('indata','page','vendors'));
            }else{
               return redirect()->route('employee.pendingWithoutPoInvoice')->with('error', 'Failed ! try again.');
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
                $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[3]);
            }else{
              $data=WithoutPoInvoice::where(['order_id' => $slug, 'employee_id' => $empId])->whereIn('invoice_status',[1]);  
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
                            return redirect()->route('employee.pendingWithoutPoInvoice')->with('success', 'Item added successfully !');
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

    public function withoutPOInvoicePDF($value='')
    {
        $data['data']=WithoutPoInvoice::where('order_id',$value)->first();
        if ($data) {
            $pdf = PDF::loadView('employee/WithoutPoInvoice/invoicePDF', $data);
            return $pdf->download('without-invoice-'.date('d-m-Y').'.pdf');
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }
}
