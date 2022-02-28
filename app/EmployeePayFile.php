<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePayFile extends Model
{
    public function empReqDetail($value='')
    {
    	return $this->hasOne('\App\EmployeePay','id','emp_req_id');
    }
}
