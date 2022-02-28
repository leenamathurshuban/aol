<?php

namespace App\Imports;

/*use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
*/ 
use App\Employee;
use App\EmployeeAssignProcess;
use App\EmployeeBankAccount;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Auth;

class EmployeeImport implements ToModel, WithStartRow,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable,SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function startRow():int
    {
    	return 2;
    }
    public function model(array $row)
    {
    	$state=\App\State::select('id','name','slug')->where('name',$row['state'])->first();
        $state_ary=json_encode($state);
        $city=\App\City::select('id','name','slug')->where('name',$row['city'])->first();
        $city_ary=json_encode($city);
        $role =\App\Role::where('name',$row['role'])->select('id','name','slug')->first();
        $manager='0';
        if ($row['approver_manager_code']) {
            $manager=Employee::where('employee_code',$row['approver_manager_code'])->first()->id ?? '0';
        }
        
        $empData = new Employee;
        $empData->role_id=$role->id;
        $empData->role_ary=json_encode($role);
        $empData->name=$row['name'];
        $empData->employee_code=$row['employee_code'];
        $empData->email=$row['email'];
        $empData->original_password=$row['password'];
        $empData->password=Hash::make($row['password']);
        $empData->tag=$row['tag'];
        $empData->phone=$row['phone'];
        $empData->state_id=$state->id;
        $empData->state_ary=$state_ary;
        $empData->city_id=$city->id;
        $empData->city_ary=$city;
        $empData->bank_account_type=$row['bank_account_type'];
        $empData->bank_account_number=$row['account_number'];
        $empData->ifsc=$row['ifsc'];
        $empData->pan=$row['pan'];
        $empData->approver_manager=$manager;
        $empData->specified_person=$row['specified_person'];
        $empData->address=$row['address'];
        $empData->location=$row['location'];
        $empData->zip=$row['zip'];
        $empData->user_id=Auth::user()->id;
        $empData->user_ary=json_encode(\App\User::where('id',Auth::user()->id)->select('id','name','email','mobile')->first());
        $assign_process=explode(',', $row['assign_process']);
        $empData->medical_welfare=($row['medical_welfare']=='Yes') ? 'Yes' : '';
        if (count($assign_process) && $empData->save()) {
            if ($row['account_number']) {
                $bnk=new EmployeeBankAccount;
                $bnk->employees_id  = $empData->id;
                $bnk->bank_account_number = $row['account_number'];
                $bnk->ifsc = $row['ifsc'];
                $bnk->bank_name = $row['bank_name'];
                $bnk->branch_code = $row['branch_code'];
                $bnk->bank_account_holder = $row['bank_account_holder'];
                $bnk->branch_address = $row['branch_address'];
                $bnk->save();
            }
        	foreach ($assign_process as $key => $value) {
        		$assignId=\App\AssignProcess::where('name',$value)->select('id','name')->first()->id ?? '';
                if ($assignId) {
                    $subData=new EmployeeAssignProcess;
                    $subData->employees_id =$empData->id;
                    $subData->assign_processes_id  =$assignId;
                    $subData->save();
                }
        	}
        } 
        return $empData;
    }

    public function rules(): array
    {
        $valid='';
         // if ($row['constitution']=='Others') {
         //     $valid='required|min:50';
         // }
        return [
                	'role'=>'required|exists:roles,name',
                    'assign_process'=>'required|exists:assign_processes,name',//required|exists:assign_processes,name
                    'name'=>'required',
                    'employee_code'=>'required|unique:employees,employee_code',
                    'email'=>'required|email|unique:employees,email',
                    'password'=>'required|min:6',
                    'tag'=>'',
                    'phone'=>'required|numeric|digits:10',
                    'state'=>'required|exists:states,name',
                    'city'=>'required|exists:cities,name',
                    'bank_account_type'=>'required|in:Saving,Current',
                    'pan'=>'',
                    'approver_manager_code'=>'',
                    'specified_person'=>'required|in:Yes,No',
                    'address'=>'required',
                    'location'=>'required',
                    'zip'=>'required',
                    'medical_welfare'=>'in:Yes,No',
                    'account_number'=>'required',
                    'ifsc'=>'required',
                    'bank_name'=>'required',
                    'branch_code'=>'required',
                    'bank_account_holder'=>'required',
                    'branch_address'=>'required',
        ];
    }
}