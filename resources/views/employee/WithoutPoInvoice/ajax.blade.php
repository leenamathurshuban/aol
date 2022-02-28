@if($type=='vendorOrderList')

  {{ Form::label('po_number','PO Number List') }}
  {!!Form::select('po_number', $data, '', ['placeholder' => 'Select PO Number','class'=>'form-control custom-select select2','id'=>'poList'])!!}



@elseif($type=='viewDetail')
<div class="row">
    <div class="col-md-12 model_title"><h3>Invoice No: {{ $data->invoice_number ?? '' }}  Unique Id {{ $data->order_id }}</h3>
    </div>

  <div class="col-md-12 vander_dataview">
    <ul>
      <li>
        <strong>Vendor:</strong><p>{{ json_decode($data->vendor_ary)->name ?? '' }}</p>
      </li>

      <li>
        <strong>Code:</strong><p>{{ json_decode($data->vendor_ary)->vendor_code ?? '' }}</p>
      </li>

      <li>
        <strong>Email:</strong><p>{{ json_decode($data->vendor_ary)->email ?? '' }}</p>
      </li>

      <li>
        <strong>Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->invoice_date) ?? '' }}</p>
      </li>
      {{--<li>
                    <strong>Advance Payment Mode:</strong><p>{{ $data->advance_payment_mode ?? '' }}</p>
                  </li>--}}
      

       <li>
        <strong>Amount:</strong><p>{{ env('CURRENCY_SYMBOL').''.$data->amount ?? '' }}</p>
      </li>
      <li>
        <strong>Tax:</strong><p>{{ $data->tax ?? '' }}%</p>
      </li>
      <li>
        <strong>Tax Amount:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->tax_amount }}</p>
      </li>
       <li>
        <strong>Invoice Amount:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->invoice_amount }}</p>
      </li>
      <li>
        <strong>TDS:</strong><p>{{ $data->tds }}%</p>
      </li>
      <li>
        <strong>TDS Section:</strong><p>{{ ($data->tds_month) ? $data->tds_month : '' }}
          {{-- ($data->tds_month) ? \App\Invoice::tdsMonth($data->tds_month) : '' --}}</p>
      </li>
      <li>
        <strong>TDS Amount:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->tds_amount ?? 0 }}</p>
      </li>
      <li>
        <strong>Net Payable:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->tds_payable ?? 0 }}</p>
      </li>

       <li>
          <strong>Specified Person:</strong><p>{{$data->specified_person ?? '' }}</p>
        </li>
      <li>
        <strong>Status:</strong><p>{{ \App\Invoice::invoiceStatus($data->invoice_status)}}</p>
      </li>
      <li>
        <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p>
      </li>
      @if(Auth::guard('employee')->user()->role_id!=4)
        <li>
          <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
        </li>
        <li>
          <strong>Transaction Date:</strong><p>{{ ($data->transaction_date) ? \App\Helpers\Helper::onlyDate($data->transaction_date) : '' }}</p>
        </li>
        <li>
          <strong>Date of Payment:</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p>
        </li>
      @endif
      
      <li>
        <strong>Employee:</strong><p>@if($data->employee_id)
                {{ json_decode($data->employee_ary)->name ?? '' }}
                @endif</p>
      </li>
       <li>
        <strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->employee_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->employee_ary)->email ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Created Date:</strong><p>{{ ($data->created_at) ? \App\Helpers\Helper::onlyDate($data->created_at) : '' }}</p>
      </li> 
      <li class="col-md-12">
        <strong>Comment:</strong><p>@if($data->employee_id) {{ json_decode($data->employee_ary)->employee_code ?? '' }}
                @endif</p>
      </li>

       <li>
        <strong>Manager:</strong><p> @if($data->approver_manager)
                {{ json_decode($data->manager_ary)->name ?? '' }} 
                @endif</p>
      </li>
      <li>
        <strong>Code:</strong><p>@if($data->approver_manager)
                {{ json_decode($data->manager_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->approver_manager)
                {{ json_decode($data->manager_ary)->email ?? '' }}
                @endif</p>
      </li>
       <li>
        <strong>Approval Date:</strong><p>{{ ($data->manager_date) ? \App\Helpers\Helper::onlyDate($data->manager_date) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p> @if($data->approver_manager)
                {{$data->manager_comment}}
                @endif</p>
      </li>

      <li>
        <strong>Accout Office:</strong><p> @if($data->approver_financer)
                 {{ json_decode($data->financer_ary)->name ?? '' }}
                @endif</p>
      </li>
       <li>
        <strong>Code:</strong><p>@if($data->approver_financer)
                {{ json_decode($data->financer_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->approver_financer)
                {{ json_decode($data->financer_ary)->email ?? '' }}
                @endif</p>
      </li>
       <li>
        <strong>Approval Date:</strong><p>{{ ($data->financer_date) ? \App\Helpers\Helper::onlyDate($data->financer_date) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p> @if($data->approver_financer){{$data->financer_comment}}
                @endif</p>
      </li>

       <li>
        <strong>Trust Office:</strong><p> @if($data->approver_trust)
                  {{ json_decode($data->approver_ary)->name ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Code:</strong><p>@if($data->approver_trust)
                {{ json_decode($data->approver_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->approver_trust)
                {{ json_decode($data->approver_ary)->email ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->trust_date) ? \App\Helpers\Helper::onlyDate($data->trust_date) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Trust Office:</strong><p> @if($data->approver_trust) {{$data->trust_comment}}
                @endif</p>
      </li>

      <li>
        <strong>Payment Office:</strong><p> @if($data->payment_ofc_id)
                  {{ json_decode($data->payment_ofc_ary)->name ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Code:</strong><p>@if($data->payment_ofc_id)
                {{ json_decode($data->payment_ofc_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->payment_ofc_id)
                {{ json_decode($data->payment_ofc_ary)->email ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p> @if($data->payment_ofc_id) {{$data->payment_ofc_comment}}
                @endif</p>
      </li>

      <li>
        <strong>TDS Office:</strong><p> @if($data->tds_ofc_id)
                  {{ json_decode($data->tds_ofc_ary)->name ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Code:</strong><p>@if($data->tds_ofc_id)
                {{ json_decode($data->tds_ofc_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->tds_ofc_id)
                {{ json_decode($data->tds_ofc_ary)->email ?? '' }}
                @endif</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p> @if($data->tds_ofc_id) {{$data->tds_ofc_comment}}
                @endif</p>
      </li>
      
        @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
            <li class="col-md-12">
              <table class="table" width="100%">
                <tr>
                  <th><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></th>
                  <th><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></th>
                  <th><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></th>
                </tr>
              </table>
            </li>
            <li class="col-md-12">
              <table class="table" width="100%">
                <tr>
                  <th>Sr.</th>
                  <th>Debit Account</th>
                  <th>Amount</th>
                  <th>Cost Center</th>
                  <th>Category</th>
                </tr>
                  @forelse($item->form_by_account as $itemKey => $itemVal)
                    <tr>
                      <td>{{++$itemKey}}</td>
                      <td>{{$itemVal->debit_account}}</td>
                      <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->amount}}</td>
                      <td>{{$itemVal->cost_center}}</td>
                      <td>{{$itemVal->category}}</td>
                    </tr>
                  @empty
                  @endforelse
                  
                </table>
              </li>
          @endif
      

      <li class="col-md-12">
        <strong>File:</strong> {!! Html::decode(link_to('public/'.$data->invoice_file_path,\App\Helpers\Helper::getDocType($data->invoice_file_path,$data->po_file_type),['target'=>'_blank'])) !!}
      </li>
    </ul>

    <div class="table-responsive">
        @if($data->item_detail)
          @php $item=json_decode($data->item_detail); @endphp
          <table class="table">
            <tr><td colspan="8"><h3>Item Detail</h3></td></tr>
            <tr>
              <th>Sr</th>
              <th>Item</th>
              <th>Quantity</th>
              <th>Rate</th>
              <th>Tax</th>
              <th>Tax value</th>
              <th>Comment</th>
              <th>Total</th>
            </tr>
            @forelse($item as $itemKey => $itemVal)
              <tr>
                <td>{{ ++$itemKey }}</td>
                <td>{{ $itemVal->item_name }}</td>
                <td>{{ $itemVal->quantity }} {{ $itemVal->unit }}</td>
                <td>{{ env('CURRENCY_SYMBOL').''.$itemVal->rate }}</td>
                <td>{{ $itemVal->tax }}%</td>
                <td>{{ env('CURRENCY_SYMBOL').''.$itemVal->tax_amt }}</td>
                <td>{{ $itemVal->price_unit }}</td>
                <td>{{ env('CURRENCY_SYMBOL').''.$itemVal->total }}</td>
              </tr>
            @empty
            @endforelse
          </table>
        @endif
      </div>
   
  
  </div>
 
</div>
@endif


