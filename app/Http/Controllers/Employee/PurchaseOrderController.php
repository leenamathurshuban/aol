<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\PurchaseOrderRequest;
use App\Helpers\Helper;
use App\User;
use App\Vendor;
use App\Employee;
use App\PurchaseOrder;
use Auth;
use App\Setting;
use App\Mail\PoStatusVendorMail;
use Mail;
use App\PurchaseOrderFile;
use PDF;
use App\Apex;
use App\Invoice;
class PurchaseOrderController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->time = time().rand(111111,999999);
        $this->path='po_file/';
        $this->date=Helper::importDateInFormat();
    }
     
    public function index($po_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5 || $roleId==7)) {
            extract($_GET);
            $data=PurchaseOrder::where('account_status','4')->orderBy('id','DESC');
            if(isset($po_number) && !empty($po_number)){
                 $data->where('order_id', $po_number);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('user_id', $empId);
             }
            
            $total=$data->count();
            $data=$data->paginate($this->paginate);
        	$page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
           if ($roleId==4) {
               return view('employee/PurchaseOrder/list',compact('data','po_number','page','total','currentPage'));
           }else{
                 return view('employee/PurchaseOrder/ListForApprover',compact('data','po_number','page','total','currentPage'));
           }
        	
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }

    }

    public function pendingPO($po_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5 || $roleId==7)) {
            extract($_GET);
            $data=PurchaseOrder::orderBy('id','DESC');
            if ($roleId==5) {
                $aplst=[$empId];
                $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                foreach ($emplst as $emplstkey => $emplstvalue) {
                    $aplst[]=$emplstvalue->id;
                }
                $data->whereIn('user_id',$aplst);
            }
            if(isset($po_number) && !empty($po_number)){
                 $data->where('order_id', $po_number);
            }
             
             if ($roleId==4) {
                 $data->where('user_id',$empId);
             }
                $data->whereNotIn('account_status', [2,4]);

            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/PurchaseOrder/pendingPO',compact('data','po_number','page','total','currentPage'));
           
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }

    }

    public function add($value='')
    {
        $ordNo = Helper::poUniqueNo((PurchaseOrder::get()->last()->id ?? '0')+1);
        $vendors = Vendor::approvedVendor();
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
        	return view('employee/PurchaseOrder/add',compact('vendors','ordNo','apexes'));
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
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5 || $roleId==7)) {
        	$data=PurchaseOrder::with('poImage')->where('account_status','!=','4')->where('order_id',$slug)->first();

            //dd($data);
            if($data){
                return view('employee/PurchaseOrder/edit',compact('data','page','vendors','apexes'));
            }else{
               return redirect()->route('employee.POs')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function insert(PurchaseOrderRequest $request,$slug=null)
    {   
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            
            $path = $this->path;
            $time = $this->time;

        	$data=new PurchaseOrder;
            $data->vendor_id=$request->vendor;
            $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
            $data->po_start_date=$request->po_start_date;
            $data->po_end_date=$request->po_end_date;
            $data->payment_method=$request->payment_method;
            $data->nature_of_service=$request->nature_of_service;
            $data->service_detail=$request->service_detail;
            //$data->advance_tds=$request->advance_tds;
            $data->po_description=$request->po_description;
            $data->user_id=Auth::guard('employee')->user()->id;
            $data->user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
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
            $data->total=$grandTotal ?? 0;
            $data->discount=$request->discount ?? 0;
            $data->net_payable=$grandTotal-$request->discount ?? 0;
            if ($roleId==5) {
                $data->advance_tds=$request->advance_tds;
                $data->account_status=3;
                $data->level2_user_id=Auth::guard('employee')->user()->id;
                $data->level2_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                $data->level_two_date = $this->date;
            }
            $data->apexe_id = $request->apex;
            $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
        	if($data->save()){
                $data->order_id=Helper::poUniqueNo($data->id);
                $data->save();
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
        		return redirect()->route('employee.pendingPO')->with('success', 'Saved successfully !');
        	}else{
        		return redirect()->route('employee.pendingPO')->with('error', 'Failed ! try again.');
        	}
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function update(PurchaseOrderRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==7)) {
            $path = $this->path;
            $time = $this->time;
            $data=PurchaseOrder::where('order_id',$slug)->whereNotIn('account_status', [2,4])->first();
            if ($data) {
                $data->vendor_id=$request->vendor;
                $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                $data->po_start_date=$request->po_start_date;
                $data->po_end_date=$request->po_end_date;
                $data->payment_method=$request->payment_method;
                $data->nature_of_service=$request->nature_of_service;
                $data->service_detail=$request->service_detail;
                $data->po_description=$request->po_description;
                if ($roleId=='5') {
                    $data->advance_tds=$request->advance_tds;
                    $data->level2_user_id=Auth::guard('employee')->user()->id;
                    $data->level2_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                    $data->level_two_date = $this->date;
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
                    return redirect()->route('employee.POs')->with('success', 'Saved successfully !');
                }else{
                    return redirect()->route('employee.POs')->with('error', 'Failed ! try again.');
                }
            }else{
                return redirect()->route('employee.POs')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
  
    public function statusChange(Request $request,$slug)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
        	$request->validate(['status'=>'required|numeric|in:1,2']);
            $data=PurchaseOrder::where('order_id',$slug)->first();
            if($data){
                $data->status=$request->status;
                $data->save();
                return redirect()->route('employee.POs')->with('success', 'Status changed successfully !');
            }else{
               return redirect()->route('employee.POs')->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4)) {
            $data=PurchaseOrder::with('poImage')->where('order_id',$slug)->where('account_status','!=',4)->first();
            $path = $this->path;
            if($data){
                $id=$data->id;
                if ($data->poImage) {
                   foreach ($data->poImage as $key => $ImgData) {
                    $pre_img=public_path($ImgData->po_file_path);
                      if(file_exists($pre_img) && $ImgData->po_file_path){
                            unlink($pre_img);
                        }  
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

    public function getPoDetail($value='')
    {
        $data=PurchaseOrder::with('poImage')->where('order_id',$_POST['slug'])->first();
        if($data){
            $type='viewDetail';
            return view('employee.PurchaseOrder.ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function changePoStatus(Request $request,$value)
    {
        if (Auth::guard('employee')->user()->role_id==5) {
            $request->validate(['account_status'=>'required|in:2,3']);
        }
        if (Auth::guard('employee')->user()->role_id==7) {
            $request->validate(['account_status'=>'required|in:2,4']);
        }
        //$request->validate(['account_status'=>'required|in:2,3']);
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==5 || $roleId==7)) {
            $vdata=PurchaseOrder::where('id',$value)->first();
            $message_title=$message_desc='';
            if ($roleId==5) {
                    $aplst=[];
                    $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                    foreach ($emplst as $emplstkey => $emplstvalue) {
                        $aplst[]=$emplstvalue->id;
                    }
                    $vdata->whereIn('user_id',$aplst);
                }
            if ($vdata) {
                $vdata->account_status=$request->account_status;
                if ($roleId==5) {
                    $vdata->level2_user_id=Auth::guard('employee')->user()->id;
                    $vdata->level2_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                    $vdata->account_status_level2_comment=$request->account_status_comment;
                    $message_title='Your Purchase order '.\App\PurchaseOrder::orderStatus($request->account_status).' .';
                    $data->level_two_date = $this->date;
                }
                if ($roleId==7) {
                    $vdata->approved_user_id=Auth::guard('employee')->user()->id;
                    $vdata->approved_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                    $vdata->account_status_level3_comment=$request->account_status_comment;
                    $message_title='Your Purchase order '.\App\PurchaseOrder::orderStatus($request->account_status).' .';
                    $data->level_three_date = $this->date;
                }
                if($vdata->save()){
                    /* mail start */
                        $data['logo'] = Setting::setting('dark_logo');
                        $data['title'] = Setting::setting('title');
                        $data['FromEmail'] = Setting::setting('email');
                        $data['fromAddress'] = Setting::setting('address');
                        $data['fromMobile'] = Setting::setting('mobile');
                        $data['message_title'] = $message_title;
                        $data['po_detail'] = $vdata;
                        Mail::to([json_decode($vdata->vendor_ary)->email,Setting::setting('email')])->send(new PoStatusVendorMail($data));
                    /* mail end */
                    return redirect()->back()->with('success', 'PO request status changed successfully !');
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
   
    public function editPendingPO($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $vendors = Vendor::approvedVendor();
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==5)) {
            $data=PurchaseOrder::with('poImage')->where('order_id',$slug)->whereNotIn('account_status', [2,4]);;
            if ($roleId==4 || $roleId==5) {
                 $data->where('user_id', $empId);
             }
             $data=$data->first();
            if($data){
                return view('employee/PurchaseOrder/editPendingPO',compact('data','page','vendors','apexes'));
            }else{
               return redirect()->route('employee.pendingPO')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function updatePendingPO(PurchaseOrderRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==5)) {
            $path = $this->path;
            $time = $this->time;
            $data=PurchaseOrder::where('order_id',$slug)->whereNotIn('account_status', [2,4]);
            if ($roleId==4 || $roleId==5) {
                 $data->where('user_id', $empId);
             }
             $data=$data->first();
            if ($data) {
                if ($roleId=='5') {
                    $data->advance_tds=$request->advance_tds;
                    $data->level2_user_id=Auth::guard('employee')->user()->id;
                    $data->level2_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                    if (Auth::guard('employee')->user()->id==$data->user_id) {
                        $data->account_status='3';
                    }
                    $data->level_two_date = $this->date;
                    //
                }

                    $data->vendor_id=$request->vendor;
                    $data->vendor_ary=json_encode(Vendor::vendorAry($request->vendor));
                    $data->po_start_date=$request->po_start_date;
                    $data->po_end_date=$request->po_end_date;
                    $data->payment_method=$request->payment_method;
                    $data->nature_of_service=$request->nature_of_service;
                    $data->service_detail=$request->service_detail;
                    $data->po_description=$request->po_description;
                    $data->user_id=Auth::guard('employee')->user()->id;
                    $data->user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                    if ($roleId==4) {
                        $data->account_status='1';
                    }
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
                        return redirect()->route('employee.pendingPO')->with('success', 'Saved successfully !');
                    }else{
                        return redirect()->route('employee.pendingPO')->with('error', 'Failed ! try again.');
                    }
                
            }else{
                return redirect()->route('employee.pendingPO')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function removePendingPOImage($id)
    {
       $data=PurchaseOrderFile::with('poDetail')->where('id',$id)->first();
       $pre_img=public_path($data->po_file_path);
      if ($data->delete()) {
           if(file_exists($pre_img) && $data->po_file_path){
                unlink(public_path($data->po_file_path));
            }
            return redirect()->back()->with('success','Image removed successfully');
       }else{
          return redirect()->back()->with('error', 'Failed ! try again.');
       }
    }
    public function removeAppPOImage($id)
    {
       $data=PurchaseOrderFile::with('poDetail')->where('id',$id)->first();
       $pre_img=public_path($data->po_file_path);
      if ($data->delete()) {
           if(file_exists($pre_img) && $data->po_file_path){
                unlink(public_path($data->po_file_path));
            }
            return redirect()->back()->with('success','Image removed successfully');
       }else{
          return redirect()->back()->with('error', 'Failed ! try again.');
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

    public function poPDF($value='')
    {
        $data['data']=PurchaseOrder::with('poImage')->where('order_id',$value)->first();
        if($data){
            $pdf = PDF::loadView('employee.PurchaseOrder.poPDF', $data);
            return $pdf->download('PO-'.$value.'-'.date('d-m-Y').'.pdf');
        }else{
           return redirect()->back()->with('failed', 'Failed ! try again.');
        }
    }

    public function statusApprove($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,2) &&  ($roleId==5 || $roleId==7)) {
            $data=PurchaseOrder::where('order_id',$slug)->whereIn('account_status',[1,3]);
            if ($roleId==5) {
                 $data->where('account_status', 1);
            }
            if ($roleId==7) {
                 $data->where('account_status', '3');
            }
            $data=$data->first();
            if($data){
                return view('employee/PurchaseOrder/statusApprove',compact('data','page'));
            }else{
               return redirect()->back()->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    //emp=4,mang=5,acc=9,trust=7,payofc=10,tds=11
    public function statusRequestApprove(Request $request,$slug=null,$page=null)
    {
        $path = $this->path;
        $time = $this->time;
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,2)  && ($roleId==5 || $roleId==7)) {
            $comt='';
            if ($request->account_status==2) {
                $comt='required';
            }
            if ($roleId==5) {
               $request->validate(['account_status'=>'required|in:2,3','account_status_comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==7) {
                $request->validate(['account_status'=>'required|in:2,4','account_status_comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            
            $data=PurchaseOrder::where('order_id',$slug)->whereIn('account_status',[1,3]);
            if ($roleId==5) {
                 $data->where('account_status', '1');
            }
            if ($roleId==7) {
                 $data->where('account_status', '3');
            }
            $data=$data->first();
            if ($data) {
                if ($roleId==5) {
                    $data->account_status=$request->account_status;
                    $data->level2_user_id=Auth::guard('employee')->user()->id;
                    $data->level2_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                    $data->account_status_level2_comment=$request->account_status_comment;
                    $message_title='Your Purchase order '.\App\PurchaseOrder::orderStatus($request->account_status).' .';
                    $data->level_two_date = $this->date;
                }
                if ($roleId==7) {
                    $data->account_status=$request->account_status;
                    $data->approved_user_id=Auth::guard('employee')->user()->id;
                    $data->approved_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                    $data->account_status_level3_comment=$request->account_status_comment;
                    $message_title='Your Purchase order '.\App\PurchaseOrder::orderStatus($request->account_status).' .';
                    $data->level_three_date = $this->date;
                }
               
                if($data->save()){
                    return redirect()->route('employee.pendingPO')->with('success', 'Approval status changed successfully !');
                }else{
                    return redirect()->back()->with('failed', 'Failed ! try again.');
                }

            }else{
                    return redirect()->back()->with('failed', 'Invalid Request ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    
}
