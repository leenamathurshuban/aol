@php $inr = Html::decode('<img src="'.url('assets/admin/inr-dark.png').'" style="height: 11px;">');@endphp
<table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;" cellpadding="5" cellspacing="0">
  <tr style="width: 100%">
    <th style="text-align: center;width: 100%" colspan="3"><h3>PO No: {{ $po->order_id ?? '' }}</h3></th>
  </tr> 
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Vendor:</strong><p>{{ json_decode($po->vendor_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($po->vendor_ary)->vendor_code ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>{{ json_decode($po->vendor_ary)->email ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>PO Start Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($po->po_start_date) ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>PO End Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($po->po_end_date) ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>PO Total:</strong><p>{!! $inr !!}{{ $po->net_payable ?? '' }}</p></td>
  </tr>
  @php
    $invc=\App\Invoice::approvedPoInvoice($po->id);
  @endphp
  <tr style="width: 100%">
   {{-- <td style="border: solid 1px #ccc;"><strong>PO Invoice Limit :</strong><p>{!! $inr !!}{{ \App\Invoice::invoiceLimit($po->net_payable) ?? '' }}</p></td>--}}
    <td style="border: solid 1px #ccc;" colspan="2"><strong>Invoice Approved:</strong><p>{!! $inr !!}{{ $invc }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>PO Balance:</strong><p>{!! $inr !!}{{ $po->net_payable-$invc }}</p></td>
  </tr>
  @if($data)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;" colspan="3"><h3>Invoice Detail</h3></td>
  </tr>
    <tr style="width: 100%">
      <td style="border: solid 1px #ccc;padding:0;" colspan="3">
        <table style="width: 100%; font-size: 12px; text-align: left; border-collapse: collapse; border: solid 1px #ccc;" cellpadding="5" cellspacing="0">
          @forelse($data as $itemKey => $itemVal)
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;"><strong>Sr: </strong>{{ ++$itemKey }}</td>
              <td style="border: solid 1px #ccc;"><strong>Date:</strong>{{ \App\Helpers\Helper::onlyDate($itemVal->invoice_date) ?? '' }}</td>
              <td style="border: solid 1px #ccc;"><strong>Invoice No:</strong>{{ $itemVal->invoice_number }}</td>
              <td style="border: solid 1px #ccc;"><strong>Payment Mode:</strong>{{ $itemVal->advance_payment_mode }}</td>
              <td style="border: solid 1px #ccc;"><strong>Amount:</strong>{!! $inr !!} {{ $itemVal->amount }}</td>
            </tr>
            <tr width="100%">
              <td style="border: solid 1px #ccc;"><strong>Tax:</strong>{{ $itemVal->tax }}%</td>
              <td style="border: solid 1px #ccc;"><strong>Tax Amount:</strong>{!! $inr !!} {{ $itemVal->tax_amount }}</td>
              <td style="border: solid 1px #ccc;"><strong>Invoice Amount:</strong>{!! $inr !!} {{ $itemVal->invoice_amount }}</td>
              <td style="border: solid 1px #ccc;"><strong>TDS:</strong>{{ $itemVal->tds }}% @if($itemVal->tds_month) {{--\App\Invoice::tdsMonth($itemVal->tds_month) --}}{{ $itemVal->tds_month }}<br>@endif</td>
              <td style="border: solid 1px #ccc;"><strong>TDS Section:</strong>{!! $inr !!} {{ $itemVal->tds_amount }}</td>
            </tr>
            <tr width="100%">
              <td style="border: solid 1px #ccc;"><strong>Net Payable:</strong>{!! $inr !!} {{ $itemVal->tds_payable }}</td>
              <td style="border: solid 1px #ccc;"><strong>Status:</strong>{{ \App\Invoice::invoiceStatus($itemVal->invoice_status)}}</td>
              <td style="border: solid 1px #ccc;"><strong>Employee:</strong>{{ json_decode($itemVal->employee_ary)->name ?? '' }}</td>
              <td style="border: solid 1px #ccc;"><strong>Employee Code:</strong>{{ json_decode($itemVal->employee_ary)->employee_code ?? '' }}</td>
              <td style="border: solid 1px #ccc;"><strong>Manager:</strong>{{ json_decode($itemVal->manager_ary)->name ?? '' }}</td>
            </tr>
             <tr width="100%">
                <td style="border: solid 1px #ccc;"><strong>Comment:</strong>{{$itemVal->manager_comment}}</td>
                <td style="border: solid 1px #ccc;"><strong>Accout Office:</strong>{{ json_decode($itemVal->financer_ary)->name ?? '' }}</td>
                <td style="border: solid 1px #ccc;"><strong>Comment:</strong>{{$itemVal->financer_comment}}</td>
                <td style="border: solid 1px #ccc;"><strong>Trust Office:</strong>{{ json_decode($itemVal->approver_ary)->name ?? '' }}</td>
                <td style="border: solid 1px #ccc;"><strong>Comment:</strong>{{$itemVal->trust_comment}}</td>
              </tr>
            <tr>
              <td style="border: solid 1px #ccc;" colspan="5">
                  {!! Html::decode(link_to('public/'.$itemVal->invoice_file_path,\App\Helpers\Helper::getDocType($itemVal->invoice_file_path,$itemVal->po_file_type),['target'=>'_blank'])) !!}
              </td>
            </tr>
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;padding:0;" colspan="5">
                @if($itemVal->item_detail)
                   @php $sub_item=json_decode($itemVal->item_detail); @endphp
                    <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;" cellpadding="5" cellspacing="0">
                      <tr style="width: 100%">
                        <td style="border: solid 1px #ccc;" colspan="8"><h3>Item Detail</h3></td></tr>
                      <tr style="width: 100%;text-align: left !important;">
                        <th style="border: solid 1px #ccc;">Sr</th>
                        <th style="border: solid 1px #ccc;">Item</th>
                        <th style="border: solid 1px #ccc;">Quantity</th>
                        <th style="border: solid 1px #ccc;">Rate</th>
                        <th style="border: solid 1px #ccc;">Tax</th>
                        <th style="border: solid 1px #ccc;">Tax value</th>
                        <th style="border: solid 1px #ccc;">Comment</th>
                        <th style="border: solid 1px #ccc;">Total</th>
                      </tr>
                      @forelse($sub_item as $subKey => $subVal)
                        <tr style="width: 100%">
                          <td style="border: solid 1px #ccc;">{{ ++$subKey }}</td>
                          <td style="border: solid 1px #ccc;">{{ $subVal->item_name }}</td>
                          <td style="border: solid 1px #ccc;">{{ $subVal->quantity }} {{ $subVal->unit }}</td>
                          <td style="border: solid 1px #ccc;">{!! $inr !!} {{$subVal->rate }}</td>
                          <td style="border: solid 1px #ccc;">{{ $subVal->tax }}%</td>
                          <td style="border: solid 1px #ccc;">{!! $inr !!} {{$subVal->tax_amt }}</td>
                          <td style="border: solid 1px #ccc;">{{ $subVal->price_unit }}</td>
                          <td style="border: solid 1px #ccc;">{!! $inr !!} {{$subVal->total }}</td>
                        </tr>
                      @empty
                      @endforelse
                    </table>
                @endif
              </td>
            </tr>
            @if($itemVal->form_by_account)
              @php $item=json_decode($itemVal->form_by_account); @endphp
               <tr style="width: 100%">
                  <td style="border: solid 1px #ccc;" colspan="2">
                    <strong>Bank Account</strong><p>{{$item->bank_account}}</p>
                  </td>
                  <td style="border: solid 1px #ccc;">
                    <strong>IFSC</strong><p>{{$item->ifsc}}</p>
                  </td>
                  <td style="border: solid 1px #ccc;" colspan="2">
                    <strong>Bank Name</strong><p>{{$item->bank_name}}</p>
                  </td>
               </tr>
            @endif
            @if(Auth::guard('employee')->user()->role_id!=4)
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;" colspan="2">
                <strong>Transaction Id:</strong><p>{{ $itemVal->transaction_id }}</p>
              </td>
              <td style="border: solid 1px #ccc;" colspan="2">
                <strong>Transaction Date:</strong><p>{{ ($itemVal->transaction_date) ? \App\Helpers\Helper::onlyDate($itemVal->transaction_date) : '' }}</p>
              </td>
              <td style="border: solid 1px #ccc;" colspan="">
                <strong>Date of Payment:</strong><p>{{ ($itemVal->date_of_payment) ? \App\Helpers\Helper::onlyDate($itemVal->date_of_payment) : '' }}</p>
              </td>
            </tr>
            @endif
            <tr style="width: 100%">
              <td colspan="5" style="padding:0;border: solid 1px #ccc;">
              @if($itemVal->form_by_account)
                  @php $item=json_decode($itemVal->form_by_account); @endphp
                    <table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;" cellpadding="5" cellspacing="0">
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
          @empty
          @endforelse
         
        </table>
      </td>
    </tr>
  @endif
</table>