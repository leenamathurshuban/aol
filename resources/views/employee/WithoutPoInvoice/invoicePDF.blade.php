@php $inr = Html::decode('<img src="'.url('assets/admin/inr-dark.png').'" style="height: 11px;">');@endphp
<table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
  <tr style="width: 100%">
    <th style="text-align: center;width: 100%" colspan="3"><strong>Invoice No:</strong> <p>{{ $data->invoice_number ?? '' }}</p></th>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Vendor:</strong><p>{{ json_decode($data->vendor_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($data->vendor_ary)->vendor_code ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>{{ json_decode($data->vendor_ary)->email ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->invoice_date) ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Amount:</strong><p>{!! $inr !!}{{$data->amount ?? '' }}%</p></td>
    <td style="border: solid 1px #ccc;"><strong>Tax:</strong><p>{{ $data->tax ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Tax Amount:</strong><p>{!! $inr !!}{{ $data->tax_amount }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Invoice Amount:</strong><p>{!! $inr !!}{{ $data->invoice_amount }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Specified Person:</strong><p>{{$data->specified_person ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>TDS:</strong><p>{!! $inr !!}{{ $data->tds }}%</p></td>
    <td style="border: solid 1px #ccc;"><strong>TDS Amount:</strong><p>{!! $inr !!}{{ $data->tds_amount }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>TDS Section:</strong><p>{{ ($data->tds_month) ? $data->tds_month : '' }}{{-- ($data->tds_month) ? \App\Invoice::tdsMonth($data->tds_month) : '' --}}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;" colspan="3"><strong>Net Payable:</strong><p>{!! $inr !!}{{ $data->tds_payable }}</p></td>
  </tr>
  @if(Auth::guard('employee')->user()->role_id!=4)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;" colspan="">
      <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Transaction Date:</strong><p>{{ ($data->transaction_date) ? \App\Helpers\Helper::onlyDate($data->transaction_date) : '' }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Date of Payment:</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p>
    </td>
  </tr>
  @endif
 
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Status:</strong><p>{{ \App\Invoice::invoiceStatus($data->invoice_status)}}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"></td>
  </tr>
  <tr style="width: 100%">
     <td style="border: solid 1px #ccc;"><strong>Employee:</strong><p>@if($data->employee_id)
                {{ json_decode($data->employee_ary)->name ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"> <strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->employee_ary)->employee_code ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"> <strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->employee_ary)->email ?? '' }}
                @endif</p></td>
   
  </tr>
  <tr style="width: 100%">
    <td colspan="3" style="border: solid 1px #ccc;">
      <strong>Comment:</strong><p>@if($data->employee_id) {{ json_decode($data->employee_ary)->employee_code ?? '' }}
                @endif</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Manager:</strong><p>@if($data->approver_manager)
                {{ json_decode($data->manager_ary)->name ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>@if($data->approver_manager)
                {{ json_decode($data->manager_ary)->employee_code ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>@if($data->approver_manager)
                {{ json_decode($data->manager_ary)->email ?? '' }}
                @endif</p></td>
    
  </tr>
   <tr style="width: 100%">
    <td colspan="3" style="border: solid 1px #ccc;">
      <strong>Comment:</strong><p> @if($data->approver_manager)
                {{$data->manager_comment}}
                @endif</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Accout Office:</strong><p> @if($data->approver_financer)
                 {{ json_decode($data->financer_ary)->name ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->financer_ary)->employee_code ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->financer_ary)->email ?? '' }}
                @endif</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3" style="border: solid 1px #ccc;">
      <strong>Comment:</strong><p> @if($data->approver_financer){{$data->financer_comment}}
                @endif</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Trust Office:</strong><p> @if($data->approver_trust)
                  {{ json_decode($data->approver_ary)->name ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->approver_ary)->employee_code ?? '' }}
                @endif</p></td>
     <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->approver_ary)->email ?? '' }}
                @endif</p></td>
  </tr>
  <tr style="width: 100%">
   <td style="border: solid 1px #ccc;"><strong>Comment:</strong></td>
    <td colspan="2" style="border: solid 1px #ccc;"><p> @if($data->approver_trust) {{$data->trust_comment}}
                @endif</p></td>
    
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Payment Office:</strong><p> @if($data->approver_trust)
                  {{ json_decode($data->payment_ofc_ary)->name ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>@if($data->payment_ofc_id)
                {{ json_decode($data->payment_ofc_ary)->employee_code ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>@if($data->payment_ofc_id)
                {{ json_decode($data->payment_ofc_ary)->email ?? '' }}
                @endif</p></td>
    </tr>
    <tr>
    <td style="border: solid 1px #ccc;"><strong>Comment:</strong></td>
    <td colspan="2" style="border: solid 1px #ccc;"><p> @if($data->payment_ofc_id) {{$data->payment_ofc_comment}}
                @endif</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>TDS Office:</strong><p> @if($data->tds_ofc_id)
                  {{ json_decode($data->tds_ofc_ary)->name ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>@if($data->tds_ofc_id)
                {{ json_decode($data->tds_ofc_ary)->employee_code ?? '' }}
                @endif</p></td>
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>@if($data->tds_ofc_id)
                {{ json_decode($data->tds_ofc_ary)->email ?? '' }}
                @endif</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3" style="border: solid 1px #ccc;"><strong>Comment:</strong><p> @if($data->tds_ofc_id) {{$data->tds_ofc_comment}}
                @endif</p></td>
    
  </tr>
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
              <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;" cellpadding="5" cellspacing="0">
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
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>File:</strong></td>
    <td style="border: solid 1px #ccc;">{!! Html::decode(link_to('public/'.$data->invoice_file_path,\App\Helpers\Helper::getDocType($data->invoice_file_path,$data->po_file_type),['target'=>'_blank'])) !!}</td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3" style="padding: 0px;">
      @if($data->item_detail)
          @php $item=json_decode($data->item_detail); @endphp
          <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;" cellpadding="5" cellspacing="0">
            <tr style="width: 100%"><td colspan="8"><h3>Item Detail</h3></td></tr>
            <tr style="width: 100%">
              <th style="border: solid 1px #ccc;">Sr</th>
              <th style="border: solid 1px #ccc;">Item</th>
              <th style="border: solid 1px #ccc;">Quantity</th>
              <th style="border: solid 1px #ccc;">Rate</th>
              <th style="border: solid 1px #ccc;">Tax</th>
              <th style="border: solid 1px #ccc;">Tax value</th>
              <th style="border: solid 1px #ccc;">Comment</th>
              <th style="border: solid 1px #ccc;">Total</th>
            </tr>
            @forelse($item as $itemKey => $itemVal)
              <tr style="width: 100%">
                <td style="border: solid 1px #ccc;">{{ ++$itemKey }}</td>
                <td style="border: solid 1px #ccc;">{{ $itemVal->item_name }}</td>
                <td style="border: solid 1px #ccc;">{{ $itemVal->quantity }} {{ $itemVal->unit }}</td>
                <td style="border: solid 1px #ccc;">{!! $inr !!}{{$itemVal->rate }}</td>
                <td style="border: solid 1px #ccc;">{{ $itemVal->tax }}%</td>
                <td style="border: solid 1px #ccc;">{!! $inr !!}{{$itemVal->tax_amt }}</td>
                <td style="border: solid 1px #ccc;">{{ $itemVal->price_unit }}</td>
                <td style="border: solid 1px #ccc;">{!! $inr !!}{{$itemVal->total }}</td>
              </tr>
            @empty
            @endforelse
          </table>
        @endif
    </td>
  </tr>
</table>


      {{--<li><strong>Advance Payment Mode:</strong><p>{{ $data->advance_payment_mode ?? '' }}</p></li>--}}
    
     
      