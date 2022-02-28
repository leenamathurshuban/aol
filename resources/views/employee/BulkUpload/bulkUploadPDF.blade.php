@php $inr = Html::decode('<img src="'.url('assets/admin/inr-dark.png').'" style="height: 11px;">');@endphp
<table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
  <tr style="width: 100%">
    <th style="border: solid 1px #ccc;text-align: center;width: 100%" colspan="3"><h3>Request No: {{ $data->order_id ?? '' }}</h3></th>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Category:</strong><p>{{ \App\BulkUpload::categoryView($data->category) ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Bank Formate:</strong><p>{{ \App\BulkUpload::bankView($data->bank_formate) ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Payment Type:</strong><p>{{ \App\BulkUpload::paymentTypeView($data->payment_type) ?? ''}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Request Status:</strong><p>{{ \App\EmployeePay::requestStatus($data->status)}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->created_at) ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Requested Employee:</strong><p>{{json_decode($data->employee_ary)->name ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Requested Employee Code:</strong><p>{{json_decode($data->employee_ary)->employee_code ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p></td>
  </tr> 
  @if(Auth::guard('employee')->user()->role_id!=4)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;border: solid 1px #ccc;" colspan="">
      <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
    </td>
    <td style="border: solid 1px #ccc;border: solid 1px #ccc;">
      <strong>Transaction Date:</strong><p>{{ ($data->transaction_date) ? \App\Helpers\Helper::onlyDate($data->transaction_date) : '' }}</p>
    </td>
    <td style="border: solid 1px #ccc;border: solid 1px #ccc;">
      <strong>Date of Payment:</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p>
    </td>
  </tr>
  @endif
  @if($data->form_by_account)
    @php $item=json_decode($data->form_by_account); @endphp
     <tr style="width: 100%;">
        <td style="border: solid 1px #ccc;">
          <strong>Bank Account</strong><p>{{$item->bank_account}}</p>
        </td>
        <td style="border: solid 1px #ccc;">
          <strong>IFSC</strong><p>{{$item->ifsc}}</p>
        </td>
        <td style="border: solid 1px #ccc;">
          <strong>Bank Name</strong><p>{{$item->bank_name}}</p>
        </td>
     </tr>
     
  @endif
  <tr style="width: 100%">
    <td colspan="3" style="padding: 0px;">
      @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
             <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
                <tr style="width: 100%">
                  <th style="border: solid 1px #ccc;">Sr.</th>
                  <th style="border: solid 1px #ccc;">Debit Account</th>
                  <th style="border: solid 1px #ccc;">Amount</th>
                  <th style="border: solid 1px #ccc;">Cost Center</th>
                  <th style="border: solid 1px #ccc;">Category</th>
                </tr>
                @forelse($item->form_by_account as $itemKey => $itemVal)
                    <tr style="width: 100%">
                    <td style="border: solid 1px #ccc;">{{++$itemKey}}</td>
                    <td style="border: solid 1px #ccc;">{{$itemVal->debit_account}}</td>
                    <td style="border: solid 1px #ccc;">{!! $inr !!}{{$itemVal->amount}}</td>
                    <td style="border: solid 1px #ccc;">{{$itemVal->cost_center}}</td>
                    <td style="border: solid 1px #ccc;">{{$itemVal->category}}</td>
                  </tr>
                @empty
                @endforelse
              </table>
          @endif
    </td>
  </tr>
  @if($data->manager_id && $data->manager_ary)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Manager:</strong><p>{{json_decode($data->manager_ary)->name ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Manager Code:</strong><p>{{json_decode($data->manager_ary)->employee_code ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Manager Email:</strong><p>{{json_decode($data->manager_ary)->email ?? ''}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3"><strong>Manager Comment:</strong><p>{{$data->manager_comment}}</p></td>
  </tr>
  @endif
  @if($data->account_dept_id && $data->account_dept_ary)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Account Office:</strong><p>{{json_decode($data->account_dept_ary)->name ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Account Code:</strong><p>{{json_decode($data->account_dept_ary)->employee_code ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Account Email:</strong><p>{{json_decode($data->account_dept_ary)->email ?? ''}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3"><strong>Account Comment:</strong><p>{{$data->account_dept_comment}}</p></td>
  </tr>
  @endif
  @if($data->trust_ofc_id && $data->trust_ofc_ary)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Trust Office:</strong><p>{{json_decode($data->trust_ofc_ary)->name ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Trust Code:</strong><p>{{json_decode($data->trust_ofc_ary)->employee_code ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Trust Email:</strong><p>{{json_decode($data->trust_ofc_ary)->email ?? ''}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3"><strong>Trust Comment:</strong><p>{{$data->trust_ofc_comment}}</p></td>
  </tr>
  @endif
  @if($data->payment_ofc_id && $data->payment_ofc_ary)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Payment Office:</strong><p>{{json_decode($data->payment_ofc_ary)->name ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Payment Code:</strong><p>{{json_decode($data->payment_ofc_ary)->employee_code ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Payment Email:</strong><p>{{json_decode($data->payment_ofc_ary)->email ?? ''}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3"><strong>Payment Comment:</strong><p>{{$data->payment_ofc_comment}}</p></td>
  </tr>
  @endif
  @if($data->tds_ofc_id && $data->tds_ofc_ary)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>TDS Office:</strong><p>{{json_decode($data->tds_ofc_ary)->name ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>TDS Code:</strong><p>{{json_decode($data->tds_ofc_ary)->employee_code ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>TDS Email:</strong><p>{{json_decode($data->tds_ofc_ary)->email ?? ''}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3"><strong>TDS Comment:</strong><p>{{$data->tds_ofc_comment}}</p></td>
  </tr>
  @endif
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">{!! Html::decode(link_to('public/'.$data->bulk_attachment_path,\App\Helpers\Helper::getDocType($data->bulk_attachment_path,$data->bulk_attachment_type),['target'=>'_blank'])) !!}</td>
    <td colspan="2"><p>{{ $data->bulk_attachment_description }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3" style="padding: 0px;">
      @if($data->payment_type==1 || $data->payment_type==2)
        <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
            <tr style="width: 100%">
              <th style="border: solid 1px #ccc;">Sr:</th>
              <th style="border: solid 1px #ccc;">Account Number</th>
              <th style="border: solid 1px #ccc;">Branch Code</th>
              <th style="border: solid 1px #ccc;">Date</th>
              <th style="border: solid 1px #ccc;">Dr Amount</th>
              <th style="border: solid 1px #ccc;">Cr Amount</th>
              <th style="border: solid 1px #ccc;">Refrence</th>
              <th style="border: solid 1px #ccc;">Description</th>
              <th style="border: solid 1px #ccc;">Pay Id</th>
            </tr>
          @forelse($data->bulkCsv as $ckey => $cval)
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;">{{ ++$ckey }}</td>
              <td style="border: solid 1px #ccc;">{{ $cval->account_no }}</td>
              <td style="border: solid 1px #ccc;">{{ $cval->branch_code }}</td>
              <td style="border: solid 1px #ccc;">{{ $cval->amt_date }}</td>
              <td style="border: solid 1px #ccc;">{{ env('CURRENCY_SYMBOL') }}{{ $cval->dr_amount }}</td>
              <td style="border: solid 1px #ccc;">{{ env('CURRENCY_SYMBOL') }}{{ $cval->cr_amount }}</td>
              <td style="border: solid 1px #ccc;">{{ $cval->refrence }}</td>
              <td style="border: solid 1px #ccc;">{{ $cval->description }}</td>
              <td style="border: solid 1px #ccc;">{{ $cval->pay_id }}</td>
            </tr>
          @empty
          <tr style="width: 100%">
            <td colspan="9" class="text-danger text-center" style="border: solid 1px #ccc;">Not Found</td>
          </tr>
          @endforelse
        </table>
        @endif
        @if($data->payment_type==3)
          <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
            <tr style="width: 100%">
              <th style="border: solid 1px #ccc;">Sr:</th>
              <th style="border: solid 1px #ccc;">Transaction Type</th>
              <th style="border: solid 1px #ccc;">Debit Account No</th>
              <th style="border: solid 1px #ccc;">IFSC</th>
              <th style="border: solid 1px #ccc;">Beneficiary Account No</th>
              <th style="border: solid 1px #ccc;">Beneficiary Name</th>
              <th style="border: solid 1px #ccc;">Amount</th>
              <th style="border: solid 1px #ccc;">Remarks For Client</th>
              <th style="border: solid 1px #ccc;">Remarks For Beneficiary</th>
              <th style="border: solid 1px #ccc;">ROutput Data</th>
            </tr>
            @forelse($data->bulkCsv as $ckey => $cval)
              <tr style="width: 100%">
                <td style="border: solid 1px #ccc;">{{ ++$ckey }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->transaction_type }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->debit_account_no }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->ifsc }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->beneficiary_account_no }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->beneficiary_name }}</td>
                <td style="border: solid 1px #ccc;">{{ env('CURRENCY_SYMBOL') }}{{ $cval->amount }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->remarks_for_client }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->remarks_for_beneficiary }}</td>
                <td style="border: solid 1px #ccc;">{{ $cval->output_data }}</td>
              </tr>
            @empty
            <tr style="width: 100%">
              <td colspan="10" class="text-danger text-center" style="border: solid 1px #ccc;">Not Found</td>
            </tr>
            @endforelse
            </table>
          @endif
    </td>
  </tr>
  @forelse($data->bulkReqImage as $key => $val)
    <tr style="width: 100%">
      <td style="border: solid 1px #ccc;">{!! Html::decode(link_to('public/'.$val->bulk_upload_file_path,\App\Helpers\Helper::getDocType($val->bulk_upload_file_path,$val->bulk_upload_file_type),['target'=>'_blank'])) !!}</td>
      <td colspan="2"><p>{{ $val->bulk_upload_file_description }}</p></td>
    </tr>
  @empty
  @endforelse
</table>

  