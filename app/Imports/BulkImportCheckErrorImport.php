<?php

namespace App\Imports;

use App\BulkUpload;
use App\Employee;
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

class BulkImportCheckErrorImport implements ToModel, WithStartRow,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable,SkipsFailures;
    /**
    * @param Collection $collection
    */
    function __construct($type = null)
    {
    	 $this->type = $type;
    }
    public function startRow():int
    {
    	return 2;
    }

    public function model(array $row)
    {
    	
    	return [];
    	
    }

    public function rules(): array
    {
        $valid='';
        
        if ($this->type==1) {
        	return [
                'account_no'=>'required',
                'branch_code'=>'required',
                'date'=>'required|date_format:d/m/Y',
                'dr_amount'=>'required|numeric',
                'cr_amount'=>'required|numeric',
                'refrence'=>'required|numeric',
                'description'=>'required',
                'pay_id'=>'required'
        	];
        }
        if ($this->type==2) {
        	return [
                'account_no'=>'required',
                'branch_code'=>'required',
                'date'=>'required|date_format:d/m/Y',
                'dr_amount'=>'required|numeric',
                'cr_amount'=>'required|numeric',
                'refrence'=>'required|numeric',
                'description'=>'required',
                'pay_id'=>'required'
        	];
        }
        if ($this->type==3) {
            $type=\App\BulkUpload::transaction_type();
        	return [
                'transaction_type'=>'required|in:'.implode(',', $type),
                'debit_account_no'=>'required',
                'ifsc'=>'required',
                'beneficiary_account_no'=>'required',
                'beneficiary_name'=>'required',
                'amount'=>'required|numeric',
                'remarks_for_client'=>'required',
                'remarks_for_beneficiary'=>'required',
                'output_data'=>''
            ];
        }
        
    }
}
