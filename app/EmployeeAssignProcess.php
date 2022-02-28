<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAssignProcess extends Model
{
    public function assignProcessData($value='')
    {
    	return $this->hasOne('\App\AssignProcess','id' ,'assign_processes_id');
    }
}
