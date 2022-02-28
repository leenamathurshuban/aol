@php $inr = Html::decode('<img src="'.url('assets/admin/inr-dark.png').'" style="height: 11px;">');@endphp
<table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
  <tr style="width: 100%">
    <th style="text-align: center;width: 100%" colspan="3"><h3>Request No: {{ $data->order_id ?? '' }}</h3></th>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Pay For:</strong><p>{{ $data->nature_of_request ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Request Status:</strong><p>{{ \App\InternalTransfer::requestStatus($data->status)}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Requested Employee:</strong><p>{{json_decode($data->employee_ary)->name ?? ''}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Requested Employee Code:</strong><p>{{json_decode($data->employee_ary)->employee_code ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Requested Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->employee_date) ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Amount:</strong><p>{!! $inr !!}{{ $data->amount ?? '0' }}</p></td>
  </tr>
  @if(Auth::guard('employee')->user()->role_id!=4)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
    </td>
    <td style="border: solid 1px #ccc;" colspan="">
      <strong>Transaction Date:</strong><p>{{ ($data->transaction_date) ? \App\Helpers\Helper::onlyDate($data->transaction_date) : '' }}</p>
    </td>
    <td style="border: solid 1px #ccc;" colspan="">
      <strong>Date of Payment:</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p>
    </td>
  </tr>
  @endif
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p></td>
    @if($data->nature_of_request=='State requesting funds')
    <td style="border: solid 1px #ccc;"><strong>State:</strong><p>{{json_decode($data->apex_ary)->name ?? ''}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Bank Name:</strong><p>{{ json_decode($data->state_bank_ary)->bank_name ?? '' }}</p></td>
    @endif
  </tr>
  @if($data->nature_of_request=='State requesting funds')
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Bank Account Number:</strong><p>{{ json_decode($data->state_bank_ary)->bank_account_number ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Bank IFSC:</strong><p>{{ json_decode($data->state_bank_ary)->ifsc ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Bank Branch Address:</strong><p>{{ json_decode($data->state_bank_ary)->branch_address ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Bank Account Holder:</strong><p>{{ json_decode($data->state_bank_ary)->bank_account_holder ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Project Name:</strong><p>{{ $data->project_name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Reason:</strong><p>{{ $data->reason ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Project Id:</strong><p>{{ $data->project_id ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Cost Center:</strong><p>{{ $data->cost_center ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"></td>
  </tr>
  @elseif($data->nature_of_request=='Inter bank transfer')
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Transfer From Bank:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>From Account Number:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_account_number ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>From Bank IFSC:</strong><p>{{ json_decode($data->transfer_from_ary)->ifsc ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>From Bank Branch Address:</strong><p>{{ json_decode($data->transfer_from_ary)->branch_address ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>From Bank Account Holder:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_account_holder ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Transfer To Bank:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_name ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>To Account Number:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_account_number ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>To Bank IFSC:</strong><p>{{ json_decode($data->transfer_to_ary)->ifsc ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>To Bank Branch Address:</strong><p>{{ json_decode($data->transfer_to_ary)->branch_address ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan=""><strong>To Bank Account Holder:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_account_holder ?? '' }}</p></td>
    <td colspan=""></td>
    <td colspan=""></td>
  </tr>
  @if($data->form_by_account)
    @php $item=json_decode($data->form_by_account); @endphp
    {{-- <tr style="width: 100%;">
        <td style="border: solid 1px #ccc;">
          <strong>Bank Account</strong><p>{{$item->bank_account}}</p>
        </td>
        <td style="border: solid 1px #ccc;">
          <strong>IFSC</strong><p>{{$item->ifsc}}</p>
        </td>
        <td style="border: solid 1px #ccc;">
          <strong>Bank Name</strong><p>{{$item->bank_name}}</p>
        </td>
     </tr>--}}
     
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
  @else
  @endif
  @if($data->account_dept_id && $data->account_dept_ary)
      <tr style="width: 100%">
        <td style="border: solid 1px #ccc;"><strong>Account Office:</strong><p>{{json_decode($data->account_dept_ary)->name ?? ''}}</p></td>
        <td style="border: solid 1px #ccc;"> <strong>Account Code:</strong><p>{{json_decode($data->account_dept_ary)->employee_code ?? ''}}</p></td>
        <td style="border: solid 1px #ccc;"><strong>Account Comment:</strong><p>{{$data->account_dept_comment}}</p></td>
      </tr>
    @endif

    @if($data->trust_ofc_id && $data->trust_ofc_ary)
    <tr style="width: 100%">
        <td style="border: solid 1px #ccc;"><strong>Trust Office:</strong><p>{{json_decode($data->trust_ofc_ary)->name ?? ''}}</p></td>
        <td style="border: solid 1px #ccc;"> <strong>Trust Code:</strong><p>{{json_decode($data->trust_ofc_ary)->employee_code ?? ''}}</p></td>
        <td style="border: solid 1px #ccc;"><strong>Trust Comment:</strong><p>{{$data->trust_ofc_comment}}</p></td>
      </tr>
    @endif

    @if($data->payment_ofc_id && $data->payment_ofc_ary)
    <tr style="width: 100%">
        <td style="border: solid 1px #ccc;"><strong>Payment Office:</strong><p>{{json_decode($data->payment_ofc_ary)->name ?? ''}}</p></td>
        <td style="border: solid 1px #ccc;"> <strong>Payment Code:</strong><p>{{json_decode($data->payment_ofc_ary)->employee_code ?? ''}}</p></td>
        <td style="border: solid 1px #ccc;"><strong>Payment Comment:</strong><p>{{$data->payment_ofc_comment}}</p></td>
      </tr>
    @endif


  @forelse($data->internalTransferImage as $key => $val)
    <tr style="width: 100%">
        <td style="border: solid 1px #ccc;">{!! Html::decode(link_to('public/'.$val->internal_transfer_file_path,\App\Helpers\Helper::getDocType($val->internal_transfer_file_path,$val->internal_transfer_file_type),['target'=>'_blank'])) !!}</td>
        <td colspan="2"><p>{{ $val->internal_transfer_file_description }}</p></td>
      </tr>
    @empty
    @endforelse
</table>
 
   

    