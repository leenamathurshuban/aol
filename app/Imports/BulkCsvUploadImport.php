<?php

namespace App\Imports;

use App\BulkUpload;
use App\BulkCsvUpload;
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
use App\Helpers\Helper;

class BulkCsvUploadImport implements ToModel, WithStartRow,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable,SkipsFailures;
    /**
    * @param Collection $collection
    */
    function __construct($type = null,$id = null)
    {
    	$this->type = $type;
    	$this->id = $id;
    }
    public function startRow():int
    {
    	return 2;
    } 

    public function model(array $row)
    {
    	$data=BulkUpload::where(['status'=>1,'id'=>$this->id])->first();
    	if ($data && $this->type==1) {
    		$sdata = new BulkCsvUpload;
            $sdata->bulk_upload_id=$this->id;
            $sdata->bulk_upload_data=json_encode(['id'=>$data->id,'order_id'=>$data->order_id]);
    		$sdata->account_no=$row['account_no'];
    		$sdata->branch_code=$row['branch_code'];
    		$sdata->amt_date=$row['date'];
    		$sdata->dr_amount=$row['dr_amount'];
    		$sdata->cr_amount=$row['cr_amount'];
    		$sdata->refrence=$row['refrence'];
    		$sdata->description=$row['description'];
    		$sdata->pay_id=$row['pay_id'];
            $sdata->save();
            $sdata->order_id=Helper::bulkUploadvCsvUniqueNo($sdata->id);
            $sdata->save();
            return $sdata;
    	}else if ($data && $this->type==2) {
    		$sdata = new BulkCsvUpload;
            $sdata->bulk_upload_id=$this->id;
            $sdata->bulk_upload_data=json_encode(['id'=>$this->id,'order_id'=>$data->order_id]);
    		$sdata->account_no=$row['account_no'];
    		$sdata->branch_code=$row['branch_code'];
    		$sdata->amt_date=$row['date'];
    		$sdata->dr_amount=$row['dr_amount'];
    		$sdata->cr_amount=$row['cr_amount'];
    		$sdata->refrence=$row['refrence'];
    		$sdata->description=$row['description'];
    		$sdata->pay_id=$row['pay_id'];
            $sdata->save();
            $sdata->order_id=Helper::bulkUploadvCsvUniqueNo($sdata->id);
            $sdata->save();
            return $sdata;
    	}else if ($data && $this->type==3) {
            $sdata = new BulkCsvUpload;
            $sdata->bulk_upload_id=$this->id;
            $sdata->bulk_upload_data=json_encode(['id'=>$this->id,'order_id'=>$data->order_id]);
            $sdata->transaction_type=$row['transaction_type'];
            $sdata->debit_account_no=$row['debit_account_no'];
            $sdata->ifsc=$row['ifsc'];
            $sdata->beneficiary_account_no=$row['beneficiary_account_no'];
            $sdata->beneficiary_name=$row['beneficiary_name'];
            $sdata->amount=$row['amount'];
            $sdata->remarks_for_client=$row['remarks_for_client'];
            $sdata->remarks_for_beneficiary=$row['remarks_for_beneficiary'];
            $sdata->output_data=$row['output_data'];
            $sdata->save();
            $sdata->order_id=Helper::bulkUploadvCsvUniqueNo($sdata->id);
            $sdata->save();
            return $sdata;
        }

        //$data->vendor_code=Helper::vendorUniqueNo($data->id);
    }

    public function rules(): array
    {
        $valid='';
         // if ($row['constitution']=='Others') {
         //     $valid='required|min:50';
         // }
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