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
class AdminInvoicePaymentRequestExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($from='',$to='',$arrays)
    {
        $this->from = $from;
        $this->to = $to;

        $output = [];

        foreach ($arrays as $key => $array) {

              // store values for each row
            foreach ($array as $row) {
                if($key==0){
                	$bnk='';
                	if($row['form_by_account']){
                        $item=json_decode($row['form_by_account']);
                            $bnk=$item->bank_account; 
                     }

                    $output[] = [
                            $row['order_id'],
                            'PO Invoices',
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'],
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->vendor_code ?? '',
                            $row['invoice_number'],
                            Helper::onlyDate($row['invoice_date']) ?? '',
                            $row['amount'] ?? '',
                            $row['invoice_amount'] ?? '',
                            $row['tds'].'%' ?? '',
                            $row['tds_amount'],
                            $row['tds_payable'],
                            $bnk
                        ];
                }
                if ($key==1) {
                    $bnk='';
                	if($row['form_by_account']){
                        $item=json_decode($row['form_by_account']);
                            $bnk=$item->bank_account; 
                     }
                    $output[] = [
                            $row['order_id'],
                            'Without PO Invoices',
                            ($row['date_of_payment']) ? Helper::onlyDate($row['date_of_payment']) : 'Not updated',
                            $row['transaction_id'],
                            Helper::onlyDate($row['created_at']), 
                            json_decode($row['apexe_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->vendor_code ?? '',
                            $row['invoice_number'],
                            Helper::onlyDate($row['invoice_date']) ?? '',
                            $row['amount'] ?? '',
                            $row['invoice_amount'] ?? '',
                            $row['tds'].'%' ?? '',
                            $row['tds_amount'],
                            $row['tds_payable'],
                            $bnk
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
            return $data;
    }
 
    public function headings(): array
    {
        return [
                    'Payment Unique ID',
					'Inv.Type',
					'Payment Date',
					'Transaction Id',
					'Request Date',
					'Apex',
					'Vendor',
					'Code',
					'Inv.No.',
					'Inv.Date',
					'Amount',
					'Inv.AMT.',
					'TDS%',
					'TDS Amount',
					'Net Paid Amount',
					'Bank A/C'
                ];
        
    }

    public function dateFormate($value='')
    {
        return date('d/m/Y',strtotime($value));
    }
}
