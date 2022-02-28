<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Illuminate\support\Str;
use App\State;
use App\City; 
use App\User;
use App\Employee;
use App\Role;
use App\AssignProcess;
use App\EmployeeAssignProcess;
use Auth;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;
use App\EmployeeBankAccount;
class EmployeeController extends Controller
{ 
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='',$role='')
    {
        extract($_GET);
        $states=State::pluck('name','id');
        $cities=City::pluck('name','id');
        $data=Employee::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%")->orWhere('employee_code', 'LIKE', "%$name%");
        }
        if(isset($role) && !empty($role)){
            $roleDT=Role::where('slug',$role)->first();
             $data->where('role_id',$roleDT->id ?? '0');
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
        $currentPage=$data->currentPage();
        $roles=Role::where('status','1')->pluck('name','slug');
    	return view('admin/employee/list',compact('data','name','page','total','states','cities','currentPage','roles','role'));
 
    }

    public function add($value='')
    {
        $roles=Role::where('status','1')->pluck('name','id');
        $AssignProcess=AssignProcess::where('status','1')->pluck('name','id');
        $states=State::where('status','1')->pluck('name','id');
        $cities=City::where('status','1')->pluck('name','id');
        $managers=Employee::manager();
    	return view('admin/employee/add',compact('states','cities','roles','AssignProcess','managers'));
    }
    public function edit($slug,$page)
    {
        $roles=Role::where('status','1')->pluck('name','id');
        $AssignProcess=AssignProcess::where('status','1')->pluck('name','id');
        $states=State::where('status','1')->pluck('name','id');
        $cities=City::where('status','1')->pluck('name','id');
    	$data=Employee::where('employee_code',$slug)->first();

        $EmpAssignProcess=EmployeeAssignProcess::where('employees_id',$data->id);
        $empAsAry=[];
        if ($EmpAssignProcess->count()) {
            foreach ($EmpAssignProcess->get() as $key => $value) {
                $empAsAry[]=$value->assign_processes_id ;
            }
        }
        //dd($data);
        $managers=Employee::manager();
        if($data){
            return view('admin/employee/edit',compact('data','states','cities','page','roles','AssignProcess','empAsAry','managers'));
        }else{
           return redirect()->route('admin.employees')->with('error', 'Failed ! try again.');
        }
    }

    public function insert(EmployeeRequest $request,$slug=null)
    {
    	$data=new Employee;
        $data->role_id=$request->role;
        $data->role_ary=json_encode(Role::where('id',$request->role)->select('id','name','slug')->first());
        $data->name=$request->name;
        $data->employee_code=$request->employee_code;
        $data->email=$request->email;
        $data->original_password=$request->password;
        $data->password=Hash::make($request->password);
        $data->tag=$request->tag;
        $data->phone=$request->phone;
    	$data->state_id=$request->state;
        $data->state_ary=json_encode(State::where('id',$request->state)->select('id','name','slug')->first());
        $data->city_id=$request->city;
        $data->city_ary=json_encode(City::where('id',$request->city)->select('id','name','slug')->first());
        $data->bank_account_type=$request->bank_account_type;
        //$data->bank_account_number=$request->bank_account_number;
        //$data->ifsc=$request->ifsc;
        $data->pan=$request->pan;
        $data->approver_manager=$request->approver_manager ?? '0';
        $data->specified_person=$request->specified_person;
        $data->address=$request->address;
        $data->location=$request->location;
        $data->zip=$request->zip;
        $data->user_id=Auth::user()->id;
        $data->user_ary=json_encode(User::where('id',Auth::user()->id)->select('id','name','email','mobile')->first());
        $data->medical_welfare=$request->medical_welfare ?? 'No';
    	if($data->save()){
            if ($request->assign_process) {
                foreach ($request->assign_process as $key => $value) {
                    $subData=new EmployeeAssignProcess;
                    $subData->employees_id =$data->id;
                    $subData->assign_processes_id  =$value;
                    $subData->save();
                }
            }
            if ($request->bank_account_number) {
                foreach ($request->bank_account_number as $key => $value) {
                    $bnk=new EmployeeBankAccount;
                    $bnk->employees_id  = $data->id;
                    $bnk->bank_account_number = $value;
                    $bnk->ifsc = $request->ifsc[$key];
                    $bnk->bank_name = $request->bank_name[$key];
                    $bnk->branch_code = $request->branch_code[$key];
                    $bnk->save();
                }
            }
    		return redirect()->route('admin.employees')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.employees')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(EmployeeRequest $request,$slug=null,$page=null)
    {
       
        $data=Employee::where('employee_code',$slug)->first();
        if ($data) {
            $data->role_id=$request->role;
            $data->role_ary=json_encode(Role::where('id',$request->role)->select('id','name','slug')->first());
            $data->name=$request->name;
            $data->employee_code=$request->employee_code;
            $data->email=$request->email;
            if ($request->password) {
                $data->original_password=$request->password;
                $data->password=Hash::make($request->password);
            }
            $data->tag=$request->tag;
            $data->phone=$request->phone;
            $data->state_id=$request->state;
            $data->state_ary=json_encode(State::where('id',$request->state)->select('id','name','slug')->first());
            $data->city_id=$request->city;
            $data->city_ary=json_encode(City::where('id',$request->city)->select('id','name','slug')->first());
            $data->bank_account_type=$request->bank_account_type;
            //$data->bank_account_number=$request->bank_account_number;
            //$data->ifsc=$request->ifsc;
            $data->pan=$request->pan;
            $data->approver_manager=$request->approver_manager ?? '0';
            $data->specified_person=$request->specified_person;
            $data->address=$request->address;
            $data->location=$request->location;
            $data->zip=$request->zip;
            $data->user_id=Auth::user()->id;
            $data->user_ary=json_encode(User::where('id',Auth::user()->id)->select('id','name','email','mobile')->first());
            $data->medical_welfare=$request->medical_welfare ?? 'No';
            if($data->save()){
                if ($request->assign_process) {
                    EmployeeAssignProcess::where('employees_id',$data->id)->delete();
                    foreach ($request->assign_process as $key => $value) {
                        $subData=new EmployeeAssignProcess;
                        $subData->employees_id =$data->id;
                        $subData->assign_processes_id  =$value;
                        $subData->save();
                    }
                }
                if ($request->bank_account_number) {
                    EmployeeBankAccount::where('employees_id',$data->id)->delete();
                    foreach ($request->bank_account_number as $key => $value) {
                        $bnk=new EmployeeBankAccount;
                        $bnk->employees_id  = $data->id;
                        $bnk->bank_account_number = $value;
                        $bnk->ifsc = $request->ifsc[$key];
                        $bnk->bank_name = $request->bank_name[$key];
                        $bnk->branch_code = $request->branch_code[$key];
                        $bnk->save();
                    }
                }
               return redirect()->route('admin.employees',($page > 1) ? 'page='.$page : '')->with('success', 'Update successfully !');
            }else{
                return redirect()->route('admin.employees')->with('error', 'Failed ! try again.');
            }
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }
  
    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
        $data=Employee::where('employee_code',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->route('admin.employees')->with('success', 'Status changed successfully !');
        }else{
           return redirect()->route('admin.employees')->with('failed', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $data=Employee::where('employee_code',$slug)->first();
        if($data->delete()){
            return redirect()->route('admin.employees')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.employees')->with('failed', 'Failed ! try again.');
        }
    }

    public function getCityByState(Request $request)
    {
        $states=State::where('id',$request->sId)->first();
        if($states){
            $cities=City::where('state_id',$request->sId)->pluck('name','id');
            $type=$request->type;
            return view('admin/employee/ajax',compact('cities','type','states'));
        }
    }

    public function getEmployeesDetail($value='')
    {
        $data=Employee::with('EmpAssignProcess.assignProcessData','role')->where('employee_code',$_POST['slug'])->first();
        if($data){
            $type='viewDetail';
            return view('admin/employee/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function export($slug=null) 
    {
        return Excel::download(new EmployeeExport($slug), 'employee.xlsx');
    }

    public function import(Request $request)
    {
        $file = new EmployeeImport();
        $file->import(request()->file('bulk_employee_data'));
        foreach ($file->failures() as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                if($failure->errors() && !empty($failure->errors())) {
                    return redirect()->back()->with('success', 'Employee data imported Successfully')->with('sheeterror', $failure);
                }
            }
            return redirect()->back()->with('success', 'Employee data imported Successfully');
         //Excel::import(new VendorImport,request()->file('bulk_vendor_data'));
        //return redirect()->back();
    }

    public function EmployeeExcel($value='')
    {
        return view('admin/employee/EmployeeExcel');
    }
}
