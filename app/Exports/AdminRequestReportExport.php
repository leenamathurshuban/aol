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
class AdminRequestReportExport implements FromCollection, WithMapping, WithHeadings
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

            
            foreach ($array as $row) {
                if($key==0 || $key==1){
                    $inv_type=($key==0) ? 'PO Invoices' : 'Without PO Invoices';
                    $output[] = [
                            $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'],
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            $row['tds_payable'] ?? '',
                            $inv_type,
                            \App\Invoice::invoiceStatus($row['invoice_status']),
                            Helper::onlyDate($row['created_at'])
                        ];
                }
                if ($key==2) {
                    
                    $output[] = [
                            $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'],
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            $row['amount_requested'] ?? '',
                            'Employee Pay',
                            \App\EmployeePay::requestStatus($row['status']),
                            Helper::onlyDate($row['created_at'])
                        ];
                }

                if ($key==3) {
                    
                    $output[] = [
                            $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'] ?? '',
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            $row['net_payable'] ?? '',
                            'Purchase Order',
                            PurchaseOrder::orderStatusView($row['account_status']),
                            Helper::onlyDate($row['created_at'])
                        ];
                }

                if ($key==4) {
                    
                    $output[] = [
                            $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'] ?? '',
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            $row['amount'] ?? '',
                            'Internal Transfer',
                            InternalTransfer::requestStatus($row['status']),
                            Helper::onlyDate($row['created_at'])
                        ];
                }

                if ($key==5) {
                    
                    $output[] = [
                            $row['order_id'],
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'] ?? '',
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            BulkUpload::totCSVAmount($row['payment_type'],$row['id']) ?? '',
                            'Bulk Upload',
                            BulkUpload::requestStatus($row['status']),
                            Helper::onlyDate($row['created_at'])
                        ];
                }
            }
            
        }
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
                    'Amount',
                    'Type of Nature',
                    'Status',
                    'Date'
                ];
    }

    public function dateFormate($value='')
    {
        return date('d/m/Y',strtotime($value));
    }
}
 
