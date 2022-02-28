<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\VendorRequest;
use App\Http\Requests\VendorFormRequest;
use App\State;
use App\City; 
use App\User;
use App\Vendor;
use Auth;
use App\Exports\VendorExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VendorImport;
use App\Setting;
use Mail;
use App\Mail\VendorFormMail;
use App\Mail\VendorApprovalMail;
class VendorController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->pan_file='vendor/pan_file/';
        $this->cancel_cheque_file='vendor/cancel_cheque_file/';
        $this->time = time().rand(111111,999999);
    }
    public function index($name='')
    {
        extract($_GET);
        $states=State::pluck('name','id');
        $cities=City::pluck('name','id');
        $data=Vendor::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        
        $total=$data->count();
        $data=$data->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
        $currentPage=$data->currentPage();
       
    	return view('admin/vendor/list',compact('data','name','page','total','states','cities','currentPage'));

    }

    public function add($value='')
    {
        $constitutions=Vendor::Constitution();
        $states=State::where('status','1')->pluck('name','id');
        $cities=City::where('status','1')->pluck('name','id');
    	return view('admin/vendor/add',compact('states','cities','constitutions'));
    }
    public function edit($slug,$page)
    {
        $constitutions=Vendor::Constitution();
        $states=State::where('status','1')->pluck('name','id');
        $cities=City::where('status','1')->pluck('name','id');
    	$data=Vendor::where('id',$slug)->first();

        //dd($data);
        if($data){
            return view('admin/vendor/edit',compact('data','states','cities','page','constitutions'));
        }else{
           return redirect()->route('admin.vendors')->with('error', 'Failed ! try again.');
        }
    }

    public function insert(VendorRequest $request,$slug=null)
    {
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
        $data->specified_person=$request->specified_person;
        $data->constitution=$request->constitution;
        $data->specify_if_other=$request->specify_if_other;
        $data->address=$request->address;
        $data->location=$request->location;
        $data->zip=$request->zip;
        $data->gst=$request->gst;
        $data->user_id=Auth::user()->id;
        $data->user_ary=json_encode(User::where('id',Auth::user()->id)->select('id','name','email','mobile')->first());
        if($request->pan_file){
            $PanFileName=$time.'.'.$request->pan_file->extension();
            $data->pan_file=$pan_file.$PanFileName;
        }
        if($request->cancel_cheque_file){
            $CancelChequeFileName=$time.'.'.$request->cancel_cheque_file->extension();
            $data->cancel_cheque_file=$cancel_cheque_file.$CancelChequeFileName;
        }
    	if($data->save()){
            if($request->pan_file){
              $request->pan_file->move(public_path($pan_file),$PanFileName);
            }
            if($request->cancel_cheque_file){
              $request->cancel_cheque_file->move(public_path($cancel_cheque_file),$CancelChequeFileName);
            }
    		return redirect()->route('admin.vendors')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.vendors')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(VendorRequest $request,$slug=null,$page=null)
    {
        $pan_file = $this->pan_file;
        $cancel_cheque_file = $this->cancel_cheque_file;
        $time = $this->time;

        $data=Vendor::where('id',$slug)->first();
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
            $data->specified_person=$request->specified_person;
            $data->constitution=$request->constitution;
            $data->specify_if_other=$request->specify_if_other;
            $data->address=$request->address;
            $data->location=$request->location;
            $data->zip=$request->zip;
            $data->gst=$request->gst;
            $data->user_id=Auth::user()->id;
            $data->user_ary=json_encode(User::where('id',Auth::user()->id)->select('id','name','email','mobile')->first());
            if($request->pan_file){
                $PanFileName=$time.'.'.$request->pan_file->extension();
                $data->pan_file=$pan_file.$PanFileName;
            }
            if($request->cancel_cheque_file){
                $CancelChequeFileName=$time.'.'.$request->cancel_cheque_file->extension();
                $data->cancel_cheque_file=$cancel_cheque_file.$CancelChequeFileName;
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
               return redirect()->route('admin.vendors',($page > 1) ? 'page='.$page : '')->with('success', 'Update successfully !');
            }else{
                return redirect()->route('admin.vendors')->with('error', 'Failed ! try again.');
            }
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }
  
    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
        $data=Vendor::where('id',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->route('admin.vendors')->with('success', 'Status changed successfully !');
        }else{
           return redirect()->route('admin.vendors')->with('failed', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $pan_file = $this->pan_file;
        $cancel_cheque_file = $this->cancel_cheque_file;

        $data=Vendor::where('id',$slug)->first();
        if($data->delete()){
            return redirect()->route('admin.vendors')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.vendors')->with('failed', 'Failed ! try again.');
        }
    }

    public function getCityByState(Request $request)
    {
        $states=State::where('id',$request->sId)->first();
        if($states){
            $cities=City::where('state_id',$request->sId)->pluck('name','id');
            $type=$request->type;
            return view('admin/vendor/ajax',compact('cities','type','states'));
        }
    }

    public function getVendorDetail($value='')
    {
        $data=Vendor::where('id',$_POST['slug'])->first();
        if($data){
            $type='viewDetail';
            return view('admin/vendor/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function export($slug=null) 
    {
        return Excel::download(new VendorExport($slug), 'venodr.xlsx');
    }

    public function import(Request $request)
    {
        $file = new VendorImport();
        $file->import(request()->file('bulk_vendor_data'));

        foreach ($file->failures() as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                if($failure->errors() && !empty($failure->errors())) {
                    return redirect()->back()->with('success', 'Vendor data imported Successfully')->with('sheeterror', $failure);
                }
            }
            return redirect()->back()->with('success', 'Vendor data imported Successfully');
        

         //Excel::import(new VendorImport,request()->file('bulk_vendor_data'));
        //return redirect()->back();
    }

    public function VendorFormLink($value='')
    {
        return view('admin/vendor/VendorFormLink');
    }

    public function VendorFormMail(Request $request)
    {
        $request->validate(['email'=>'required|email','subject'=>'required','message'=>'required']);
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
                    return back()->with('success','Mail has been forward to vendor');
    }

    public function vendorForm($value='')
    {
        $constitutions=Vendor::Constitution();
        $states=State::where('status','1')->pluck('name','id');
        $cities=City::where('status','1')->pluck('name','id');
        return view('admin/vendor/addVendorForm',compact('states','cities','constitutions'));
    }

    public function saveVendorForm(Request $request,$slug=null)
    {
        $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:vendors,email|unique:vendor_requests,email',
                'password'=>'required|min:6',
                'phone'=>'required|numeric|digits:10',
                'state'=>'required|exists:states,id',
                'city'=>'required|exists:cities,id',
                'bank_account_type'=>'required|in:Saving,Current',
                'bank_account_number'=>'required',
                'ifsc'=>'required',
                'pan'=>'required|max:10|min:10|unique:vendors,pan',
                'specified_person'=>'',
                'address'=>'required',
                'location'=>'',
                'specify_if_other'=>'',
                'gst'=>'',
                'constitution'=>'required|in:Sole Propritor,Partnership,Company,Trust,AOP,Others',
                'specify_if_other'=>''
            ]);
        $data=new \App\VendorRequest;
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
        $data->specified_person=$request->specified_person;
        $data->constitution=$request->constitution;
        $data->specify_if_other=$request->specify_if_other;
        $data->address=$request->address;
        $data->location=$request->location;
        $data->zip=$request->zip;
        $data->gst=$request->gst;
        if($data->save()){
            return redirect()->back()->with('success', 'Vendor Request Form Submit successfully !');
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }

    public function VendorFormList($name='')
    {
        extract($_GET);
        $states=State::pluck('name','id');
        $cities=City::pluck('name','id');
        $data=\App\VendorRequest::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        $currentPage=$data->currentPage();
       
        return view('admin/vendor/VendorFormList',compact('data','name','page','total','states','cities','currentPage'));

    }

    public function editVendorRequest($value='',$page=null)
    {
       $constitutions=Vendor::Constitution();
        $states=State::where('status','1')->pluck('name','id');
        $cities=City::where('status','1')->pluck('name','id');
        $data=\App\VendorRequest::where('id',$value)->first();
        //dd($data);
        if($data){
            return view('admin/vendor/editVendorRequest',compact('data','states','cities','page','constitutions'));
        }else{
           return redirect()->route('admin.vendors')->with('error', 'Failed ! try again.');
        }
    }

    public function updateVendorRequest(Request $request,$slug='',$page=null)
    {
        $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:vendors,email|unique:vendor_requests,email,'.$slug,
                'password'=>'required|min:6',
                'phone'=>'required|numeric|digits:10',
                'state'=>'required|exists:states,id',
                'city'=>'required|exists:cities,id',
                'bank_account_type'=>'required|in:Saving,Current',
                'bank_account_number'=>'required',
                'ifsc'=>'required',
                'pan'=>'',
                'specified_person'=>'',
                'address'=>'required',
                'location'=>'',
                'specify_if_other'=>'',
                'gst'=>'',
                'constitution'=>'required|in:Sole Propritor,Partnership,Company,Trust,AOP,Others',
                'specify_if_other'=>''
            ]);
        $data=\App\VendorRequest::where('id',$slug)->first();
        if ($data) {
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
            $data->specified_person=$request->specified_person;
            $data->constitution=$request->constitution;
            $data->specify_if_other=$request->specify_if_other;
            $data->address=$request->address;
            $data->location=$request->location;
            $data->zip=$request->zip;
            $data->gst=$request->gst;
            if($data->save()){
               return redirect()->route('admin.VendorFormList',($page > 1) ? 'page='.$page : '')->with('success', 'Updated successfully !');
            }else{
                return redirect()->back()->with('error', 'Failed ! try again.');
            }
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }

    public function changeVendorStatus($value='')
    {
        $vdata=\App\VendorRequest::where('id',$value)->first();
        if ($vdata) {
            $data=new Vendor;
            $data->name=$vdata->name;
            $data->email=$vdata->email;
            $data->original_password=$vdata->original_password;
            $data->password=Hash::make($vdata->original_password);
            $data->phone=$vdata->phone;
            $data->state_id=$vdata->state_id;
            $data->state_ary=$vdata->state_ary;
            $data->city_id=$vdata->city_id;
            $data->city_ary=$vdata->city_ary;
            $data->bank_account_type=$vdata->bank_account_type;
            $data->bank_account_number=$vdata->bank_account_number;
            $data->ifsc=$vdata->ifsc;
            $data->pan=$vdata->pan;
            $data->specified_person=$vdata->specified_person;
            $data->constitution=$vdata->constitution;
            $data->specify_if_other=$vdata->specify_if_other;
            $data->address=$vdata->address;
            $data->location=$vdata->location;
            $data->zip=$vdata->zip;
            $data->gst=$vdata->gst;
            $data->user_id=Auth::user()->id;
            $data->user_ary=json_encode(User::where('id',Auth::user()->id)->select('id','name','email','mobile')->first());
            if($data->save()){
                $vdata->delete();
                //email
                    $data['logo'] = Setting::setting('dark_logo');
                    $data['title'] = Setting::setting('title');
                    $data['FromEmail'] = Setting::setting('email');
                    $data['fromAddress'] = Setting::setting('address');
                    $data['fromMobile'] = Setting::setting('mobile');
                    $data['username'] = $data->email;
                    $data['password'] = $data->original_password;
                    Mail::to([$data->email])->send(new VendorApprovalMail($data));
            // end email
                return redirect()->back()->with('success', 'Vendor approved successfully !');
            }else{
                return redirect()->back()->with('error', 'Failed ! try again.');
            }
        }else{
            return redirect()->back()->with('failed', 'Failed ! Invalid request.');
        }
    }

    public function removeVendorRequest($value='')
    {
        $data=\App\VendorRequest::where('id',$value)->first();
        if($data->delete()){
            return redirect()->back()->with('success', 'Removed successfully !');
        }else{
           return redirect()->back()->with('failed', 'Failed ! try again.');
        }
    }

    public function getVendorRequestDetail($value='')
    {
        $data=\App\VendorRequest::where('id',$_POST['slug'])->first();
        if($data){
            $type='viewVendorRequestDetail';
            return view('admin/vendor/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function VendorExcel($value='')
    {
        return view('admin/vendor/VendorExcel');
    }

}
