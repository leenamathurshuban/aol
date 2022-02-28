<?php

namespace App\Exports;
use App\BulkUpload;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class BulkUploadExport implements FromCollection, WithMapping, WithHeadings
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
        //if ($this->format=='within' || $this->format=='outside') {
    		return BulkUpload::where('id','')->get();
    	//}
    }

    public function map($vendor) : array {
    	
        return [
            $vendor->name,
            $vendor->email,
            $vendor->original_password,
            $vendor->phone,
            $vendor->state->name,
            $vendor->city->name,
            $vendor->bank_account_type,
            $vendor->bank_account_number,
        ] ;
    }

    public function headings(): array
    {
    	if ($this->format=='within') {
    		return [
	            'Account No',
	            'Branch Code',
	            'Date',
	            'Dr Amount',
	            'Cr Amount',
	            'Refrence',
	            'Description',
	            'Pay Id'
	        ];
    	}
    	if ($this->format=='outside') {
    		return [
	            'Account No',
	            'Branch Code',
	            'Date',
	            'Dr Amount',
	            'Cr Amount',
	            'Refrence',
	            'Description',
	            'Pay Id'
	        ];
    	}
    	if ($this->format=='combined') {
    		return [
                'Transaction Type',
                'Debit Account No',
                'IFSC',
                'Beneficiary Account No',
                'Beneficiary Name',
                'Amount',
                'Remarks For Client',
                'Remarks For Beneficiary',
                'Output Data'
            ];
    	}
        
    }
}

