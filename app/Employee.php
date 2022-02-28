<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;
class Employee extends Authenticatable
{
    use Notifiable;
    protected $table = 'employees'; 
    protected $guard = 'employee';

    protected $fillable=['name', 'email', 'password', 'original_password', 'mobile_code', 'mobile', 'phone', 'status', 'image', 'employee_code', 'tag', 'bank_account_type', 'bank_account_number', 'ifsc', 'pan', 'approver_manager', 'specified_person', 'address', 'location', 'zip', 'state_id', 'state_ary', 'city_id', 'city_ary', 'role_id', 'role_ary', 'user_id', 'user_ary'];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function EmpAssignProcess($value='')
    {
    	return $this->hasMany('\App\EmployeeAssignProcess','employees_id' );
    }

    public function role($value='')
    {
    	return $this->hasOne('\App\Role','id','role_id' );
    }

    public function state($value='')
    {
    	return $this->hasOne('\App\State','id','state_id')->select('id','name');
    }

    public function city($value='')
    {
    	return $this->hasOne('\App\City','id','city_id')->select('id','name');
    }

    public static function manager($value='')
    {
        if ($value) {
            return Employee::where('id',$value)->first();
        }else{
             return Employee::select(DB::raw('CONCAT(name, " ", employee_code) AS name, id'))
           ->where('role_id','5')->where('id','!=',Auth::user()->id)->pluck('name','id');
        }
    }
    
    public static function chkProccess($empId='',$assProId='')
    {
        //2 -> Employee / Contingent,3->Vendor Pay,5->Bulk Pay,6->Transfers
        $array=[];
        $data = Employee::where('id',$empId)->first();
        if ($data) {
           foreach ($data->EmpAssignProcess as $key => $value) {
               $array[] = $value->assignProcessData->id;
            } 
        }
        return in_array($assProId, $array);
        
    }

    public static function employee($value='')
    {
        if ($value) {
            return Employee::where('id',$value)->first();
        }else{
             return Employee::select(DB::raw('CONCAT(name, " ", employee_code) AS name, id'))
           ->where('role_id','4')->where('id','!=',Auth::user()->id)->pluck('name','id');
        }
    }

    public function bankAccount($value='')
    {
        return $this->hasMany('\App\EmployeeBankAccount','employees_id','id');
    }

    public static function employeeAry($value='')
    {
        return Employee::where('id',$value)->select('id', 'name', 'email',  'mobile_code', 'mobile', 'phone', 'employee_code', 'bank_account_type', 'bank_account_number', 'ifsc', 'pan', 'specified_person', 'address', 'location', 'zip', 'medical_welfare')->first();
    }
}
