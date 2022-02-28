<?php

namespace App\Exports;
use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class EmployeeExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($format = null)
    {
    	$this->format = $format;
    }
    public function collection()
    {
    	if ($this->format=='format') {
    		return Employee::where('id','')->get();
    	}else{
    		return Employee::with('EmpAssignProcess.assignProcessData','role','state','city')->select('role_id','id','name','employee_code','email','original_password','tag','phone','state_id','city_id','bank_account_type','bank_account_number','ifsc','pan','approver_manager','specified_person','address','location','zip','medical_welfare')->get();
    	}
    }

    public function map($employee) : array {
    	$assign=[];
        $manager='';
    	if ($employee->EmpAssignProcess) {
    		foreach ($employee->EmpAssignProcess as $ckey => $cval) {
    			$assign[]=$cval->assignProcessData->name;
    		}
    	}else{
            foreach (\App\AssignProcess::get() as $ckey => $cval) {
                $assign[]=$cval->name;
            }
        }
        if ($employee->approver_manager) {
            $manager=Employee::manager($employee->approver_manager)->employee_code;
        }
        return [
            $employee->role->name,
            implode(',',$assign),
            $employee->name,
            $employee->employee_code,
            $employee->email,
            $employee->original_password,
            $employee->tag,
            $employee->phone,
            $employee->state->name,
            $employee->city->name,
            $employee->bank_account_type,
            $employee->pan,
            $manager,
            $employee->specified_person,
            $employee->address,
            $employee->location,
            $employee->zip,
            $employee->medical_welfare,
            $employee->bank_account_number,
            $employee->ifsc,
        ] ;
    }

    public function headings(): array
    {
        return [
            'Role',
            'Assign process',
            'Name',
            'Employee code',
            'Email',
            'Password',
            'Tag',
            'Phone',
            'State',
            'City',
            'Bank account type',
            'Pan',
            'Approver manager code',
            'Specified person',
            'Address',
            'Location',
            'Zip',
            'Medical welfare',
            'Account number',
            'IFSC',
            'Bank Name',
            'Branch Code',
            'Bank Account Holder',
            'Branch Address'
        ];
    }
}
