@if($type=='getCityByState')

  {{ Form::label('City',$states->name."'s city") }}
  {!!Form::select('city', $cities, '', ['placeholder' => 'Select City','class'=>'form-control custom-select select2','id'=>''])!!}

 <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })


    })
  </script>

@elseif($type=='viewDetail')
<div class="row">
   <div class="col-md-12 model_title"><h3>PO No: {{ $data->order_id ?? '' }}</h3>
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
            <strong>PO Start Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '' }}</p>
          </li>

          <li>
            <strong>PO End Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->po_end_date) ?? '' }}</p>
          </li>

          <li>
            <strong>PO Total:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable ?? '' }}</p>
          </li>

          @php
            $invc=\App\Invoice::approvedPoInvoice($data->id);
          @endphp
          
          {{-- <li>
            <strong>PO Invoice Maximum Limit :</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::invoiceLimit($data->net_payable) ?? '' }}</p>
          </li>--}}

          <li>
            <strong>Invoice Approved:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $invc }}</p>
          </li>

          <li>
            <strong>Invoice In Process:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::proccessPoInvoice($data->id) }}</p>
          </li>

          <li class="w-33">
            <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::poBalance($data->id) }}</p>
          </li>
 
          <li>
            <strong>Advance TDS:</strong><p>{{ $data->advance_tds ?? '' }}</p>
          </li>

          <li>
            <strong>Creater Name:</strong><p>{{ json_decode($data->user_ary)->name ?? '' }}</p>
          </li>

           <li>
            <strong>Code:</strong><p>{{ json_decode($data->user_ary)->employee_code ?? '' }}</p>
          </li>

          <li>
            <strong>Created Date:</strong><p>{{ ($data->created_at) ? \App\Helpers\Helper::onlyDate($data->created_at) : '' }}</p>
          </li>

          <li>
            <strong>Payment:</strong><p>{{ \App\PurchaseOrder::paymentMethod($data->payment_method) ?? '' }}</p>
          </li>

           <li>
            <strong>Nature Of Service:</strong><p>{{ \App\PurchaseOrder::natureOfService($data->nature_of_service) ?? '' }}</p>
          </li>

          <li>
            <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p>
          </li>
          
          @if($data->level2_user_id)
            <li>
              <strong>Manager Name:</strong><p>{{ json_decode($data->level2_user_ary)->name ?? '' }}</p>
            </li>

             <li>
              <strong>Code:</strong><p>{{ json_decode($data->level2_user_ary)->employee_code ?? '' }}</p>
            </li>

             <li>
              <strong>Mobile:</strong><p>{{ json_decode($data->level2_user_ary)->mobile_code ?? '' }} {{ json_decode($data->level2_user_ary)->mobile ?? '' }}</p>
            </li>
            <li>
                <strong>Approval Date:</strong><p>{{ ($data->level_two_date) ? \App\Helpers\Helper::onlyDate($data->level_two_date) : '' }}</p>
            </li>
            <li class="col-md-12">
              <strong>Manager Comments:</strong><p>{{ $data->account_status_level2_comment ?? '' }}</p>
            </li>

            

          @endif
          @if($data->approved_user_id)
          <li>
            <strong>Trust Office:</strong><p>{{ json_decode($data->approved_user_ary)->name ?? '' }}</p>
          </li>

           <li>
            <strong>Code:</strong><p>{{ json_decode($data->approved_user_ary)->employee_code ?? '' }}</p>
          </li>

           <li>
            <strong>Mobile:</strong><p>{{ json_decode($data->approved_user_ary)->mobile_code ?? '' }} {{ json_decode($data->approved_user_ary)->mobile ?? '' }}</p>
          </li>
          <li>
                <strong>Approval Date:</strong><p>{{ ($data->level_three_date) ? \App\Helpers\Helper::onlyDate($data->level_three_date) : '' }}</p>
            </li>
        @endif

        @if($data->account_status_level3_comment)
          <li class="col-md-12 specify_other">
          <strong>Financer Comments:</strong> <p>{{ $data->account_status_level3_comment ?? '' }}</p>
        </li>
        @endif
          <li class="col-md-12">
            <strong>Service Detail:</strong><p>{{ $data->service_detail ?? '' }}</p>
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
            @if($item)
              <tfoot>
                <tr>
                  <td colspan="7" class="text-right">Grand Total:</td>
                  <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->total ?? '' }}</td>
                </tr>
                <tr>
                  <td colspan="7" class="text-right">Discount:</td>
                  <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->discount ?? '' }}</td>
                </tr>
                <tr>
                  <td colspan="7" class="text-right">Net Payable:</td>
                  <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable ?? '' }}</td>
                </tr>
              </tfoot>
            @endif
          </table>
        @endif
      </div>

      <div class="col-md-12">
          <p> <strong>PO Desciption :</strong> {{ $data->po_description }}</p>
        </div>
    </div>
    @forelse($data->poImage as $key => $val)
      <div class="col-md-2">
       <div class="gallery_imgct">
            {!! Html::decode(link_to('public/'.$val->po_file_path,\App\Helpers\Helper::getDocType($val->po_file_path,$val->po_file_type),['target'=>'_blank'])) !!}
        <p>{{ $val->po_file_description }}</p>
       </div>
      </div>
    @empty
    @endforelse
     @if(\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->id])->count())
        <table class="table">
          <tr><td colspan="9"><h3>Approved Invoice Detail</h3></td></tr>
          <tr>
            <th>Sr</th>
            <th>Date</th>
            <th>Unique Id</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Employee</th>
            <th>Manager</th>
            <th>Financer</th>
            <th>Trust Office</th>
            <th>File</th>
          </tr>
          @forelse(\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->id])->get() as $itemKey => $itemVal)
            <tr>
              <td>{{ ++$itemKey }}</td>
              <td>{{ \App\Helpers\Helper::onlyDate($itemVal->invoice_date) ?? '' }}</td>
               <td>{{ $itemVal->order_id }}</td>
              <td>{{ env('CURRENCY_SYMBOL').''. $itemVal->invoice_amount }} </td>
              <td>
                  {{ \App\Invoice::invoiceStatus($itemVal->invoice_status)}}
              </td>
              <td>
                @if($itemVal->employee_id)
                {{ json_decode($itemVal->employee_ary)->name ?? '' }} {{ json_decode($itemVal->employee_ary)->employee_code ?? '' }}
                @endif
              </td>
              <td>
                @if($itemVal->approver_manager)
                {{ json_decode($itemVal->manager_ary)->name ?? '' }} {{ json_decode($itemVal->manager_ary)->employee_code ?? '' }}<br>
                Comment: {{$itemVal->manager_comment}}
                @endif
              </td>
              <td>
                @if($itemVal->approver_financer)
                 {{ json_decode($itemVal->financer_ary)->name ?? '' }} {{ json_decode($itemVal->financer_ary)->employee_code ?? '' }}<br>
                 Comment: {{$itemVal->financer_comment}}
                @endif
              </td>
              <td>
                @if($itemVal->approver_trust)
                  {{ json_decode($itemVal->approver_ary)->name ?? '' }} {{ json_decode($itemVal->approver_ary)->employee_code ?? '' }}<br>
                  Comment: {{$itemVal->trust_comment}}
                @endif
              </td>
              <td>
                 {!! Html::decode(link_to('public/'.$itemVal->invoice_file_path,\App\Helpers\Helper::getDocType($itemVal->invoice_file_path,$itemVal->po_file_type),['target'=>'_blank'])) !!}

              </td>
            </tr>
          @empty
          @endforelse
         
           {{-- <tfoot>
              <tr>
                <td colspan="4" class="text-right">PO Total Amount:</td>
                <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->order_amount ?? '' }}</td>
              </tr>
              <tr>
                <td colspan="4" class="text-right">Approved Invoice Amount:</td>
                <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->invoice_amount ?? '' }}</td>
              </tr>
              <tr>
                <td colspan="4" class="text-right">Pending Amount:</td>
                <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->invoice_balance ?? '' }}</td>
              </tr>
            </tfoot>--}}
        </table>
      @endif
  </div>
@endif


