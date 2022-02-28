<?php

namespace App\Imports;

use App\Invoice;
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
class PaymentOfcInvAppvImport implements ToModel, WithStartRow,WithHeadingRow,WithValidation,SkipsOnFailure
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
    	$data=Invoice::where(['invoice_status'=>5,'order_id'=>$row['generated_id']])->first();
    	if ($data) {
            $data->transaction_id=$row['transaction_id'];
            $data->transaction_date=Helper::importDateInFormat($row['transaction_date']);
    		$data->invoice_status = 6;
    		$data->payment_ofc_id = Auth::guard('employee')->user()->id;
			$data->payment_ofc_ary = json_encode(Employee::where('id',Auth::guard('employee')->user()->id)->select('id','name','email','mobile','employee_code')->first());
			//$data->payment_ofc_comment = $request->invoice_status_comment[$key];
			$data->payment_date=Helper::importDateInFormat($row['date_of_payment']);
            //$data->payment_ofc_comment = $request->comment;
            $data->date_of_payment=Helper::importDateInFormat($row['date_of_payment']);
            $data->save();
            return $data;
    	}else{
    		return [];
    	}

    }

    public function rules(): array
    {
        $valid='';
        return [
                'type_of_nature'=>'required|in:PO Invoice',
                'generated_id'=>'required|exists:invoices,order_id',
                'transaction_id'=>'required',
                'transaction_date'=>'required|date_format:d/m/Y',
                'date_of_payment'=>'required|date_format:d/m/Y'
        ];
    }
}
