<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\VendorRequest;
use App\State;
use App\City; 
use App\User;
use App\Vendor;
use App\Employee;
use Auth;
use App\Exports\VendorExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VendorImport;
use App\Setting;
use Mail;
use App\Mail\VendorFormMail;
use App\Mail\VendorApprovalMail;
use App\Mail\FormVendorConfMail;
use App\Helpers\Helper;
use PDF;
class VendorController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->pan_file='vendor/pan_file/';
        $this->cancel_cheque_file='vendor/cancel_cheque_file/';
        $this->time = time().rand(111111,999999);
        $this->date=Helper::importDateInFormat();
    }
    public function index($name='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==8)) {
            extract($_GET);
            $states=State::pluck('name','id');
            $cities=City::pluck('name','id');
            $data=Vendor::where('account_status','3')->orderBy('id','DESC');
            if(isset($name) && !empty($name)){
                 $data->where('name', 'LIKE', "%$name%")->orWhere('vendor_code',$name);
            }
            
            $total=$data->count();
            $data=$data->paginate($this->paginate);
        	$page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
           if ($roleId==4) {
               return view('employee/vendor/list',compact('data','name','page','total','states','cities','currentPage'));
           }else{
                 return view('employee/vendor/listForApprover',compact('data','name','page','total','states','cities','currentPage'));
           }
        	
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }

    }

    public function pendingEmpVendor($name='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==8)) {
            extract($_GET);
            $states=State::pluck('name','id');
            $cities=City::pluck('name','id');
            $data=Vendor::orderBy('id','DESC');
            if(isset($name) && !empty($name)){
                 $data->where('name', 'LIKE', "%$name%")->orWhere('vendor_code',$name);
            }
            if ($roleId==8) {
                $data->where('account_status', '1');
            }if ($roleId==4) {
                $data->where('account_status', '1')->orWhere('account_status', '2');
            }
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/vendor/pendingEmpVendor',compact('data','name','page','total','states','cities','currentPage'));
           
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }

    }

    public function add($value='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
            $constitutions=Vendor::Constitution();
            $states=State::where('status','1')->pluck('name','id');
            $cities=City::where('status','1')->pluck('name','id');
        	return view('employee/vendor/add',compact('states','cities','constitutions'));
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function edit($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==8)) {
            $constitutions=Vendor::Constitution();
            $states=State::where('status','1')->pluck('name','id');
            $cities=City::where('status','1')->pluck('name','id');
        	$data=Vendor::where('vendor_code',$slug)->where('account_status','!=','3')->first();

            //dd($data);
            if($data){
                return view('employee/vendor/edit',compact('data','states','cities','page','constitutions'));
            }else{
               return redirect()->route('employee.vendors')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function insert(VendorRequest $request,$slug=null)
    {   
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==8)) {
            $pan_file = $this->pan_file;
            $cancel_cheque_file = $this->cancel_cheque_file;
            $time = $this->time;
        	$data=new Vendor;
            $data->name=$request->name;
            $data->email=$request->email;
            $data->original_password=$request->password;
            $data->password=Hash::make($request->password);
            $data->phone=$request->phone;
        	$data->state_id=$request->state;
            $data->state_ary=json_encode(State::where('id',$request->state)->select('id','name','slug')->first());
            $data->city_id=$request->city;
            $data->city_ary=json_encode(City::where('id',$request->city)->select('id','name','slug')->first());
            $data->bank_account_type=$request->bank_account_type;
            $data->bank_account_number=$request->bank_account_number;
            $data->ifsc=$request->ifsc;
            $data->pan=$request->pan;
            if($roleId==8){
                 $data->specified_person=$request->specified_person;
            }
            $data->constitution=$request->constitution;
            $data->specify_if_other=$request->specify_if_other;
            $data->address=$request->address;
            $data->location=$request->location;
            $data->zip=$request->zip;
            $data->gst=$request->gst;
            $data->user_id=Auth::guard('employee')->user()->id;
            $data->user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
            if($request->pan_file){
                $PanFileName=$time.'.'.$request->pan_file->extension();
                $data->pan_file=$pan_file.$PanFileName;
            }
            if($request->cancel_cheque_file){
                $CancelChequeFileName=$time.'.'.$request->cancel_cheque_file->extension();
                $data->cancel_cheque_file=$cancel_cheque_file.$CancelChequeFileName;
            }
        	if($data->save()){
                $data->vendor_code=Helper::vendorUniqueNo($data->id);
                $data->save();
                if($request->pan_file){
                  $request->pan_file->move(public_path($pan_file),$PanFileName);
                }
                if($request->cancel_cheque_file){
                  $request->cancel_cheque_file->move(public_path($cancel_cheque_file),$CancelChequeFileName);
                }
        		return redirect()->route('employee.vendors')->with('success', 'Saved successfully !');
        	}else{
        		return redirect()->route('employee.vendors')->with('error', 'Failed ! try again.');
        	}
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function update(VendorRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==8)) {
            $pan_file = $this->pan_file;
            $cancel_cheque_file = $this->cancel_cheque_file;
            $time = $this->time;
            $data=Vendor::where('vendor_code',$slug)->where('account_status','!=','3')->first();
            if ($data) {
               $oldPanFile='';
               $pre_pan_file=public_path($data->pan_file);
                if (isset($data->pan_file)) {
                     $oldPanFile=$data->pan_file;
                }
                $oldCancelCheque='';
                $pre_cancel_cheque_file=public_path($data->cancel_cheque_file);
                if (isset($data->cancel_cheque_file)) {
                    
                     $oldCancelCheque=$data->cancel_cheque_file;
                }
                $data->name=$request->name;
                $data->email=$request->email;
                $data->original_password=$request->password;
                $data->password=Hash::make($request->password);
                $data->phone=$request->phone;
                $data->state_id=$request->state;
                $data->state_ary=json_encode(State::where('id',$request->state)->select('id','name','slug')->first());
                $data->city_id=$request->city;
                $data->city_ary=json_encode(City::where('id',$request->city)->select('id','name','slug')->first());
                $data->bank_account_type=$request->bank_account_type;
                $data->bank_account_number=$request->bank_account_number;
                $data->ifsc=$request->ifsc;
                $data->pan=$request->pan;
                if($roleId==8){
                     $data->specified_person=$request->specified_person;
                }
                //$data->specified_person=$request->specified_person;
                $data->constitution=$request->constitution;
                $data->specify_if_other=$request->specify_if_other;
                $data->address=$request->address;
                $data->location=$request->location;
                $data->zip=$request->zip;
                $data->gst=$request->gst;
                $data->user_id=Auth::guard('employee')->user()->id;
                $data->user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                if($request->pan_file){
                    $PanFileName=$time.'.'.$request->pan_file->extension();
                    $data->pan_file=$pan_file.$PanFileName;
                }
                if($request->cancel_cheque_file){
                    $CancelChequeFileName=$time.'.'.$request->cancel_cheque_file->extension();
                    $data->cancel_cheque_file=$cancel_cheque_file.$CancelChequeFileName;
                }
                if ($data->account_status!='3') {
                    $data->account_status= '1';
                }
                if($data->save()){
                    if($request->pan_file){
                        if(file_exists($pre_pan_file) && $oldPanFile){
                            unlink($pre_pan_file);
                        }
                        $request->pan_file->move(public_path($pan_file),$PanFileName); 
                    }
                    if($request->cancel_cheque_file){
                        if(file_exists($pre_cancel_cheque_file) && $oldCancelCheque){
                            unlink($pre_cancel_cheque_file);
                        }
                        $request->cancel_cheque_file->move(public_path($cancel_cheque_file),$CancelChequeFileName); 
                    }
                    
                       return redirect()->route('employee.vendors',($page > 1) ? 'page='.$page : '')->with('success', 'Update successfully !');
                    
                }else{
                    return redirect()->route('employee.vendors')->with('error', 'Failed ! try again.');
                }
            }else{
                return redirect()->back()->with('error', 'Failed ! try again.');
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
            $data=Vendor::where('vendor_code',$slug)->first();
            if($data){
                $data->status=$request->status;
                $data->save();
                return redirect()->route('employee.vendors')->with('success', 'Status changed successfully !');
            }else{
               return redirect()->route('employee.vendors')->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==8)) {
            $pan_file = $this->pan_file;
            $cancel_cheque_file = $this->cancel_cheque_file;
            $data=Vendor::where('vendor_code',$slug)->where('account_status','!=','3')->first();
            if($data){
                if ($data->pan_file) {
                    $pre_img=public_path($data->pan_file);
                      if(file_exists($pre_img) && $data->pan_file){
                            unlink($pre_img);
                        }
                }
                if ($data->cancel_cheque_file) {
                    $pre_img=public_path($data->cancel_cheque_file);
                      if(file_exists($pre_img) && $data->cancel_cheque_file){
                            unlink($pre_img);
                        }
                }
                $data->delete();
            //if($data->delete()){
                return redirect()->back()->with('success', 'Removed successfully !');
            }else{
               return redirect()->back()->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function getCityByState(Request $request)
    {
        $states=State::where('id',$request->sId)->first();
        if($states){
            $cities=City::where('state_id',$request->sId)->pluck('name','id');
            $type=$request->type;
            return view('employee/vendor/ajax',compact('cities','type','states'));
        }
    }
    public function getVendorFormCityByState(Request $request)
    {
        $states=State::where('id',$request->sId)->first();
        if($states){
            $cities=City::where('state_id',$request->sId)->pluck('name','id');
            $type=$request->type;
            return view('employee/vendor/ajax',compact('cities','type','states'));
            die();
        }
    }

    public function getVendorDetail($value='')
    {
        $data=Vendor::where('vendor_code',$_POST['slug'])->first();
        if($data){
            $type='viewDetail';
            return view('employee/vendor/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function export($slug=null) 
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
            return Excel::download(new VendorExport($slug), 'venodr.xlsx');
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function import(Request $request)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
             $file = new VendorImport();
            $file->import(request()->file('bulk_vendor_data'));
            foreach ($file->failures() as $failure) {
                    $failure->row(); 
                    $failure->attribute(); 
                    $failure->errors(); 
                    $failure->values();
                    if($failure->errors() && !empty($failure->errors())) {
                        return redirect()->back()->with('success', 'Vendor data imported Successfully')->with('sheeterror', $failure);
                    }
                }
                return redirect()->back()->with('success', 'Vendor data imported Successfully');
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
       
    }

    public function VendorFormLink($value='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
            $empId = Auth::guard('employee')->user()->id;
            $roleId = Auth::guard('employee')->user()->role_id;
            if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
                return view('employee/vendor/VendorFormLink');
            }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function VendorFormMail(Request $request)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
            $request->validate(['email'=>'required|email','subject'=>'required','message'=>'']);
             //email
            $data['logo'] = Setting::setting('dark_logo');
            $data['title'] = Setting::setting('title');
            $data['FromEmail'] = Setting::setting('email');
            $data['fromAddress'] = Setting::setting('address');
            $data['fromMobile'] = Setting::setting('mobile');
            $data['message'] = $request->message;
            $data['subject'] = $request->subject;
            Mail::to([$request->email])->send(new VendorFormMail($data));
            // end email
            return back()->with('success','Mail has been sent to the vendor');
        }else{
            return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        } 
    }

    public function vendorForm($emp_code='')
    {
        $chk=\App\Employee::where('employee_code',$emp_code)->first();
        if($chk){
            $constitutions=Vendor::Constitution();
            $states=State::where('status','1')->pluck('name','id');
            $cities=City::where('status','1')->pluck('name','id');
            return view('employee/vendor/addVendorForm',compact('states','cities','constitutions','emp_code'));
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
        
    }

    public function saveVendorForm(Request $request,$emp_code=null)
    {
        $chk=\App\Employee::where('employee_code',$emp_code)->first();
        if($chk){
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:vendors,email',
                'password'=>'required|min:6',
                'phone'=>'required|numeric|digits:10',
                'state'=>'required|exists:states,id',
                'city'=>'required|exists:cities,id',
                'bank_account_type'=>'required|in:Saving,Current',
                'bank_account_number'=>'required',
                'ifsc'=>'required',
                'pan'=>'required|unique:vendors,pan|max:10|min:10',
                'specified_person'=>'',
                'address'=>'required',
                'location'=>'required',
                'specify_if_other'=>'',
                'gst'=>'',
                'constitution'=>'required|in:Sole Propritor,Partnership,Company,Trust,AOP,Others',
                'specify_if_other'=>'',
                'pan_file' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'cancel_cheque_file' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'term_and_condition'=>'required|in:1'
            ]);
            $pan_file = $this->pan_file;
            $cancel_cheque_file = $this->cancel_cheque_file;
            $time = $this->time;

            $data=new Vendor;
            $data->name=$request->name;
            $data->email=$request->email;
            $data->original_password=$request->password;
            $data->password=Hash::make($request->password);
            $data->phone=$request->phone;
            $data->state_id=$request->state;
            $data->state_ary=json_encode(State::where('id',$request->state)->select('id','name','slug')->first());
            $data->city_id=$request->city;
            $data->city_ary=json_encode(City::where('id',$request->city)->select('id','name','slug')->first());
            $data->bank_account_type=$request->bank_account_type;
            $data->bank_account_number=$request->bank_account_number;
            $data->ifsc=$request->ifsc;
            $data->pan=$request->pan;
            //$data->specified_person=$request->specified_person;
            $data->constitution=$request->constitution;
            $data->specify_if_other=$request->specify_if_other;
            $data->address=$request->address;
            $data->location=$request->location;
            $data->zip=$request->zip;
            $data->gst=$request->gst;
            $data->user_id=$chk->id;
                $data->user_ary=json_encode(Employee::employeeAry($chk->id));
            if($request->pan_file){
                $PanFileName=$time.'.'.$request->pan_file->extension();
                $data->pan_file=$pan_file.$PanFileName;
            }
            if($request->cancel_cheque_file){
                $CancelChequeFileName=$time.'.'.$request->cancel_cheque_file->extension();
                $data->cancel_cheque_file=$cancel_cheque_file.$CancelChequeFileName;
            }
            if($data->save()){
                $data->vendor_code=Helper::vendorUniqueNo($data->id);
                $data->save();
                if($request->pan_file){
                  $request->pan_file->move(public_path($pan_file),$PanFileName);
                }
                if($request->cancel_cheque_file){
                  $request->cancel_cheque_file->move(public_path($cancel_cheque_file),$CancelChequeFileName);
                }
                 // email confirmation with vendor code userid password 
                $vdata['logo'] = Setting::setting('dark_logo');
                $vdata['title'] = Setting::setting('title');
                $vdata['FromEmail'] = Setting::setting('email');
                $vdata['fromAddress'] = Setting::setting('address');
                $vdata['fromMobile'] = Setting::setting('mobile');
                $vdata['vendor_code'] = $data->vendor_code;
                $vdata['venodr_email'] = $data->email;
                $vdata['venodr_pswd'] = $data->original_password;
                Mail::to([$data->email])->send(new FormVendorConfMail($vdata));
                // end mail
                return redirect()->route('employee.formConfMsg',$data->vendor_code)->with('success', 'Vendor Request Form sent successfully !');
            }else{
                return redirect()->back()->with('error', 'Failed ! try again.');
            }
          }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }  
    }

    public function formConfMsg($value='')
    {
        $data=Vendor::where('vendor_code',$value)->first();
        if($data){
            return view('employee/vendor/formConfMsg',compact('data'));
            # code...
        }else{
            return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function changeVendorStatus(Request $request,$value)
    {
        $request->validate(['account_status'=>'required|in:2,3']);
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==8) {
            $vdata=Vendor::where('vendor_code',$value)->where('account_status','!=','3')->first();
            $vdata->approved_user_id=Auth::guard('employee')->user()->id;
            $vdata->approved_user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
            $vdata->account_status=$request->account_status;
            $vdata->account_status_comment=$request->account_status_comment;
            if($vdata->save()){
                //if ($vdata && $request->account_status=='3') {
                    $data['logo'] = Setting::setting('dark_logo');
                    $data['title'] = Setting::setting('title');
                    $data['FromEmail'] = Setting::setting('email');
                    $data['fromAddress'] = Setting::setting('address');
                    $data['fromMobile'] = Setting::setting('mobile');
                    $data['username'] = $vdata->email;
                    $data['password'] = $vdata->original_password;
                    $data['account_status'] = $vdata->account_status;
                    $data['account_status_comment'] = $vdata->account_status_comment;
                    Mail::to([$vdata->email,Setting::setting('email')])->send(new VendorApprovalMail($data));
               //}
                return redirect()->back()->with('success', 'Vendor request status changed successfully !');
            }else{
                return redirect()->back()->with('error', 'Failed ! try again.');
            }
        }else{
            return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function VendorExcel($value='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
            return view('employee/vendor/VendorExcel');
        }else{
            return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function editPendingVendor($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) &&  ($roleId==4 || $roleId==8)) {
            $constitutions=Vendor::Constitution();
            $states=State::where('status','1')->pluck('name','id');
            $cities=City::where('status','1')->pluck('name','id');
            $data=Vendor::where('vendor_code',$slug)->where('account_status','!=','3')->first();

            //dd($data);
            if($data){
                return view('employee/vendor/editPendingVendor',compact('data','states','cities','page','constitutions'));
            }else{
               return redirect()->route('employee.pendingEmpVendor')->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }
    public function updatePendingVendor(VendorRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && ($roleId==4 || $roleId==8)) {
            $pan_file = $this->pan_file;
            $cancel_cheque_file = $this->cancel_cheque_file;
            $time = $this->time;

            $data=Vendor::where('vendor_code',$slug)->where('account_status','!=','3')->first();
            if ($data) {
               $oldPanFile='';
               $pre_pan_file=public_path($data->pan_file);
                if (isset($data->pan_file)) {
                    
                     $oldPanFile=$data->pan_file;
                }
                $oldCancelCheque='';
                $pre_cancel_cheque_file=public_path($data->cancel_cheque_file);
                if (isset($data->cancel_cheque_file)) {
                    
                     $oldCancelCheque=$data->cancel_cheque_file;
                }
                $data->name=$request->name;
                $data->email=$request->email;
                $data->original_password=$request->password;
                $data->password=Hash::make($request->password);
                $data->phone=$request->phone;
                $data->state_id=$request->state;
                $data->state_ary=json_encode(State::where('id',$request->state)->select('id','name','slug')->first());
                $data->city_id=$request->city;
                $data->city_ary=json_encode(City::where('id',$request->city)->select('id','name','slug')->first());
                $data->bank_account_type=$request->bank_account_type;
                $data->bank_account_number=$request->bank_account_number;
                $data->ifsc=$request->ifsc;
                $data->pan=$request->pan;
                if($roleId==8){
                     $data->specified_person=$request->specified_person;
                }
                //$data->specified_person=$request->specified_person;
                $data->constitution=$request->constitution;
                $data->specify_if_other=$request->specify_if_other;
                $data->address=$request->address;
                $data->location=$request->location;
                $data->zip=$request->zip;
                $data->gst=$request->gst;
                $data->user_id=Auth::guard('employee')->user()->id;
                $data->user_ary=json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                if($request->pan_file){
                    $PanFileName=$time.'.'.$request->pan_file->extension();
                    $data->pan_file=$pan_file.$PanFileName;
                }
                if($request->cancel_cheque_file){
                    $CancelChequeFileName=$time.'.'.$request->cancel_cheque_file->extension();
                    $data->cancel_cheque_file=$cancel_cheque_file.$CancelChequeFileName;
                }
                if ($data->account_status!='3') {
                    $data->account_status= '1';
                }
                if($data->save()){
                    if($request->pan_file){
                        if(file_exists($pre_pan_file) && $oldPanFile){
                            unlink($pre_pan_file);
                        }
                        $request->pan_file->move(public_path($pan_file),$PanFileName); 
                    }
                    if($request->cancel_cheque_file){
                        if(file_exists($pre_cancel_cheque_file) && $oldCancelCheque){
                            unlink($pre_cancel_cheque_file);
                        }
                        $request->cancel_cheque_file->move(public_path($cancel_cheque_file),$CancelChequeFileName); 
                    }
                    
                    return redirect()->route('employee.pendingEmpVendor',($page > 1) ? 'page='.$page : '')->with('success', 'Update successfully !');
                    
                }else{
                    return redirect()->route('employee.vendors')->with('error', 'Failed ! try again.');
                }
            }else{
                return redirect()->back()->with('error', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
    }

    public function vendorPDF($value='')
    {
        $data['data']=Vendor::where('vendor_code',$value)->first();
        if ($data) {
            $pdf = PDF::loadView('employee.vendor.vendorPDF', $data);
            return $pdf->download('Vendor-'.date('d-m-Y').'.pdf');
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
        
    }
}
