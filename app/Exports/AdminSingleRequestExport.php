<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Employee;
use App\Vendor;
use App\Invoice;
use App\WithoutPoInvoice;
use App\PurchaseOrder;
use App\InternalTransfer;
use App\EmployeePay;
use App\Bulkupload;
use App\BulkCsvUpload;
use App\Helpers\Helper;
use Auth;
class AdminSingleRequestExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($request_type=null,$from='',$to='',$array=[])
    {
    	$this->request_type = $request_type;
        $this->from = $from;
        $this->to = $to;
        $this->getArray=$array;
       
    }           
                    
    public function collection()
    {
        $from=$this->from;
        $to=$this->to;
        
        if ($this->request_type=='wdinv') {

                $invoice= WithoutPoInvoice::orderBy('id','desc');
                if (isset($this->getArray['vendor']) && $this->getArray['vendor']) {

                    $invoice->where('vendor_id',Vendor::where('vendor_code',$this->getArray['vendor'])->first()->id ?? '');
                }
                if ($from && $to=='') {
                    $invoice->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('created_at',[$from,$to]);
                }
            return $invoice->get();
        }
        if ($this->request_type=='po') {
            $invoice = PurchaseOrder::orderBy('id','desc');
            if ($from && $to=='') {
                    $invoice->whereDate('created_at',$from);
                }
            if ($from && $to) {
                $invoice->whereBetween('created_at',[$from,$to]);
            }
            return $invoice->get();
        }
        if ($this->request_type=='poVendor') {
            $invoice = PurchaseOrder::orderBy('id','desc');
            if (isset($this->getArray['vendor']) && $this->getArray['vendor']) {
                    $invoice->where('vendor_id',Vendor::where('vendor_code',$this->getArray['vendor'])->first()->id ?? '');
                }
                if ($from && $to=='') {
                    $invoice->whereDate('created_at',$from);
                }
            if ($from && $to) {
                $invoice->whereBetween('created_at',[$from,$to]);
            }
            return $invoice->get();
        }
        if ($this->request_type=='bnkRtrn') {

                $invoice = InternalTransfer::where('nature_of_request','Inter bank transfer')->orderBy('id','desc');
                if ($from && $to=='') {
                    $invoice->whereDate('transaction_date',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
          
            return $invoice->get();
        }
        if ($this->request_type=='interStateRtrn') {

                $invoice = InternalTransfer::where('nature_of_request','State requesting funds')->orderBy('id','desc');
                if ($from && $to=='') {
                    $invoice->whereDate('transaction_date',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
          
            return $invoice->get();
        }
        if ($this->request_type=='inv') {
                $invoice = Invoice::orderBy('id','desc');
                if (isset($this->getArray['vendor']) && $this->getArray['vendor']) {
                    $invoice->where('vendor_id',Vendor::where('vendor_code',$this->getArray['vendor'])->first()->id ?? '');
                }
                if ($from && $to=='') {
                    $invoice->whereDate('created_at',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('created_at',[$from,$to]);
                }
           
            return $invoice->get();
        }
        if ($this->request_type=='empPay') {

                $invoice = EmployeePay::orderBy('id','desc');
                if (isset($this->getArray['employee']) && $this->getArray['employee']) {
                    $invoice->where('employee_id',Employee::where('employee_code',$this->getArray['employee'])->first()->id ?? '');
                }
                if ($from && $to=='') {
                    $invoice->whereDate('transaction_date',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
           
            return $invoice->get();
        }
        if ($this->request_type=='empPaidRep') {

                $invoice = EmployeePay::orderBy('id','desc');
                if (isset($this->getArray['employee']) && $this->getArray['employee']) {
                    $invoice->where('employee_id',Employee::where('employee_code',$this->getArray['employee'])->first()->id ?? '');
                }
                if ($from && $to=='') {
                    $invoice->whereDate('date_of_payment',$from);
                }

                if (isset($this->getArray['acc_no']) && $this->getArray['acc_no']) {
                    $accDT = $invoice;
                    if ($accDT->count()) {

                        $empId=[];
                        foreach ($accDT->get() as $dtkey => $dtvalue) {
                            $item=json_decode($dtvalue->form_by_account);
                            if($dtvalue->form_by_account && $item){
                                if ($item->bank_account==$this->getArray['acc_no']) {
                                    $empId[]=$dtvalue->id;
                                }
                            }
                        }
                         $invoice->whereIn('id',$empId);
                    }
                } 
                

                if ($from && $to) {
                    $invoice->whereBetween('date_of_payment',[$from,$to]);
                }
           
            return $invoice->get();
        }
        if ($this->request_type=='bulkUp') {

                $invoice = BulkCsvUpload::join('bulk_uploads', 'bulk_uploads.id', '=', 'bulk_csv_uploads.bulk_upload_id')->select('bulk_uploads.*','bulk_csv_uploads.*','bulk_csv_uploads.order_id as csv_order_id','bulk_uploads.order_id as bu_order_id','bulk_uploads.transaction_date')->orderBy('bulk_uploads.id','desc');
                if ($from && $to=='') {
                    $invoice->whereDate('transaction_date',$from);
                }
                if ($from && $to) {
                    $invoice->whereBetween('transaction_date',[$from,$to]);
                }
            
            return $invoice->get();
        }else{
            return $this->collection;
        }
    }

    public function map($data) : array {
        
    	if ($this->request_type=='wdinv') {
            $dbAc=$amt=$cen=$cat=[];
        	if($data->form_by_account){
       			$item=json_decode($data->form_by_account);
                foreach($item->form_by_account as $itemKey => $itemVal)
                {
                   $dbAc[]=$itemVal->debit_account;
                    $amt[]=$itemVal->amount;
                    $cen[]=$itemVal->cost_center;
                    $cat[]=$itemVal->category;
                 }
             }
                return [
                    $data->order_id,
                    Helper::onlyDate($data->created_at),
                    json_decode($data->apexe_ary)->name ?? '',
                    json_decode($data->vendor_ary)->name ?? '',
                    json_decode($data->vendor_ary)->vendor_code ?? '',
                    $data->invoice_number,
                    Helper::onlyDate($data->invoice_date),
                    $data->amount ?? '00',
                    $data->tax ?? '0'.'%',
                    $data->tax_amount ?? '00',
                    $data->invoice_amount ?? '00',
                    $data->tds_payable ?? 00,
                    json_decode($data->employee_ary)->employee_code ?? '',
                    implode(',', $dbAc),
                    implode(',', $amt),
                    implode(',', $cen),
                    implode(',', $cat)
                ] ;
            
            
        }
        if ($this->request_type=='po') {
            return [
                $data->order_id,
                \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '',
                \App\Helpers\Helper::onlyDate($data->po_end_date) ?? '',
                \App\PurchaseOrder::paymentMethod($data->payment_method) ?? '',
                \App\PurchaseOrder::natureOfService($data->nature_of_service) ?? '',
                json_decode($data->apexe_ary)->name ?? '',
                json_decode($data->vendor_ary)->name ?? '',
                json_decode($data->vendor_ary)->vendor_code ?? '',
                $data->total ?? '00',
                \App\Invoice::invoiceLimit($data->net_payable) ?? '00',
                \App\Invoice::approvedPoInvoice($data->id) ?? '00',
                \App\Invoice::proccessPoInvoice($data->id),
                \App\Invoice::poBalance($data->id),
                json_decode($data->user_ary)->employee_code ?? ''
            ] ;
        } if ($this->request_type=='poVendor') {
            $item_name=$quantity=$unit=$rate=$total=[];
            if($data->item_detail){
                $item=json_decode($data->item_detail); 
                  foreach($item as $itemKey => $itemVal){
                   $item_name[]=$itemVal->item_name;
                    $quantity[]=$itemVal->quantity;
                    $unit[]=$itemVal->unit;
                    $rate[]=$itemVal->rate;
                    $total[]=$itemVal->total;
                  }
              }
    return [
                $data->order_id,
                \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '',
                json_decode($data->vendor_ary)->name ?? '',
                json_decode($data->vendor_ary)->vendor_code ?? '',
                $data->total ?? '00',
                $data->discount ?? '00',
                $data->net_payable ?? '00',
                json_decode($data->user_ary)->employee_code ?? '',
                implode(',', $item_name),
                implode(',', $quantity),
                implode(',', $rate),
                implode(',', $total)
            ] ;
        }
        if ($this->request_type=='interStateRtrn') {

            return [
                $data->order_id,
               ($data->date_of_payment) ? Helper::onlyDate($data->date_of_payment) : 'Not updated',
                json_decode($data->apexe_ary)->name ?? '',
                json_decode($data->state_bank_ary)->bank_account_number ?? '',
                json_decode($data->state_bank_ary)->ifsc ?? '',
                $data->project_name,
                $data->project_id,
                $data->reason,
                $data->cost_center,
                $data->amount ?? 00,

                json_decode($data->state_bank_ary)->bank_account_number ?? 'Not updated',
                ($data->transaction_date) ? Helper::onlyDate($data->transaction_date) : 'Not updated',
                ($data->transaction_id) ? $data->transaction_id : 'Not updated',
                json_decode($data->employee_ary)->employee_code ?? ''
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
                $data->order_id,
               ($data->date_of_payment) ? Helper::onlyDate($data->date_of_payment) : 'Not updated',
                json_decode($data->apexe_ary)->name ?? '',
                json_decode($data->transfer_from_ary)->bank_account_number ?? '',
                json_decode($data->transfer_from_ary)->ifsc ?? '',
                json_decode($data->transfer_to_ary)->bank_account_number ?? '',
                json_decode($data->transfer_to_ary)->ifsc ?? '',
                $data->amount ?? '00',
                ($data->transaction_date) ? Helper::onlyDate($data->transaction_date) : 'Not updated',
                ($data->transaction_id) ? $data->transaction_id : 'Not updated',
                json_decode($data->employee_ary)->employee_code ?? ''
            ] ;
        }
        if ($this->request_type=='inv') {
        	$dbAc=$amt=$cen=$cat=[];
        	if($data->form_by_account){
       			$item=json_decode($data->form_by_account);
                foreach($item->form_by_account as $itemKey => $itemVal)
                {
                   $dbAc[]=$itemVal->debit_account;
                    $amt[]=$itemVal->amount;
                    $cen[]=$itemVal->cost_center;
                    $cat[]=$itemVal->category;
                 }
             }
                return [
                    $data->order_id,
                    Helper::onlyDate($data->created_at),
                    $data->poDetail->order_id,
                    json_decode($data->apexe_ary)->name ?? '',
                    json_decode($data->vendor_ary)->name ?? '',
                    json_decode($data->vendor_ary)->vendor_code ?? '',
                    $data->invoice_number,
                    Helper::onlyDate($data->invoice_date),
                    $data->amount ?? '00',
                    $data->tax ?? '0'.'%',
                    $data->tax_amount ?? '00',
                    $data->invoice_amount ?? '00',
                    $data->tds_payable ?? 00,
                    json_decode($data->employee_ary)->employee_code ?? '',
                    implode(',', $dbAc),
                    implode(',', $amt),
                    implode(',', $cen),
                    implode(',', $cat)
                ] ;
            
        }if ($this->request_type=='invPayment') {
        	$dbAc=$amt=$cen=$cat=[];
        	if($data->form_by_account){
       			$item=json_decode($data->form_by_account);
                foreach($item->form_by_account as $itemKey => $itemVal)
                {
                   $dbAc[]=$itemVal->debit_account;
                    $amt[]=$itemVal->amount;
                    $cen[]=$itemVal->cost_center;
                    $cat[]=$itemVal->category;
                 }
             }
                return [
                    $data->order_id,
                    Helper::onlyDate($data->created_at),
                    $data->poDetail->order_id,
                    json_decode($data->apexe_ary)->name ?? '',
                    json_decode($data->vendor_ary)->name ?? '',
                    json_decode($data->vendor_ary)->vendor_code ?? '',
                    $data->invoice_number,
                    Helper::onlyDate($data->invoice_date),
                    $data->amount ?? '00',
                    $data->tax ?? '0'.'%',
                    $data->tax_amount ?? '00',
                    $data->invoice_amount ?? '00',
                    $data->tds_payable ?? 00,
                    json_decode($data->employee_ary)->employee_code ?? '',
                    implode(',', $dbAc),
                    implode(',', $amt),
                    implode(',', $cen),
                    implode(',', $cat)
                ] ;
            
        }
        if ($this->request_type=='empPay') {
            $dbAc=$amt=$cen=$cat=[];
            if($data->form_by_account){
                $item=json_decode($data->form_by_account);
                foreach($item->form_by_account as $itemKey => $itemVal)
                {
                   $dbAc[]=$itemVal->debit_account;
                    $amt[]=$itemVal->amount;
                    $cen[]=$itemVal->cost_center;
                    $cat[]=$itemVal->category;
                 }
             }
             //echo $item->medical->pay_to.'='.$bnkAccNumber.'='.$ifsc.'='.$pan;die();
            return [
                $data->order_id,
                Helper::onlyDate($data->created_at),
                json_decode($data->employee_ary)->name ?? '',
                json_decode($data->employee_ary)->employee_code ?? '',
                $data->bank_account_number,
                $data->ifsc,
                json_decode($data->nature_of_claim_ary)->name,
                json_decode($data->apexe_ary)->name ?? '',
                $data->amount_requested,
                json_decode($data->employee_ary)->employee_code ?? '',
                implode(',', $dbAc),
                implode(',', $amt),
                implode(',', $cen),
                implode(',', $cat)
                
            ] ;
        }if ($this->request_type=='empPaidRep') {
            $bnkAccNumber='';
            $item=json_decode($data->form_by_account);
            if($data->form_by_account && $item){

                $bnkAccNumber=$item->bank_account ?? '';
            }
             //echo $item->medical->pay_to.'='.$bnkAccNumber.'='.$ifsc.'='.$pan;die();
            return [
                $data->order_id,
                ($data->date_of_payment) ? Helper::onlyDate($data->date_of_payment) : 'Not updated',
                ($data->transaction_id) ? $data->transaction_id : 'Not updated',
                Helper::onlyDate($data->created_at),
                $bnkAccNumber,
                json_decode($data->employee_ary)->name ?? '',
                json_decode($data->employee_ary)->employee_code ?? '',
                json_decode($data->apexe_ary)->name ?? '',
                json_decode($data->nature_of_claim_ary)->name,
                $data->amount_requested,
                json_decode($data->employee_ary)->employee_code ?? ''
                
            ] ;
        }
        if ($this->request_type=='bulkUp') {
        	$acc=$ifsc='';
        	if($data->bulkUpload->form_by_account){
        	    $item=json_decode($data->bulkUpload->form_by_account);
	                  $acc=$item->bank_account ?? '';
	                  $ifsc=$item->ifsc ?? '';
        	     }
              
            return [
                $data->bulkUpload->order_id ?? '',
                ($data->bulkUpload->date_of_payment) ? Helper::onlyDate($data->bulkUpload->date_of_payment) : 'Not updated',
                $data->account_no,
                \App\BulkUpload::paymentTypeView($data->bulkUpload->payment_type) ?? '',
                json_decode($data->bulkUpload->apexe_ary)->name ?? '',
                $acc,
                $ifsc,
                ($data->bulkUpload->payment_type==3) ? $data->amount : 0,
                ($data->bulkUpload->payment_type!=3) ? $data->dr_amount : 0,
                ($data->bulkUpload->transaction_id) ? $data->bulkUpload->transaction_id : 'Not updated',
                ($data->bulkUpload->transaction_date) ? Helper::onlyDate($data->bulkUpload->transaction_date) : 'Not updated',
                json_decode($data->bulkUpload->employee_ary)->employee_code ?? '',
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
        
        if ($this->request_type=='empPay') {
            return [
                'Request Id',
                'Request Date',
                'Employee',
                'Code',
                'Employee A/c.No.',
                'IFSC Code',
                'Nature Of Claim',
                'Apex',
                'Amount',
                'Request By (Empl.Code)',
                'Debit Account',
                'Amount',
                'Cost Center',
                'Category'
            ];
        }else if ($this->request_type=='empPaidRep') {
            return [
                'Request Id',
                'Payment Date',
                'Transaction ID',
                'Request Date',
                'Payment Bank A/c',
                'Employee',
                'Code',
                'Apex',
                'Nature Of Claim',
                'Amount',
                'Request By (Empl.Code)'
            ];
        }else if ($this->request_type=='wdinv') {
               return [
                    'Invoice Unique Id',
					'Request Date',
					'Apex',
					'Vendor',
					'Code',
					'INV. No.',
					'INV.Date',
					'Amount',
					'GST%',
					'GSt Amount',
					'INV.Amount',
					'Net Amount',
					'Request By',
					'Debit A/C',
					'Debit Amt',
					'Cost Center',
					'Category'
                ];
        }else if ($this->request_type=='inv') {
                return [
                    'Invoice Unique Id',
					'Request Date',
					'Against PO:',
					'Apex',
					'Vendor',
					'Code',
					'INV. No.',
					'INV.Date',
					'Amount',
					'GST%',
					'GSt Amount',
					'INV.Amount',
					'Net Amount',
					'Request By',
					'Debit A/C',
					'Debit Amt',
					'Cost Center',
					'Category'
                ];
        }else if ($this->request_type=='invPayment') {
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
        }else if ($this->request_type=='bnkRtrn') {
            return [
                'Payment Unique Id',
				'Payment Date',
				'Apex',
				'Transfer From A/C',
				'IFSC',
				'Transfer To A/C',
				'IFSC',
				'Amount',
				'Transaction Date',
				'Transaction Id',
				'Request By (Emp.Code)'
            ];
        }else if ($this->request_type=='interStateRtrn') {
            return [
                'Payment Unique Id',
				'Payment Date',
				'Apex',
				'Apex Bank Account',
				'IFSC',
				'Project Name',
				'Project Id',
				'Reason',
				'Cost Center',
				'Amount',
				'Payment Bank Account',
				'Transaction Date',
				'Transaction Id',
				'Request By (Emp.Code)'
            ];
        }else if ($this->request_type=='po'){
            return [
                'PO No:',
                'Start Date',
                'End Date',
                'Payment Method',
                'Nature Of Goods',
                'Apex',
                'Vendor',
                'Code',
                'PO Total',
                'PO Total With Margin',
                'Invoice Approved',
                'Invoice In Process',
                'PO Balance',
                'Request By ( Emp.Code)'
            ];
        }else if ($this->request_type=='poVendor'){
            return [
                'PO No:',
                'Start Date',
                'Vendor',
                'Code',
                'PO Amount',
                'Discount',
                'Net PO Amount',
                'Request By ( Empl.Code)',
                'Item',
                'QTY',
                'Rate',
                'Amount'
            ];
        }else if ($this->request_type=='bulkUp') {
            return [
                'Bulk Unique Id',
				'Payment Date',
				'Payment Bank Account',
				'Payment Type',
				'Apax',
				'A/C Number',
				'IFSC',
				'Amount',
				'DR Amount',
				'CR Amount',
				'Transaction Id',
				 'Transaction Date',
				'Request By (Emp.Code)'
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
 