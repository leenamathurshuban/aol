<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Employee;
use App\Invoice;
use App\WithoutPoInvoice;
use App\PurchaseOrder;
use App\InternalTransfer;
use App\EmployeePay;
use App\Bulkupload;
use App\BulkCsvUpload;
use App\Helpers\Helper;
use Auth;
class AdminTdsRequestExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($request_type=null,$from='',$to='',$arrays)
    {
    	$this->request_type = $request_type;
        $this->from = $from;
        $this->to = $to;

        $output = [];

        foreach ($arrays as $key => $array) {

              // store values for each row
            foreach ($array as $row) {
                if($key==0){

                    $output[] = [
                            $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'],
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->vendor_code ?? '',
                            json_decode($row['vendor_ary'])->pan ?? '',
                            $row['tds_month'] ?? '',
                            $row['amount'] ?? '',
                            $row['tds'].'%' ?? '',
                            $row['tds_amount'],
                            'PO Invoices'
                        ];
                }
                if ($key==1) {
                    
                    $output[] = [
                            $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'],
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->vendor_code ?? '',
                            json_decode($row['vendor_ary'])->pan ?? '',
                            $row['tds_month'] ?? '',
                            $row['amount'] ?? '',
                            $row['tds'].'%' ?? '',
                            $row['tds_amount'],
                            'Without PO Invoices'
                        ];
                }
                if($key==2){
                	
                    $output[] = [
                           $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'],
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            json_decode($row['pay_for_employee_ary'])->name ?? '',
                            json_decode($row['pay_for_employee_ary'])->employee_code ?? '',
                            json_decode($row['pay_for_employee_ary'])->pan ?? '',
                            $row['amount_requested'] ?? '',
                            $row['tds_month'] ?? '',
                            $row['tds'].'%' ?? '',
                            $row['tds_amount'],
                            'Employee Pay'
                        ];
                }

                
            }
        }
        //print_r($output);die();
        $this->collection = collect($output);
    }           
                    
    public function collection()
    {

        return $this->collection;
        
    }

    public function map($data) : array {
           // print_r($data);die();
            return $data;
       
    }
 
    public function headings(): array
    {
        return [
                    'Unique ID',
					'Payment Date',
					'Transaction Id',
					'Request Date',
					'Apex',
					'Vendor / Employee',
					'Code',
					'Pan',
					'TDS Section',
					'Amount',
					'TDS Rate',
					'TDS Amount',
					'Type of Nature'
                ];
        
    }

    public function dateFormate($value='')
    {
        return date('d/m/Y',strtotime($value));
    }
}
 
