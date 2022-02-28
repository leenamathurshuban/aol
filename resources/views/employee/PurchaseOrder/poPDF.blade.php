@php $inr = Html::decode('<img src="'.url('assets/admin/inr-dark.png').'" style="height: 11px;">');@endphp
<table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
  <tr style="width: 100%; text-align: center;">
    <td colspan="3"><h3>PO No: {{ $data->order_id ?? '' }}</h3></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Vendor:</strong><p>{{ json_decode($data->vendor_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($data->vendor_ary)->vendor_code ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>{{ json_decode($data->vendor_ary)->email ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>PO Start Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>PO End Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->po_end_date) ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>PO Amount:</strong><p>{!! $inr !!}{{ $data->net_payable ?? '' }}</p></td>
  </tr>
  @php
    $invc=\App\Invoice::approvedPoInvoice($data->id);
  @endphp
  <tr style="width: 100%">
    {{--<td style="border: solid 1px #ccc;"><strong>PO Invoice Maximum Limit :</strong><p>{!! $inr !!}{{ \App\Invoice::invoiceLimit($data->net_payable) ?? '' }}</p></td>--}}
    <td style="border: solid 1px #ccc;" colspan="2"><strong>Invoice Approved:</strong><p>{!! $inr !!}{{ $invc }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Invoice In Process:</strong><p>{!! $inr !!}{{ \App\Invoice::proccessPoInvoice($data->id) }}</p></td>
  </tr>
   <tr style="width: 100%">
    <td style="border: solid 1px #ccc;" colspan="3"><strong>PO Balance:</strong><p>{!! $inr !!}{{ \App\Invoice::poBalance($data->id) }}</p></td>

  </tr>

  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Advance TDS:</strong><p>{{ $data->advance_tds ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Creater Name:</strong><p>{{ json_decode($data->user_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($data->user_ary)->employee_code ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Payment:</strong><p>{{ \App\PurchaseOrder::paymentMethod($data->payment_method) ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Nature Of Service:</strong><p>{{ \App\PurchaseOrder::natureOfService($data->nature_of_service) ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p></td>
  </tr>
  @if($data->level2_user_id)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Manager Name:</strong><p>{{ json_decode($data->level2_user_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($data->level2_user_ary)->employee_code ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Mobile:</strong><p>{{ json_decode($data->level2_user_ary)->mobile_code ?? '' }} {{ json_decode($data->level2_user_ary)->mobile ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td colspan="3"><strong>Manager Comments:</strong><p>{{ $data->account_status_level2_comment ?? '' }}</p></td>
  </tr>
   @endif
   <tr style="width: 100%">
     <td colspan="3"><strong>Service Detail:</strong><p>{{ $data->service_detail ?? '' }}</p></td>
   </tr>
   @if($data->item_detail)
   <tr style="width: 100%">
     <td colspan="3" style="padding: 0px;">
       @php $item=json_decode($data->item_detail); @endphp
          <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
            <tr style="width: 100%;text-align: center;"><td colspan="8"><h3>Item Detail</h3></td></tr>
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
            @if($item)
              <tfoot>
                <tr style="width: 100%">
                  <td colspan="7" class="text-right" style="border: solid 1px #ccc;">Grand Total:</td>
                  <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $data->total ?? '' }}</td>
                </tr>
                <tr style="width: 100%">
                  <td colspan="7" class="text-right" style="border: solid 1px #ccc;">Discount:</td>
                  <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $data->discount ?? '' }}</td>
                </tr>
                <tr style="width: 100%">
                  <td colspan="7" class="text-right" style="border: solid 1px #ccc;">Net Payable:</td>
                  <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $data->net_payable ?? '' }}</td>
                </tr>
              </tfoot>
            @endif
          </table>
     </td>
   </tr>
   @endif
   @if($data->approved_user_id)
    <tr style="width: 100%">
      <td style="border: solid 1px #ccc;"><strong>Trust Office:</strong><p>{{ json_decode($data->approved_user_ary)->name ?? '' }}</p></td>
      <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($data->approved_user_ary)->employee_code ?? '' }}</p></td>
      <td style="border: solid 1px #ccc;"><strong>Mobile:</strong><p>{{ json_decode($data->approved_user_ary)->mobile_code ?? '' }} {{ json_decode($data->approved_user_ary)->mobile ?? '' }}</p></td>
    </tr>
   @endif
   @if($data->account_status_level3_comment)
      <tr style="width: 100%">
        <td colspan="3"><strong>Financer Comments:</strong> <p>{{ $data->account_status_level3_comment ?? '' }}</p></td>
      </tr>
    @endif
    <tr style="width: 100%">
      <td colspan="3">
        <p> <strong>PO Desciption :</strong> {{ $data->po_description }}</p>
      </td>
    </tr>
    @forelse($data->poImage as $key => $val)
    <tr style="width: 100%">
      <td style="border: solid 1px #ccc;">{!! Html::decode(link_to('public/'.$val->po_file_path,\App\Helpers\Helper::getDocType($val->po_file_path,$val->po_file_type),['target'=>'_blank'])) !!}</td>
       <td colspan="2"><p>{{ $val->po_file_description }}</p></td>
    </tr>
     @empty
    @endforelse
     @if(\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->id])->count())
    <tr style="width: 100%">
      <td colspan="3" style="padding: 0px;">
        <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
          <tr style="width: 100%;text-align: center;"><td colspan="9"><h3>Approved Invoice Detail</h3></td></tr>
          <tr style="width: 100%">
            <th style="border: solid 1px #ccc;">Sr</th>
            <th style="border: solid 1px #ccc;">Date</th>
            <th style="border: solid 1px #ccc;">No:</th>
            <th style="border: solid 1px #ccc;">Amount</th>
            <th style="border: solid 1px #ccc;">Status</th>
            <th style="border: solid 1px #ccc;">Employee</th>
            <th style="border: solid 1px #ccc;">Manager</th>
            <th style="border: solid 1px #ccc;">Financer</th>
            <th style="border: solid 1px #ccc;">Trust Office</th>
            <th style="border: solid 1px #ccc;">File</th>
          </tr>
          @forelse(\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->id])->get() as $itemKey => $itemVal)
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;">{{ ++$itemKey }}</td>
              <td style="border: solid 1px #ccc;">{{ \App\Helpers\Helper::onlyDate($itemVal->invoice_date) ?? '' }}</td>
               <td style="border: solid 1px #ccc;">{{ $itemVal->invoice_number }}</td>
              <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $itemVal->invoice_amount }} </td>
              <td style="border: solid 1px #ccc;">
                  {{ \App\Invoice::invoiceStatus($itemVal->invoice_status)}}
              </td>
              <td style="border: solid 1px #ccc;">
                @if($itemVal->employee_id)
                {{ json_decode($itemVal->employee_ary)->name ?? '' }} {{ json_decode($itemVal->employee_ary)->employee_code ?? '' }}
                @endif
              </td>
              <td style="border: solid 1px #ccc;">
                @if($itemVal->approver_manager)
                {{ json_decode($itemVal->manager_ary)->name ?? '' }} {{ json_decode($itemVal->manager_ary)->employee_code ?? '' }}<br>
                Comment: {{$itemVal->manager_comment}}
                @endif
              </td>
              <td style="border: solid 1px #ccc;">
                @if($itemVal->approver_financer)
                 {{ json_decode($itemVal->financer_ary)->name ?? '' }} {{ json_decode($itemVal->financer_ary)->employee_code ?? '' }}<br>
                 Comment: {{$itemVal->financer_comment}}
                @endif
              </td>
              <td style="border: solid 1px #ccc;">
                @if($itemVal->approver_trust)
                  {{ json_decode($itemVal->approver_ary)->name ?? '' }} {{ json_decode($itemVal->approver_ary)->employee_code ?? '' }}<br>
                  Comment: {{$itemVal->trust_comment}}
                @endif
              </td>
              <td style="border: solid 1px #ccc;">
                 {!! Html::decode(link_to('public/'.$itemVal->invoice_file_path,\App\Helpers\Helper::getDocType($itemVal->invoice_file_path,$itemVal->po_file_type),['target'=>'_blank'])) !!}

              </td>
            </tr>
          @empty
          @endforelse
         
           {{-- <tfoot>
              <tr style="width: 100%">
                <td colspan="4" class="text-right">PO Total Amount:</td>
                <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $data->order_amount ?? '' }}</td>
              </tr>
              <tr style="width: 100%">
                <td colspan="4" class="text-right">Approved Invoice Amount:</td>
                <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $data->invoice_amount ?? '' }}</td>
              </tr>
              <tr style="width: 100%">
                <td colspan="4" class="text-right">Pending Amount:</td>
                <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $data->invoice_balance ?? '' }}</td>
              </tr>
            </tfoot>--}}
        </table>
      </td>
    </tr>
    @endif
</table>
