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
use Auth;
class EmployeeAllRequestExport implements FromCollection, WithMapping, WithHeadings
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

            // get headers for current dataset
            //$output[] = array_keys($array[0]);
            if($key==0){
                   $output[] = [
                    'Invoices Generated Id',
                    'Vendor Name',
                    'Vendor Pan',
                    'Invoice Amount',
                    'TDS Section',
                    'TDS',
                    'TDS Amount',
                    'Date Of Payment'
                ];
            }
            if($key==1){
                $output[] = [
                    'Without PO Invoices Generated Id',
                    'Vendor Name',
                    'Vendor Pan',
                    'Invoice Amount',
                    'TDS Section',
                    'TDS',
                    'TDS Amount',
                    'Date Of Payment'
                ];
            }
            if($key==2){
                $output[] = [
                    'Employee Pay Generated Id',
                    'Nature Of Claim',
                    'For Emopyee',
                    'For Emopyee Code',
                    'TDS',
                    'TDS Amount',
                    'TDS Section',
                    'Requested Amount',
                    'Approved Amount',
                    'Date Of Payment'
                    ];
            }
          
              // store values for each row
            foreach ($array as $row) {
                if($key==0 || $key==1){
                    $output[] = [
                            $row['order_id'],
                            json_decode($row['vendor_ary'])->name ?? '',
                            json_decode($row['vendor_ary'])->pan ?? '',
                            $row['invoice_amount'] ?? '',
                            $row['tds_month'],
                            $row['tds'].'%',
                            $row['tds_amount'],
                            ($row['date_of_payment']) ? $this->dateFormate($row['date_of_payment']) : ''
                        ];
                }
                if ($key==2) {
                    $item=json_decode($row['item_detail']);
                    if(isset($item->medical->pay_to) && $item->medical->pay_to=='Pay to Hospital'){
                        //$bnkName=$item->medical->bank_name ?? '';
                        $bnkAccNumber=$item->medical->bank_account_number ?? '';
                        $ifsc=$item->medical->ifsc ?? '';
                        $pan=$item->medical->pan ?? '';
                    }else{
                        //$bnkName=$item->medical->bank_name ?? '';
                        $bnkAccNumber=$row['bank_account_number'] ?? '';
                        $ifsc=$row['ifsc'] ?? '';
                        $pan=$row['pan'] ?? '';
                    }
                    $output[] = [
                            $row['order_id'],
                            json_decode($row['nature_of_claim_ary'])->name ?? '',
                            json_decode($row['pay_for_employee_ary'])->name ?? '',
                            json_decode($row['pay_for_employee_ary'])->employee_code ?? '',
                            $row['tds'].'%',
                            $row['tds_amount'],
                            ($row['tds_month']) ? EmployeePay::tdsMonth($row['tds_month']) : '',
                            $row['amount_requested'],
                            $row['amount_approved'],
                            ($row['date_of_payment']) ? $this->dateFormate($row['date_of_payment']) : ''
                        ];
                }
            }
            // add an empty row before the next dataset
            $output[] = [''];
        }
        //print_r($output);die();
        $this->collection = collect($output);
    }           
                    
    public function collection()
    {
        $from=$this->from;
        $to=$this->to;
        $roleId = Auth::guard('employee')->user()->role_id;
        if ($this->request_type=='wdinv') {
            if ($roleId==10) {
                $invoice= WithoutPoInvoice::where('invoice_status',5);
            }
            if ($roleId==11) {
                $invoice= WithoutPoInvoice::where('invoice_status',6);
                if ($from && $to) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
            }
            return $invoice->get();
        }
        if ($this->request_type=='po') {
            $invoice = PurchaseOrder::where('account_status',1);
            if ($from && $to && $roleId==11) {
                $invoice->whereBetween('created_at',[$from,$to]);
            }
            return $invoice->get();
        }
        if ($this->request_type=='bnkRtrn') {
            if ($roleId==10) {
                $invoice = InternalTransfer::where('status',4);
            }
            if ($roleId==11) {
                $invoice = InternalTransfer::where('status',5);
                if ($from && $to) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
            }
            return $invoice->get();
        }
        if ($this->request_type=='inv') {
            if ($roleId==10) {
                $invoice = Invoice::where('invoice_status',5);
            }
            if ($roleId==11) {
                $invoice = Invoice::where('invoice_status',6);
                if ($from && $to && $roleId==11) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
            }
            return $invoice->get();
        }
        if ($this->request_type=='empPay') {
            if ($roleId==10) {
                $invoice = EmployeePay::where('status',5);
            }
            
            if ($roleId==11) {
                $invoice = EmployeePay::where('status',6);
                if ($from && $to && $roleId==11) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
            }
            return $invoice->get();
        }
        if ($this->request_type=='bulkUp') {
            if ($roleId==10) {
                $invoice = BulkCsvUpload::join('bulk_uploads', 'bulk_uploads.id', '=', 'bulk_csv_uploads.bulk_upload_id')->select('bulk_uploads.*','bulk_csv_uploads.*','bulk_csv_uploads.order_id as csv_order_id','bulk_uploads.order_id as bu_order_id','bulk_uploads.transaction_date')->where('bulk_uploads.status',5);
            }
            if ($roleId==11) {
                $invoice = BulkCsvUpload::join('bulk_uploads', 'bulk_uploads.id', '=', 'bulk_csv_uploads.bulk_upload_id')->select('bulk_uploads.*','bulk_csv_uploads.*','bulk_csv_uploads.order_id as csv_order_id','bulk_uploads.order_id as bu_order_id','bulk_uploads.transaction_date')->where('bulk_uploads.status',6);
                if ($from && $to && $roleId==11) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
            }
            return $invoice->get();
        }else{
            return $this->collection;
        }
    }

    public function map($data) : array {
        $roleId = Auth::guard('employee')->user()->role_id;
    	if ($this->request_type=='wdinv') {
            $account=$ifsc=$bnkName='';
            if($data->form_by_account){
                $item=json_decode($data->form_by_account);
                $account=($item->bank_account) ? $item->bank_account : '';
                $ifsc=($item->ifsc) ? $item->ifsc : '';
                $bnkName=($item->bank_name) ? $item->bank_name : '';
            }
            //if ($roleId==11) {
                return [
                    'Without Po Invoice',
                    $data->order_id,
                    json_decode($data->vendor_ary)->name,
                    json_decode($data->vendor_ary)->vendor_code,
                    json_decode($data->vendor_ary)->pan ?? '',
                    $data->amount,
                    $data->tax.'%',
                    $data->tax_amount,
                    $data->invoice_amount,
                    $data->tds_month,
                    $data->tds.'%',
                    $data->tds_amount,
                    $data->tds_payable,
                    json_decode($data->employee_ary)->name ?? '',
                    json_decode($data->employee_ary)->employee_code ?? '',
                    Invoice::invoiceStatus($data->invoice_status),
                    $this->dateFormate($data->created_at),
                    $account,
                    $ifsc,
                    $bnkName,
                    $data->transaction_id ?? '',
                    ($data->transaction_date) ? $this->dateFormate($data->transaction_date) : '',
                    ($data->date_of_payment) ? $this->dateFormate($data->date_of_payment) : ''
                ] ; 
            
        }
        if ($this->request_type=='po') {
            $invc=\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->id])->sum('invoice_amount');
            return [
                'Purchase Order',
                $data->order_id,
                json_decode($data->vendor_ary)->name,
                json_decode($data->vendor_ary)->vendor_code,
                \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '',
                \App\Helpers\Helper::onlyDate($data->po_end_date) ?? '',
                $data->net_payable,
                Invoice::invoiceLimit($data->net_payable) ?? '',
                $invc ?? '0',
                $data->net_payable-$invc ?? '0',
                $data->advance_tds ?? '',
                json_decode($data->user_ary)->name ?? '',
                json_decode($data->user_ary)->employee_code ?? '',
                PurchaseOrder::paymentMethod($data->payment_method) ?? '',
                EmployeePay::requestStatus($data->account_status),
                $this->dateFormate($data->created_at),
                '',
                '',
                ''
            ] ;
        }
        if ($this->request_type=='bnkRtrn') {
            $account=$ifsc=$bnkName='';
            if($data->form_by_account){
                $item=json_decode($data->form_by_account);
                $account=($item->bank_account) ? $item->bank_account : '';
                $ifsc=($item->ifsc) ? $item->ifsc : '';
                $bnkName=($item->bank_name) ? $item->bank_name : '';
            }
            return [
                'Internal Transfer',
                $data->nature_of_request,
                $data->order_id,
                json_decode($data->employee_ary)->name ?? '',
                json_decode($data->employee_ary)->employee_code ?? '',
                json_decode($data->apex_ary)->name ?? '',
                json_decode($data->state_bank_ary)->bank_name ?? '',
                json_decode($data->state_bank_ary)->bank_account_number ?? '',
                json_decode($data->state_bank_ary)->branch_address ?? '',
                json_decode($data->state_bank_ary)->branch_code ?? '',
                json_decode($data->state_bank_ary)->bank_account_holder ?? '',
                $data->ifsc ?? '',
                $data->project_name ?? '',
                $data->project_id ?? '',
                $data->reason ?? '',
                $data->cost_center ?? '',
                json_decode($data->transfer_from_ary)->bank_name ?? '',
                json_decode($data->transfer_from_ary)->bank_account_number ?? '',
                json_decode($data->transfer_from_ary)->branch_address ?? '',
                json_decode($data->transfer_from_ary)->branch_code ?? '',
                json_decode($data->transfer_from_ary)->bank_account_holder ?? '',
                json_decode($data->transfer_from_ary)->ifsc ?? '',
                json_decode($data->transfer_to_ary)->bank_name ?? '',
                json_decode($data->transfer_to_ary)->bank_account_number ?? '',
                json_decode($data->transfer_to_ary)->branch_address ?? '',
                json_decode($data->transfer_to_ary)->branch_code ?? '',
                json_decode($data->transfer_to_ary)->bank_account_holder ?? '',
                json_decode($data->transfer_to_ary)->ifsc ?? '',
                $data->amount,
                InternalTransfer::requestStatus($data->status),
                $this->dateFormate($data->created_at),
                $account,
                $ifsc,
                $bnkName,
                $data->transaction_id ?? '',
                ($data->transaction_date) ? $this->dateFormate($data->transaction_date) : '',
                ($data->date_of_payment) ? $this->dateFormate($data->date_of_payment) : ''
            ] ;
        }
        if ($this->request_type=='inv') {
            $account=$ifsc=$bnkName='';
            if($data->form_by_account){
                $item=json_decode($data->form_by_account);
                $account=($item->bank_account) ? $item->bank_account : '';
                $ifsc=($item->ifsc) ? $item->ifsc : '';
                $bnkName=($item->bank_name) ? $item->bank_name : '';
            }
            //if ($roleId==11) {
                return [
                    'PO Invoice',
                    $data->order_id,
                    json_decode($data->po_ary)->order_id ?? '',
                    json_decode($data->vendor_ary)->name,
                    json_decode($data->vendor_ary)->vendor_code,
                    json_decode($data->vendor_ary)->pan ?? '',
                    $data->amount,
                    $data->tax.'%',
                    $data->tax_amount,
                    $data->invoice_amount,
                    $data->tds.'%',
                    $data->tds_amount,
                    $data->tds_payable,
                    json_decode($data->employee_ary)->name ?? '',
                    json_decode($data->employee_ary)->employee_code ?? '',
                    Invoice::invoiceStatus($data->invoice_status),
                    $this->dateFormate($data->created_at),
                    $account,
                    $ifsc,
                    $bnkName,
                    $data->transaction_id ?? '',
                    ($data->transaction_date) ? $this->dateFormate($data->transaction_date) : '',
                    ($data->date_of_payment) ? $this->dateFormate($data->date_of_payment) : ''
                ] ;
            
        }
        if ($this->request_type=='empPay') {
            $item=json_decode($data->item_detail);
            if(isset($item->medical->pay_to) && $item->medical->pay_to=='Pay to Hospital'){
                //$bnkName=$item->medical->bank_name ?? '';
                $bnkAccNumber=$item->medical->bank_account_number ?? '';
                $ifsc=$item->medical->ifsc ?? '';
                $pan=$item->medical->pan ?? '';
            }else{
                //$bnkName=$item->medical->bank_name ?? '';
                $bnkAccNumber=$data->bank_account_number ?? '';
                $ifsc=$data->ifsc ?? '';
                $pan=$data->pan ?? '';
            }
             //echo $item->medical->pay_to.'='.$bnkAccNumber.'='.$ifsc.'='.$pan;die();
            return [
                'Employee Pay',
                $data->order_id,
                json_decode($data->nature_of_claim_ary)->name ?? '',
                json_decode($data->pay_for_employee_ary)->name ?? '',
                json_decode($data->pay_for_employee_ary)->employee_code ?? '',
                $data->address,
                //$data->bank_account_number,
               // $data->ifsc,
                //$data->pan,
                $bnkAccNumber,
                $ifsc,
                $pan,
                json_decode($data->apexe_ary)->name ?? '',
                $data->required_tds,
                $data->tds.'%',
                $data->tds_amount,
                ($data->tds_month) ? EmployeePay::tdsMonth($data->tds_month) : '',
                $data->amount_requested,
                $data->amount_approved,
                EmployeePay::requestStatus($data->status),
                $this->dateFormate($data->created_at),
                $data->transaction_id ?? '',
                ($data->transaction_date) ? $this->dateFormate($data->transaction_date) : '',
                ($data->date_of_payment) ? $this->dateFormate($data->date_of_payment) : ''
            ] ;
        }
        if ($this->request_type=='bulkUp') {
            return [
                'Bulk Upload',
                $data->csv_order_id ?? '',
                $data->bu_order_id ?? '',
                \App\BulkUpload::categoryView($data->category) ?? '',
                \App\BulkUpload::bankView($data->bank_formate) ?? '',
                \App\BulkUpload::paymentTypeView($data->payment_type) ?? '',
                $data->account_no,
                $data->branch_code,
                $data->amt_date,
                $data->dr_amount,
                $data->cr_amount,
                $data->refrence,
                $data->pay_id,
                $data->transaction_type,
                $data->debit_account_no,
                $data->ifsc,
                $data->beneficiary_account_no,
                $data->beneficiary_name,
                $data->amount,
                $data->remarks_for_client,
                $data->remarks_for_beneficiary,
                \App\BulkUpload::requestStatus($data->status) ?? '',
                $this->dateFormate($data->created_at),
                $data->transaction_id ?? '',
                ($data->transaction_date) ? $this->dateFormate($data->transaction_date) : '',
                ($data->date_of_payment) ? $this->dateFormate($data->date_of_payment) : ''
            ] ;
        }else{
           // print_r($data);die();
            return $data;
        }
    }
 
    public function headings(): array
    {
        $roleId = Auth::guard('employee')->user()->role_id;
        if ($this->request_type=='empPay') {
            return [
                'Type of Nature',
                'Generated Id',
                'Nature Of Claim',
                'For Emopyee',
                'For Emopyee Code',
                'Address',
                'Bank Account',
                'IFSC',
                'Pan Number',
                'Apex',
                'TDS Required',
                'TDS',
                'TDS Amount',
                'TDS Section',
                'Requested Amount',
                'Approved Amount',
                'Status',
                'Date',
                'Transaction Id',
                'Transaction Date',
                'Date Of Payment'
            ];
        }else if ($this->request_type=='wdinv') {
           // if ($roleId==11) {
                return [
                    'Type of Nature',
                    'Generated Id',
                    'Vendor Name',
                    'Vendor Code',
                    'Vendor Pan',
                    'Amount',
                    'Tax',
                    'Tax Amount',
                    'Invoice Amount',
                    'TDS Section',
                    'TDS Value',
                    'TDS Amount',
                    'Payable Amount',
                    'Employee',
                    'Employee Code',
                    'Status',
                    'Date',
                    'Bank Account',
                    'IFSC',
                    'Bank Name',
                    'Transaction Id',
                    'Transaction Date',
                    'Date Of Payment'
                ];
            
        }else if ($this->request_type=='inv') {
            // if ($roleId==11) {
                return [
                    'Type of Nature',
                    'Generated Id',
                    'PO Id',
                    'Vendor Name',
                    'Vendor Code',
                    'Vendor Pan',
                    'Amount',
                    'Tax',
                    'Tax Amount',
                    'With Tax Amount',
                    'TDS',
                    'TDS Amount',
                    'Final Amount',
                    'Employee',
                    'Employee Code',
                    'Status',
                    'Date',
                    'Bank Account',
                    'IFSC',
                    'Bank Name',
                    'Transaction Id',
                    'Transaction Date',
                    'Date Of Payment'
                ];
            
        }else if ($this->request_type=='bnkRtrn') {
            return [
                'Type of Nature',
                'Nature Of Request',
                'Generated Id',
                'Employee Name',
                'Employee Code',
                'State',
                'State Bank Name',
                'State Bank Account',
                'State Bank Address',
                'State Bank Branch Code',
                'State Bank Holder',
                'IFSC',
                'Project Name',
                'Project Id',
                'Reason',
                'Cost Center',
                'Transfer From Bank',
                'Transfer From Account',
                'Transfer From Branch',
                'Transfer From Branch Code',
                'Transfer From Bank Holder',
                'Transfer From Bank IFSC',
                'Transfer To Bank',
                'Transfer To Account',
                'Transfer To Branch',
                'Transfer To Branch Code',
                'Transfer To Bank Holder',
                'Transfer To Bank IFSC',
                'Amount',
                'Status',
                'Date',
                'Bank Account',
                'IFSC',
                'Bank Name',
                'Transaction Id',
                'Transaction Date',
                'Date Of Payment'
            ];
        }else if ($this->request_type=='po'){
            return [
                'Type of Nature',
                'Generated Id',
                'Vendor Name',
                'Vendor Code',
                'PO Start Date',
                'PO End Date',
                'PO Total',
                'PO Invoice Limit',
                'Invoice Approved',
                'PO Balance',
                'Advance TDS',
                'Creater Employee',
                'Employee Code',
                'Payment',
                'Status',
                'Date',
                'Transaction Id',
                'Transaction Date',
                'Date Of Payment'
            ];
        }else if ($this->request_type=='bulkUp') {
            return [
                'Type of Nature',
                'Generated Id',
                'Bulk Upload Generated Id',
                'Category',
                'Bank Formate',
                'Payment Type',
                'Account No',
                'Branch Code',
                'Amount Date',
                'Dr Amount',
                'Cr Amount',
                'Refrence',
                'Pay id',
                'Transaction Type',
                'Debit Account No',
                'IFSC',
                'Beneficiary Account No',
                'Beneficiary Name',
                'Amount',
                'Remarks For Client',
                'Remarks For Beneficiary',
                'Status',
                'Date',
                'Transaction Id',
                'Transaction Date',
                'Date Of Payment'
            ];
        }else{
            return [
                    
                ];
        }
    }

    public function dateFormate($value='')
    {
        return date('d/m/Y',strtotime($value));
    }
}
 