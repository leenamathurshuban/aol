<?php

namespace App\Imports;

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
use App\BulkUpload;
use App\BulkCsvUpload;
use App\Helpers\Helper;
class PaymentOfcBulkUploadAppvImport implements ToModel, WithStartRow,WithHeadingRow,WithValidation,SkipsOnFailure
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
        
        $data=BulkCsvUpload::where('order_id', $row['generated_id'])->count();
        $blkData=BulkUpload::where([ 'order_id' => $row['bulk_upload_generated_id' ],'status'=>5])->first();
    	if ($data && $blkData) {
            $data = BulkCsvUpload::where('order_id', $row['generated_id'])->get();
            foreach ($data as $key => $value) {
                $data = BulkCsvUpload::where('id',$value->id)->first();
                $data->transaction_id=$row['transaction_id'];
                $data->transaction_date=Helper::importDateInFormat($row['transaction_date']);
                $data->date_of_payment=Helper::importDateInFormat($row['date_of_payment']);
                $data->save();
            }
      
    		$blkData->status = 6;
    		$blkData->payment_ofc_id = Auth::guard('employee')->user()->id;
            $blkData->payment_ofc_ary = json_encode(Employee::where('id',Auth::guard('employee')->user()->id)->select('id','name','email','mobile','employee_code')->first());
            //$data->payment_ofc_comment = $request->comment;
            $blkData->date_of_payment=Helper::importDateInFormat($row['date_of_payment']);
            $blkData->save();
            return $data;
    	}else{
    		return [];
    	}

        //$data->vendor_code=Helper::vendorUniqueNo($data->id);
    }

    public function rules(): array
    {
        $valid='';
         // if ($row['constitution']=='Others') {
         //     $valid='required|min:50';
         // }
        return [
                'type_of_nature'=>'required|in:Bulk Upload',
                'generated_id'=>'required|exists:bulk_csv_uploads,order_id',
                'transaction_id'=>'required',
                'transaction_date'=>'required|date_format:d/m/Y',
                'date_of_payment'=>'required|date_format:d/m/Y'
        ];
    }
}
