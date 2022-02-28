<?php

namespace App\Exports;
use App\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class VendorExport implements FromCollection, WithMapping, WithHeadings
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
    		return Vendor::where('id','')->get();
    	}else{
    		return Vendor::with('state','city')->select('name','email','original_password','phone','state_id','city_id','bank_account_type','bank_account_number','ifsc','pan','specified_person','address','location','zip','constitution','gst','specify_if_other','vendor_code')->get();
    	}
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
            $vendor->ifsc,
            $vendor->pan,
            //$vendor->specified_person,
            $vendor->address,
            $vendor->location,
            $vendor->zip,
            $vendor->constitution,
            $vendor->gst,
            $vendor->specify_if_other,
            $vendor->vendor_code
        ] ;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password',
            'Phone',
            'State',
            'City',
            'Bank account type',
            'Account number',
            'IFSC',
            'Pan',
            //'Specified person',
            'Address',
            'Location',
            'Zip',
            'Constitution',
            'GST',
            'Specify if other',
            'Vendor Code'
            
        ];
    }
}