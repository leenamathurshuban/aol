<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\InternalTransferRequest;
use App\Helpers\Helper;
use App\Employee;
use App\InternalTransfer;
use App\InternalTransferFile;
use App\BankAccount;
use App\Apex;
use App\Setting;
use Auth;
use PDF;
class InternalTransferController extends Controller
{
     function __construct($foo = null)
    {
    	$this->paginate = 10;
        $this->path='InternalTransfer/';
        $this->time = time().rand(111111,999999);
        $this->bankHeadOfc=BankAccount::bnkHeadOfcWidIdPluck();
        $this->date=Helper::importDateInFormat();
    } 

    public function index($request_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,6) && ($roleId==4 || $roleId==9 || $roleId==7 || $roleId==10))
        {
            extract($_GET);
            $data=InternalTransfer::orderBy('id','DESC');
            if ($roleId==4) {
                $data->where('employee_id',$empId);
            }
            if(isset($request_number) && !empty($request_number)){
                 $data->where('order_id', $request_number);
            }
            
            $data->where('status', '5');
           
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/InternalTransfer/approvedList',compact('data','request_number','page','total','currentPage'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function add($value='')
    { 
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $bankAccount=$this->bankHeadOfc;
        $apexs=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,6) && $roleId==4) {
        	return view('employee.InternalTransfer.add',compact('bankAccount','apexs'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    
    public function insert(InternalTransferRequest $request)
    {
        $path = $this->path;
        $time = $this->time;

        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,6) && $roleId==4) {
            $data = new InternalTransfer;
            $data->nature_of_request = $request->pay_for;
            if ($request->pay_for=='State requesting funds') {
               $data->apex_id = $request->state;
               $data->apex_ary = json_encode(Apex::where('id',$request->state)->first());
               $data->state_bank_id = $request->state_bank_id;
               $data->state_bank_ary = json_encode(BankAccount::where('id',$request->state_bank_id)->first());
               $data->ifsc = $request->ifsc;
               $data->project_name = $request->project_name;
               $data->reason = $request->reason;
               $data->project_id = $request->project_id;
               $data->cost_center = $request->cost_center;

               $data->apexe_id = $request->state;
               $data->apexe_ary = json_encode(Apex::where('id',$request->state)->first());

            }
            if ($request->pay_for=='Inter bank transfer') {
            	$data->transfer_from = $request->transfer_from;
            	$data->transfer_from_ary = json_encode(BankAccount::where('id',$request->transfer_from)->first());
            	$data->transfer_to = $request->transfer_to;
            	$data->transfer_to_ary = json_encode(BankAccount::where('id',$request->transfer_to)->first());
                $data->apexe_id = $request->apex;
                $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());

            }
            $emp_id=Auth::guard('employee')->user()->id;
            $data->employee_id  = $emp_id;
            $data->employee_ary = json_encode(Employee::employeeAry($emp_id));
            $data->employee_date = date('Y-m-d');
            $data->amount = $request->amount;
            //$data->description = $request->description ?? '';
            //print_r($data);die();
            
            if($data->save()){
                    $data->order_id=Helper::internalTransferUniqueNo($data->id);
                    $data->save();
                    if ($request->emp_req_file) {
                        foreach ($request->emp_req_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new InternalTransferFile;
                                $reqImg->internal_transfer_id = $data->id;
                                $reqImg->internal_transfer_file_path = $path.$imgName;
                                $reqImg->internal_transfer_file_type = $img->extension();
                                $reqImg->internal_transfer_file_description = $request->emp_req_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                    return redirect()->route('employee.pendingInternalTransfer')->with('success', 'Saved successfully !');
                }else{
                    return redirect()->back()->with('failed', 'Failed ! try again.');
                }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    
    public function pendingRequest($request_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,6) && ($roleId==4 || $roleId==9 || $roleId==5 || $roleId==7 || $roleId==10 || $roleId==11))
        {
            extract($_GET);
            $data=InternalTransfer::orderBy('id','DESC');
           
            if(isset($request_number) && !empty($request_number)){
                 $data->where('order_id', $request_number);
            }
             
             if ($roleId==4) {
                 $data->where('employee_id', $empId);
            }
           $data->whereNotIn('status', [2,5]);
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/InternalTransfer/pendingList',compact('data','request_number','page','total','currentPage'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    public function getInternalTrnsDetail(Request $request)
    {
        if ($request->type=='getBankByState') {
            $bankAccount=BankAccount::where('apexe_id',$request->slug)->pluck('bank_account_number','id');
            if($bankAccount){
                $type=$request->type;
                return view('employee/InternalTransfer/ajax',compact('bankAccount','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }else{
            $data=InternalTransfer::where('order_id',$request->slug)->first();
            if($data){
                $type=$request->type;
                return view('employee/InternalTransfer/ajax',compact('data','type'));
            }else{
               return '<h2>Data not found.</h2>';
            }
        }
    }

    public function remove($slug)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,6) &&  ($roleId==4)) {
            $data=InternalTransfer::where('order_id',$slug)->where('status','!=',5);
            $path = $this->path;
            if ($roleId==4) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                $id=$data->id;
                if ($data->internalTransferImage) {
                   foreach ($data->internalTransferImage as $key => $ImgData) {
                    $pre_img=public_path($ImgData->internal_transfer_file_path);
                      if(file_exists($pre_img) && $ImgData->internal_transfer_file_path){
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
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function editPending($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $bankAccount=$this->bankHeadOfc;
        $apexs=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,6) &&  ($roleId==4)) {
            $data=InternalTransfer::where('order_id',$slug)->whereNotIn('status',[2,3,4,5,6,7]);
            if ($roleId==4) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                return view('employee/InternalTransfer/editPending',compact('data','page','bankAccount','apexs'));
            }else{
               return redirect()->route('employee.pendingInternalTransfer')->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    
    public function updatePending(InternalTransferRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,6) && ($roleId==4)) {
            $path = $this->path;
            $time = $this->time;
             $data=InternalTransfer::where('order_id',$slug)->whereNotIn('status',[2,3,4,5]);
             if ($roleId==4) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
             if ($data) {
            $data->nature_of_request = $request->pay_for;
            if ($request->pay_for=='State requesting funds') {
               $data->apex_id = $request->state;
               $data->apex_ary = json_encode(Apex::where('id',$request->state)->first());
               $data->state_bank_id = $request->state_bank_id;
               $data->state_bank_ary = json_encode(BankAccount::where('id',$request->state_bank_id)->first());
               $data->ifsc = $request->ifsc;
               $data->project_name = $request->project_name;
               $data->reason = $request->reason;
               $data->project_id = $request->project_id;
               $data->cost_center = $request->cost_center;

               $data->apexe_id = $request->state;
                $data->apexe_ary = json_encode(Apex::where('id',$request->state)->select('id','name','slug')->first());

            }
            if ($request->pay_for=='Inter bank transfer') {
            	$data->transfer_from = $request->transfer_from;
            	$data->transfer_from_ary = json_encode(BankAccount::where('id',$request->transfer_from)->first());
            	$data->transfer_to = $request->transfer_to;
            	$data->transfer_to_ary = json_encode(BankAccount::where('id',$request->transfer_to)->first());
                $data->apexe_id = $request->apex;
                $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());

            }
            $emp_id=Auth::guard('employee')->user()->id;
            $data->employee_id  = $emp_id;
            $data->employee_ary = json_encode(Employee::employeeAry($emp_id));
            $data->employee_date = date('Y-m-d');
            $data->amount = $request->amount;
            
            if($data->save()){
                    $data->order_id=Helper::internalTransferUniqueNo($data->id);
                    $data->save();
                    if ($request->emp_req_file) {
                        foreach ($request->emp_req_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new InternalTransferFile;
                                $reqImg->internal_transfer_id = $data->id;
                                $reqImg->internal_transfer_file_path = $path.$imgName;
                                $reqImg->internal_transfer_file_type = $img->extension();
                                $reqImg->internal_transfer_file_description = $request->emp_req_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                    return redirect()->route('employee.pendingInternalTransfer',($page > 1) ? 'page='.$page : '')->with('success', 'Saved successfully !');
                }else{
                    return redirect()->back()->with('failed', 'Failed ! try again.');
                }
             }else{
               return redirect()->back()->with('failed', 'Invalid ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function statusApprove($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $bankAccount=BankAccount::pluck('bank_account_number','id');
        $apexs=Apex::pluck('name','id');
        if (\App\Employee::chkProccess($empId,6) &&  ($roleId!=4)) {
            $data=InternalTransfer::where('order_id',$slug)->whereIn('status',[1,3,4]);
            if ($roleId==9) {
                $data->where('status',1);
            }
            if ($roleId==7) {
                $data->where('status',3);
            }
            if ($roleId==10) {
                $data->where('status',4);
            }
            $data=$data->first();
            if ($data) {
                return view('employee/InternalTransfer/statusApprove',compact('data','page','bankAccount','apexs'));
            }else{
               return redirect()->route('employee.pendingInternalTransfer',($page > 1) ? 'page='.$page : '')->with('failed', 'Failed ! try again.');
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
        if (\App\Employee::chkProccess($empId,6)  && ($roleId!=4)) {
            $comt='';
            if ($request->status==2) {
                $comt='required';
            }
            
            if ($roleId==7) {
                $request->validate(['status'=>'required|in:2,4','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==9) {
                $request->validate(['status'=>'required|in:2,3','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==10) {
                $request->validate(['status'=>'required|in:2,5','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            $data=InternalTransfer::where('order_id',$slug)->whereIn('status',[1,3,4,5]);
            if ($roleId==9) {
            	$data->where('status',1);
            }
            if ($roleId==7) {
            	$data->where('status',3);
            }
            if ($roleId==10) {
            	$data->where('status',4);
            }
            $data=$data->first();
            if ($data) {
               
                if ($roleId==7) {
                   $data->status = $request->status;
                   $data->trust_ofc_id = Auth::guard('employee')->user()->id;
                   $data->trust_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->trust_ofc_comment = $request->comment;
                }
                if ($roleId==9) {
                   $data->status = $request->status;
                   $data->account_dept_id = Auth::guard('employee')->user()->id;
                   $data->account_dept_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->account_dept_comment = $request->comment;
                   $formAccount=[];
                    if ($request->debit_account) {
                            foreach ($request->debit_account as $f_key => $f_value) {
                                 $formAccount[] = ['debit_account'=>$f_value,'amount'=>$request->amount[$f_key],'cost_center'=>$request->cost_center[$f_key],'category'=>$request->category[$f_key]];
                            }
                         $data->form_by_account=json_encode(['form_by_account'=>$formAccount,'bank_account'=>$request->bank_account[$data->id] ?? '','ifsc'=>$request->ifsc[$data->id] ?? '','bank_name'=>$request->bank_name[$data->id] ?? '']);
                    }

                    if ($data->amount!=array_sum($request->amount)) {
                        return redirect()->back()->with('failed','Request amount is ₹'.$data->amount.'. So debit account must be equal according to invoice amount. Your current debit account amount is ₹'.array_sum($request->amount));
                    }
                }
                if ($roleId==10) {
                   $data->status = $request->status;
                   $data->payment_ofc_id = Auth::guard('employee')->user()->id;
                   $data->payment_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->payment_ofc_comment = $request->comment;
                }
               
                if($data->save()){
                    if ($request->emp_req_file) {
                        foreach ($request->emp_req_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new InternalTransferFile;
                                $reqImg->internal_transfer_id = $data->id;
                                $reqImg->internal_transfer_file_path = $path.$imgName;
                                $reqImg->internal_transfer_file_type = $img->extension();
                                $reqImg->internal_transfer_file_description = $request->emp_req_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                    return redirect()->route('employee.pendingInternalTransfer')->with('success', 'Approval status changed successfully !');
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

    public function removeInternalTransferImage($id)
    {
       $data=InternalTransferFile::with('internalTransferDetail')->where('id',$id)->first();
       $pre_img=public_path($data->internal_transfer_file_path);
      if ($data->delete()) {
           if(file_exists($pre_img) && $data->internal_transfer_file_path){
                unlink(public_path($data->internal_transfer_file_path));
            }
            return redirect()->back()->with('success','Image removed successfully');
       }else{
          return redirect()->back()->with('error', 'Failed ! try again.');
       }
    }

    public function getBankAccountArray(Request $request)
    {
        $data=BankAccount::where('id',$request->bnkId)->first();
        if($data){
            return ($data);
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function bnkPDF($value='')
    {
        $data['data']=InternalTransfer::where('order_id',$value)->first();
        if ($data) {
            $pdf = PDF::loadView('employee.InternalTransfer.bnkPDF', $data);
            return $pdf->download('internal-transfer-'.date('d-m-Y').'.pdf');
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }

}
