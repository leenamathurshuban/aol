<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\EmployeePayRequest;
use App\Helpers\Helper;
use App\EmployeePay;
use App\EmployeePayFile;
use App\ClaimType;
use App\Apex;
use App\Employee;
use App\Setting;
use Auth;
use PDF;
class EmployeePayController extends Controller
{
    function __construct($foo = null)
    {  
    	$this->paginate = 10;
        $this->path='EmployeePay/';
        $this->time = time().rand(111111,999999);
        $this->date=Helper::importDateInFormat();
    }

    public function index($request_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,2) && ($roleId==4 || $roleId==9 || $roleId==5 || $roleId==7 || $roleId==10 || $roleId==11))
        {
            extract($_GET);
            $data=EmployeePay::orderBy('id','DESC');
            if ($roleId==5) {
                $aplst=[$empId];
                $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                foreach ($emplst as $emplstkey => $emplstvalue) {
                    $aplst[]=$emplstvalue->id;
                }
                $data->whereIn('employee_id',$aplst);
            }
            if ($roleId==4) {
                 $data->where('employee_id',$empId);
             }
            if(isset($request_number) && !empty($request_number)){
                 $data->where('order_id', $request_number);
            }
            //$data->where('status', '7');
            if( $roleId==11){
                 $data->where('tds_amount', '>', 0);
            }
            $data->where('status', 6);
           
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/EmployeePay/approvedList',compact('data','request_number','page','total','currentPage'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function add($value='')
    { 
        $employees = Employee::where('id','!=',Auth::guard('employee')->user()->id)->where(['role_id' => 4])->pluck('name','id');
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $claimType=ClaimType::pluck('name','id');
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,2) && ($roleId==5 || $roleId==4)) {
        	return view('employee/EmployeePay/add',compact('employees','claimType','apexes'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    public function getEmpCodeEmpPay(Request $request)
    {
        return Employee::where('id',$request->empId)->where(['role_id' => 4])->first()->employee_code;
    }

    public function insert(EmployeePayRequest $request)
    {
        $path = $this->path;
        $time = $this->time;

        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,2) && ($roleId==5 || $roleId==4)) {
            $data = new EmployeePay;
            $data->pay_for = $request->pay_for;
            if ($request->pay_for=='self') {
                $emp_id=Auth::guard('employee')->user()->id;
            }else{
                $emp_id=$request->employee;
            }
            $data->pay_for_employee_id  = $emp_id;
            $data->pay_for_employee_ary = json_encode(Employee::employeeAry($emp_id));
            $bnkAry=\App\EmployeeBankAccount::where('bank_account_number',$request->bank_account_number)->first();
            $data->bank_account_number =$bnkAry->bank_account_number;// $request->bank_account_number;
            $data->ifsc = $bnkAry->ifsc;// $request->ifsc;
            $data->pan = $request->pan;
            $data->nature_of_claim_id = $request->nature_of_claim;
            $data->nature_of_claim_ary = json_encode(ClaimType::where('id',$request->nature_of_claim)->select('id','name','slug')->first()) ;
            $data->apexe_id = $request->apex;
            $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
            $data->description = $request->description;
            $data->address = $request->address;
           
            $data->employee_id = Auth::guard('employee')->user()->id;
            $data->employee_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
            $itemDetail =[];
            $grandTotal=0;
            if ($request->nature_of_claim==1) {
                if ($request->date) {
                    foreach ($request->date as $qkey => $qvalue) {
                        if ($qvalue > 0) {
                                //other
                                $total=$request->quantity[$qkey]*$request->rate[$qkey];
                                $itemDetail[]=['date'=>$qvalue,'location'=>$request->location[$qkey],'category'=>$request->category[$qkey],'quantity'=>$request->quantity[$qkey],'rate'=>$request->rate[$qkey],'bill_number'=>$request->bill_number[$qkey],'amount'=>$total,'sub_category'=>''];
                                $grandTotal=$grandTotal+$total;
                        }
                    }
                }
            }
            if ($request->nature_of_claim==2) {
               if ($request->date) {
                    foreach ($request->date as $qkey => $qvalue) {
                        if ($qvalue > 0) {
                                //trv
                                $itemDetail[]=['date'=>$qvalue,'from_location'=>$request->from_location[$qkey],'to_location'=>$request->to_location[$qkey],'distance'=>$request->distance[$qkey],'category'=>$request->category[$qkey],'bill_number'=>$request->bill_number[$qkey],'amount'=>$request->amount[$qkey],'sub_category'=>''];
                                $grandTotal=$grandTotal+$request->amount[$qkey];
                            
                        }
                    }
                }
            }
            if ($request->nature_of_claim==3) {
                if ($request->date) {
                    foreach ($request->date as $qkey => $qvalue) {
                        if ($qvalue > 0) {
                                //other
                                $itemDetail[]=['date'=>$qvalue,'category'=>$request->category[$qkey],'bill_number'=>$request->bill_number[$qkey],'amount'=>$request->amount[$qkey],'sub_category'=>$request->sub_category];
                                $grandTotal=$grandTotal+$request->amount[$qkey];
                        }
                    }
                }
            }

            if ($grandTotal < 1) {
                return redirect()->back()->with('failed','Amount value should be greater than 0');
            }
            $data->amount_requested = $grandTotal;
            $data->item_detail=json_encode(['itemDetail'=>$itemDetail,'medical'=>['pay_to'=>$request->pay_to ?? '','bank_name'=>$request->hsptl_bank_name ?? '','bank_account_number'=>$request->hsptl_bank_account_number ?? '','branch_address'=>$request->hsptl_branch_address ?? '','hsptl_name'=>$request->hsptl_name ?? '','bank_account_holder'=>$request->hsptl_bank_account_holder ?? '','ifsc'=>$request->hsptl_ifsc ?? '','pan'=>$request->hsptl_pan ?? '']]);
            //print_r($request->all());
            //print_r($data);die();
            $data->sub_category=$request->sub_category ?? '';
            if ($roleId==5) {
                $data->status=3;
                $data->manager_id = Auth::guard('employee')->user()->id;
                $data->manager_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                $data->manager_date = $this->date;
            }
            if($data->save()){
                    $data->order_id=Helper::employeePayUniqueNo($data->id);
                    $data->save();
                    if ($request->emp_req_file) {
                        foreach ($request->emp_req_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new EmployeePayFile;
                                $reqImg->emp_req_id = $data->id;
                                $reqImg->emp_req_file_path = $path.$imgName;
                                $reqImg->emp_req_file_type = $img->extension();
                                $reqImg->emp_req_file_description = $request->emp_req_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                    return redirect()->route('employee.pendingEmpPay')->with('success', 'Saved successfully !');
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
        if (\App\Employee::chkProccess($empId,2) && ($roleId==4 || $roleId==9 || $roleId==5 || $roleId==7 || $roleId==10 || $roleId==11))
        {
            extract($_GET);
            $data=EmployeePay::orderBy('id','DESC');
            if ($roleId==5) {
                $aplst=[$empId];
                $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                foreach ($emplst as $emplstkey => $emplstvalue) {
                    $aplst[]=$emplstvalue->id;
                }
                $data->whereIn('employee_id',$aplst)->orWhere('employee_id',$empId);
            }
            if(isset($request_number) && !empty($request_number)){
                 $data->where('order_id', $request_number);
            }
             if ($roleId==4) {
                 $data->where('employee_id',$empId);
             }
            
            $data->whereNotIn('status', [2,6]);
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/EmployeePay/pendingList',compact('data','request_number','page','total','currentPage'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    public function getEmpPayDetail(Request $request)
    {
        $data=EmployeePay::where('order_id',$request->slug)->first();
        if($data){
            $type='getEmpPayDetail';
            return view('employee.EmployeePay.ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function remove($slug)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,2) &&  ($roleId==5 || $roleId==4)) {
            $data=EmployeePay::where('order_id',$slug)->where('status','!=',7);
            $path = $this->path;
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                $id=$data->id;
                if ($data->empReqImage) {
                   foreach ($data->empReqImage as $key => $ImgData) {
                    $pre_img=public_path($ImgData->emp_req_file_path);
                      if(file_exists($pre_img) && $ImgData->emp_req_file_path){
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
        $employees = Employee::where('id','!=',Auth::guard('employee')->user()->id)->where(['role_id' => 4])->pluck('name','id');
        $claimType=ClaimType::pluck('name','id');
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,2) &&  ($roleId==5 || $roleId==4)) {
            if ($roleId==5) {
                $data=EmployeePay::where('order_id',$slug)->whereNotIn('status',[2,4,5,6,7]);
            }else{
                $data=EmployeePay::where('order_id',$slug)->whereNotIn('status',[2,3,4,5,6,7]); 
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                return view('employee/EmployeePay/editPending',compact('data','page','employees','claimType','apexes'));
            }else{
               return redirect()->route('employee.pendingEmpPay')->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    
    public function updatePending(EmployeePayRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,2) && ($roleId==5 || $roleId==4)) {
            $path = $this->path;
            $time = $this->time;
            if ($roleId==5) {
                $data=EmployeePay::where('order_id',$slug)->whereNotIn('status',[2,4,5,6,7]);
            }else{
                $data=EmployeePay::where('order_id',$slug)->whereNotIn('status',[2,3,4,5,6,7]);
            }
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
             if ($data) {
                $data->pay_for = $request->pay_for;
                if ($request->pay_for=='self') {
                    $emp_id=Auth::guard('employee')->user()->id;
                }else{
                    $emp_id=$request->employee;
                }
                $data->pay_for_employee_id  = $emp_id;
                $data->pay_for_employee_ary = json_encode(Employee::employeeAry($emp_id));
                $bnkAry=\App\EmployeeBankAccount::where('bank_account_number',$request->bank_account_number)->first();
                $data->bank_account_number =$bnkAry->bank_account_number;// $request->bank_account_number;
                $data->ifsc = $bnkAry->ifsc;// $request->ifsc;
                $data->pan = $request->pan;
                $data->nature_of_claim_id = $request->nature_of_claim;
                $data->nature_of_claim_ary = json_encode(ClaimType::where('id',$request->nature_of_claim)->select('id','name','slug')->first()) ;
                $data->apexe_id = $request->apex;
                $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first()) ;
                $data->description = $request->description;
                $data->address = $request->address;
                //$data->amount_requested = $request->amount_requested;
                $data->employee_id = Auth::guard('employee')->user()->id;
                $data->employee_ary =  json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                // item detail
                    $itemDetail =[];
                    $grandTotal=0;
                    if ($request->nature_of_claim==1) {
                        if ($request->date) {
                            foreach ($request->date as $qkey => $qvalue) {
                                if ($qvalue > 0) {
                                        //other
                                        $total=$request->quantity[$qkey]*$request->rate[$qkey];
                                        $itemDetail[]=['date'=>$qvalue,'location'=>$request->location[$qkey],'category'=>$request->category[$qkey],'quantity'=>$request->quantity[$qkey],'rate'=>$request->rate[$qkey],'bill_number'=>$request->bill_number[$qkey],'amount'=>$total,'sub_category'=>''];
                                        $grandTotal=$grandTotal+$total;
                                }
                            }
                        }
                    }
                    if ($request->nature_of_claim==2) {
                       if ($request->date) {
                            foreach ($request->date as $qkey => $qvalue) {
                                if ($qvalue > 0) {
                                        //trv
                                        $itemDetail[]=['date'=>$qvalue,'from_location'=>$request->from_location[$qkey],'to_location'=>$request->to_location[$qkey],'distance'=>$request->distance[$qkey],'category'=>$request->category[$qkey],'bill_number'=>$request->bill_number[$qkey],'amount'=>$request->amount[$qkey],'sub_category'=>''];
                                        $grandTotal=$grandTotal+$request->amount[$qkey];
                                    
                                }
                            }
                        }
                    }
                    if ($request->nature_of_claim==3) {
                        if ($request->date) {
                            foreach ($request->date as $qkey => $qvalue) {
                                if ($qvalue > 0) {
                                        //other
                                        $itemDetail[]=['date'=>$qvalue,'category'=>$request->category[$qkey],'bill_number'=>$request->bill_number[$qkey],'amount'=>$request->amount[$qkey],'sub_category'=>$request->sub_category];
                                        $grandTotal=$grandTotal+$request->amount[$qkey];
                                }
                            }
                        }
                    }
                    if ($grandTotal < 1) {
                        return redirect()->back()->with('failed','Amount value should be greater than 0');
                    }
                    $data->amount_requested = $grandTotal;
                    $data->item_detail=json_encode(['itemDetail'=>$itemDetail,'medical'=>['pay_to'=>$request->pay_to ?? '','bank_name'=>$request->hsptl_bank_name ?? '','bank_account_number'=>$request->hsptl_bank_account_number ?? '','branch_address'=>$request->hsptl_branch_address ?? '','hsptl_name'=>$request->hsptl_name ?? '','bank_account_holder'=>$request->hsptl_bank_account_holder ?? '','ifsc'=>$request->hsptl_ifsc ?? '','pan'=>$request->hsptl_pan ?? '']]);
                // enditem
                    $data->sub_category=$request->sub_category ?? '';
                    if ($roleId==5) {
                        $data->status=3;
                        $data->manager_id = Auth::guard('employee')->user()->id;
                        $data->manager_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                        $data->manager_date = $this->date;
                    }
                if($data->save()){
                     if ($request->emp_req_file) {
                        foreach ($request->emp_req_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new EmployeePayFile;
                                $reqImg->emp_req_id = $data->id;
                                $reqImg->emp_req_file_path = $path.$imgName;
                                $reqImg->emp_req_file_type = $img->extension();
                                $reqImg->emp_req_file_description = $request->emp_req_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                        return redirect()->route('employee.pendingEmpPay',($page > 1) ? 'page='.$page : '')->with('success', 'Updated successfully !');
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
        $employees = Employee::where('id','!=',Auth::guard('employee')->user()->id)->where(['role_id' => 4])->pluck('name','id');
        $claimType=ClaimType::pluck('name','id');
        $apexes=Apex::pluck('name','id');
        if (\App\Employee::chkProccess($empId,2) &&  ($roleId!=4 || $roleId!=11)) {
            $data=EmployeePay::where('order_id',$slug)->whereIn('status',[1,3,4,5]);
            if ($roleId==5) {
                 $data->where('status', 1);
            }
            if ($roleId==9) {
                 $data->where('status', '3');
            }
            if ($roleId==7) {
                 $data->where('status', '4');
            }
            if ($roleId==10) {
                 $data->where('status', '5');
            }
            if ($roleId==11) {
                 $data->where('status', '6');
            }
            $data=$data->first();
            if($data){
                return view('employee/EmployeePay/statusApprove',compact('data','page','employees','claimType','apexes'));
            }else{
               return redirect()->route('employee.pendingEmpPay',($page > 1) ? 'page='.$page : '')->with('failed', 'Failed ! try again.');
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
        if (\App\Employee::chkProccess($empId,2)  && ($roleId!=4 || $roleId!=11)) {
            $comt='';
            if ($request->status==2) {
                $comt='required';
            }
            if ($roleId==5) {
               $request->validate(['status'=>'required|in:2,3','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==7) {
                $request->validate(['status'=>'required|in:2,5','comment'=>$comt,'amount_approved'=>'required|numeric|min:0',
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==9) {

                $request->validate(['status'=>'required|in:2,4','comment'=>$comt,'required_tds'=>'required|in:Yes,No','specified_person'=>'required|in:Yes,No',
                    'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);

                if ($request->required_tds=='Yes') {
                    $request->validate(['status'=>'required|in:2,4','comment'=>$comt,'tds'=>'required|numeric|min:0','tds_amount'=>'required|numeric|min:0','tds_month'=>'required','project_id'=>'required','cost_center'=>'required','specified_person'=>'required|in:Yes,No',
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
                }
                
            }
            if ($roleId==10) {
                $request->validate(['status'=>'required|in:2,6','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==11) {
                $request->validate(['status'=>'required|in:2,7','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            $data=EmployeePay::where('order_id',$slug)->whereIn('status',[1,3,4,5,6]);
            if ($roleId==5) {
                 $data->where('status', '1');
            }
            if ($roleId==9) {
                 $data->where('status', '3');
            }
            if ($roleId==7) {
                 $data->where('status', '4');
            }
            if ($roleId==10) {
                 $data->where('status', '5');
            }
            if ($roleId==11) {
                 $data->where('status', '6');
            }
            $data=$data->first();
            if ($data) {
                if ($roleId==5) {
                   $data->status = $request->status;
                   $data->manager_id = Auth::guard('employee')->user()->id;
                   $data->manager_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->manager_comment = $request->comment;
                   $data->manager_date = $this->date;
                   
                }
                if ($roleId==7) {
                   $data->status = $request->status;
                   $data->trust_ofc_id = Auth::guard('employee')->user()->id;
                   $data->trust_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->trust_ofc_comment = $request->comment;
                   //$data->amount_approved = $request->amount_approved;
                   $data->amount_approved = $data->amount_requested;
                   $data->trust_date = $this->date;
                }
                if ($roleId==9) {
                   $data->status = $request->status;
                   $data->account_dept_id = Auth::guard('employee')->user()->id;
                   $data->account_dept_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->account_dept_comment = $request->comment;
                   $data->required_tds = $request->required_tds;
                   $data->account_date = $this->date;
                   if ($request->required_tds=='Yes') {
                       $data->tds = $request->tds;
                       $tds_amount=ceil($data->amount_requested*$request->tds/100);
                       $data->tds_amount = ($tds_amount); 
                       //$data->tds_payable=round(($request->debit_account+$data->tax_amount-$tds_amount));
                       $data->tds_month = $request->tds_month;
                       $data->project_id = $request->project_id;
                       $data->cost_center = $request->sec_cost_center;
                    }
                   $data->specified_person = $request->specified_person;
                   /*---*/
                   $formAccount=[];
                    if ($request->debit_account) {
                            foreach ($request->debit_account as $f_key => $f_value) {
                                 $formAccount[] = ['debit_account'=>$f_value,'amount'=>$request->amount[$f_key],'cost_center'=>$request->cost_center[$f_key],'category'=>$request->category[$f_key]];
                            }
                         $data->form_by_account=json_encode(['form_by_account'=>$formAccount,'bank_account'=>$request->bank_account[$data->id],'ifsc'=>$request->ifsc[$data->id],'bank_name'=>$request->bank_name[$data->id]]);
                    }
                   /*--*/
                   if ($data->amount_requested!=array_sum($request->amount)) {
                        return redirect()->back()->with('failed','Request amount is ₹'.$data->amount.'. So debit account must be equal according to invoice amount. Your current debit account amount is ₹'.array_sum($request->amount));
                    }
                }
                if ($roleId==10) {
                   $data->status = $request->status;
                   $data->payment_ofc_id = Auth::guard('employee')->user()->id;
                   $data->payment_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->payment_ofc_comment = $request->comment;
                }
                if ($roleId==11) {
                   $data->status = $request->status;
                   $data->tds_ofc_id = Auth::guard('employee')->user()->id;
                   $data->tds_ofc_ary =json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->tds_ofc_comment = $request->comment;
                   $data->tds_date = $this->date;
                }
                if($data->save()){
                    if ($request->emp_req_file) {
                        foreach ($request->emp_req_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new EmployeePayFile;
                                $reqImg->emp_req_id = $data->id;
                                $reqImg->emp_req_file_path = $path.$imgName;
                                $reqImg->emp_req_file_type = $img->extension();
                                $reqImg->emp_req_file_description = $request->emp_req_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                    return redirect()->route('employee.pendingEmpPay')->with('success', 'Approval status changed successfully !');
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

    public function removePendingReqImage($id)
    {
       $data=EmployeePayFile::with('empReqDetail')->where('id',$id)->first();
       $pre_img=public_path($data->emp_req_file_path);
      if ($data->delete()) {
           if(file_exists($pre_img) && $data->emp_req_file_path){
                unlink(public_path($data->emp_req_file_path));
            }
            return redirect()->back()->with('success','Image removed successfully');
       }else{
          return redirect()->back()->with('error', 'Failed ! try again.');
       }
    }

    public function getEmpPayFullArray(Request $request)
    {
        $data=Employee::where('id',$request->empId)->first();
        if($data){
            if ($request->type=='getEmpPayFullArray') {
                return ($data);
            }if ($request->type=='getEmpAccountArray') {
                $data=\App\EmployeeBankAccount::where('employees_id',$request->empId)->pluck('bank_account_number','bank_account_number');
                $type=$request->type;
                return view('employee/EmployeePay/ajax',compact('data','type'));
            }
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function getItemRowByClaim(Request $request)
    {
        $data=ClaimType::where('id',$request->nature_of_claim)->first();
        if($data){
            $type=$request->type;
            $cls=$request->cls;
            $headRow=$request->headRow;
            $subCatId=$request->subCatId;
            return view('employee/EmployeePay/ajax',compact('data','type','cls','headRow','subCatId'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function getMedicalPayHistory(Request $request)
    {
        $data=EmployeePay::orderBy('id','desc')->where('pay_for_employee_id',$request->emp_id);
        //if ($request->sub_category) {
            $data->where('sub_category',$request->sub_category);
        //}
        if ($request->status) {
            $data->where('status',$request->status);
        }
        if ($request->from_date && $request->till_date=='') {
            $data->whereDate('created_at',$request->from_date);
        }
        if ($request->from_date && $request->till_date) {
            $data->whereBetween('created_at',[$request->from_date,$request->till_date]);
        }
        //if($data->count()){
            $type=$request->type;
            $sub_category=$request->sub_category;
            $data=$data->get();
            $status=$request->status ?? '';
            $from_date=$request->from_date ?? '';
            $till_date=$request->till_date ?? '';
            return view('employee/EmployeePay/ajax',compact('data','type','sub_category','status','till_date','from_date'));
        /*}else{
           return '<h2>Payment history not found.</h2>';
        }*/
    }

    public function employeePayPDF($value='')
    {
        $data['data']=EmployeePay::where('order_id',$value)->first();
        if ($data) {
            $pdf = PDF::loadView('employee.EmployeePay.employeePayPDF', $data);
            return $pdf->download('Employee-Pay-'.date('d-m-Y').'.pdf');
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }
}