@if($type=='vendorOrderList')
    {{ Form::label('po_number','PO Number List') }}
    {!!Form::select('po_number', $data, '', ['placeholder' => 'Select PO Number','class'=>'form-control custom-select select2','id'=>'poList'])!!}
    <script>
      $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })
      })
      $(document).ready(function(){
          $('#poList').change(function(){
            var order_id=$(this).val();
            if (order_id!='') {
              var url="{{ route('employee.InvoicePOAjaxResponse') }}";
                    $.ajax({
                      type:"POST",
                      url:url,
                      data:{order_id:order_id , _token: '{{csrf_token()}}','type':'poDetail'},
                      beforeSend: function(){
                       //$('#preloader').show();
                      },
                      success:function(response){
                        //var json = $.parseJSON(response);
                        //$('#vCode').val(json.vendor_code);//vendor_code
                         $('#orDate').empty().append(response);
                         //invoice_date
                        //$('#preloader').hide();
                      }
                    });
            }else{
              $('#vCode').val(null);
            }
          });
      });
    </script>
@elseif($type=='poDetail')
  <div class="col-md-4">
    <p>PO Start Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '' }}</strong></p>
      {!! Form::hidden('min_date',$data->po_start_date,['id'=>'min_date'])!!}
      {!! Form::hidden('max_date',$data->po_end_date,['id'=>'max_date'])!!}
      <script type="text/javascript">
        $('.invoice_date').attr('min','{{$data->po_start_date}}');
        $('.invoice_date').attr('max','{{$data->po_end_date}}');
        $('.Goods').remove();
      </script>
  </div>
  <div class="col-md-4">
    <p>PO End Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($data->po_end_date) ?? '' }}</strong></p>
  </div>
  <div class="col-md-4">
    <p>Order Amount: <br><strong id="net_payable" class="{{$data->net_payable}}">{{ env('CURRENCY_SYMBOL').''.$data->net_payable ?? '0' }}</strong></p>
  </div>
   @php
        
        $invc=\App\Invoice::approvedPoInvoice($data->id);
      @endphp
  {{--<div class="col-md-4">
    <p>Max Invoice Limit: <br><strong>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::invoiceLimit($data->net_payable) ?? '' }}</strong></p>
  </div>--}}
  <div class="col-md-4">
    <p>Approved Balance: <br><strong>{{ env('CURRENCY_SYMBOL').''.$invc }}</strong></p>
  </div>
  <div class="col-md-4">
    <p>Invoice In Process: <br><strong>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::proccessPoInvoice($data->id) }}</strong></p>
  </div>
  <div class="col-md-4">
    <p>PO Balance: <br><strong>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::poBalance($data->id) }}</strong></p>
  </div>
@elseif($type=='viewDetail')
  <div class="row">
      <div class="col-md-12 model_title"><h3>PO No: {{ $po->order_id ?? '' }}</h3>
      </div>
    <div class="col-md-12 vander_dataview">
      <ul>
        <li>
          <strong>Vendor:</strong><p>{{ json_decode($po->vendor_ary)->name ?? '' }}</p>
        </li>

        <li>
          <strong>Code:</strong><p>{{ json_decode($po->vendor_ary)->vendor_code ?? '' }}</p>
        </li>

        <li>
          <strong>Email:</strong><p>{{ json_decode($po->vendor_ary)->email ?? '' }}</p>
        </li>
        <li>
          <strong>PO Start Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($po->po_start_date) ?? '' }}</p>
        </li>
        <li> 
          <strong>PO End Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($po->po_end_date) ?? '' }}</p>
        </li>

        <li>
          <strong>PO Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $po->net_payable ?? '' }}</p>
        </li>

        @php
          $invc=\App\Invoice::approvedPoInvoice($po->id);
        @endphp
        
        {{-- <li>
          <strong>PO Invoice Limit :</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::invoiceLimit($po->net_payable) ?? '' }}</p>
        </li>--}}

        <li>
          <strong>Invoice Approved:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $invc }}</p>
        </li>

        <li>
          <strong>Invoice In Process:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::proccessPoInvoice($po->id) }}</p>
        </li>

        <li class="w-33">
          <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::poBalance($po->id) }}</p>
        </li>

      </ul>
      <div class="table-responsive">
        @if($data)
          <table class="table">
            <tr><td colspan="4"><h3>Invoice Detail</h3></td></tr>
            @forelse($data as $itemKey => $itemVal)
              <tr class="poAppInvTR">
                <td>
                  <p><strong>Sr: </strong>{{ ++$itemKey }}</p>
                  <p><strong>Date: </strong>{{ \App\Helpers\Helper::onlyDate($itemVal->invoice_date) ?? '' }}</p>
                  <p><strong>Invoice No: </strong>{{ $itemVal->invoice_number }}</p>
                  <p><strong>Payment Mode: </strong>{{ $itemVal->advance_payment_mode }}</p>
                </td>
                <td>
                  <p><strong>Amount: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->amount }}</p>
                  <p><strong>Tax: </strong>{{ $itemVal->tax }}%</p>
                  <p><strong>Tax Amount: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->tax_amount }}</p>
                  <p><strong>Invoice Amount: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->invoice_amount }}</p>
                </td>
                <td>
                  <p><strong>TDS: </strong>{{ $itemVal->tds }}%</p>
                  <p><strong>TDS Section: </strong>{{ ($itemVal->tds_month) }}</p>
                  <p><strong>TDS Amount: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->tds_amount }}</p>
                  <p><strong>Net Payable: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->tds_payable }}</p>
                </td>
                <td>
                  <p><strong> Unique Id </strong> {{ $itemVal->order_id }}</p>
                  <p><strong>Status: </strong>{{ \App\Invoice::invoiceStatus($itemVal->invoice_status)}}</p>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  @if($itemVal->item_detail)
                     @php $sub_item=json_decode($itemVal->item_detail); @endphp
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
                        @forelse($sub_item as $subKey => $subVal)
                          <tr>
                            <td>{{ ++$subKey }}</td>
                            <td>{{ $subVal->item_name }}</td>
                            <td>{{ $subVal->quantity }} {{ $subVal->unit }}</td>
                            <td>{{ env('CURRENCY_SYMBOL').''.$subVal->rate }}</td>
                            <td>{{ $subVal->tax }}%</td>
                            <td>{{ env('CURRENCY_SYMBOL').''.$subVal->tax_amt }}</td>
                            <td>{{ $subVal->price_unit }}</td>
                            <td>{{ env('CURRENCY_SYMBOL').''.$subVal->total }}</td>
                          </tr>
                        @empty
                        @endforelse
                      </table>
                  @endif
                </td>
              </tr>
              <tr>
                <td colspan="4">
                @if($itemVal->form_by_account)
                    @php $item=json_decode($itemVal->form_by_account); @endphp
                    <table class="table">
                      <tr>
                        <th><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></th>
                        <th><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></th>
                        <th><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></th>
                      </tr>
                      @if(Auth::guard('employee')->user()->role_id!=4)
                      <tr>
                        <th><strong>Transaction Id</strong><p>{{$itemVal->transaction_id ?? ''}}</p></th>
                        <th><strong>Transaction Date</strong><p>{{ ($itemVal->transaction_date) ? \App\Helpers\Helper::onlyDate($itemVal->transaction_date) : ''}}</p></th>
                        <th><strong>Date of Payment</strong><p>{{ ($itemVal->date_of_payment) ? \App\Helpers\Helper::onlyDate($itemVal->date_of_payment) : '' }}</p></th>
                      </tr>
                      @endif
                    </table>
                      <table class="table">
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
                  @endif
                </td>
              </tr>
            @empty
            @endforelse
          </table>
        @endif
      </div>
    </div>
  </div>
@elseif($type=='getInvoiceItemRow')
  <div class="row newGD Goods{{$dataId}}" id="removeItemRow{{$cls}}">
     <div class="col-md-3">
        <div class="form-group">
        {{Helper::debitAccount('')}}
      </div>
     </div>
     <div class="col-md-3">
        <div class="form-group">
          <input class="form-control debit_amt" placeholder="Amount" required="" id="" name="amount[]" type="number" value=""> <span class="text-danger"></span> </div>
     </div>
     <div class="col-md-3">
        <div class="form-group">
          {{Helper::costCenter('')}}
        </div>
     </div>
     <div class="col-md-2">
        <div class="form-group">
            {{Helper::category('')}}
        </div>
     </div>
     <div class="col-md-1 ItemRemove">
        <div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div>
     </div>
  </div>
@elseif($type=='InvoiceDetail')
  <div class="col-md-12 vander_dataview">
    <ul>
      <li class="col-md-12"><h5><strong>PO:</strong>{{ $po->order_id ?? '' }}</h5></li>
      <li>
        <strong>Vendor:</strong><p>{{ json_decode($po->vendor_ary)->name ?? '' }}</p>
      </li>
      <li>
        <strong>Code:</strong><p>{{ json_decode($po->vendor_ary)->vendor_code ?? '' }}</p>
      </li>

      <li>
        <strong>Email:</strong><p>{{ json_decode($po->vendor_ary)->email ?? '' }}</p>
      </li>
      <li>
        <strong>PO Start Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($po->po_start_date) ?? '' }}</p>
      </li>
      <li>
        <strong>PO End Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($po->po_end_date) ?? '' }}</p>
      </li>
       <li>
          <strong>PO Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $po->net_payable ?? '' }}</p>
        </li>

        @php
          $invc=\App\Invoice::approvedPoInvoice($po->id);
        @endphp
        
        {{-- <li>
          <strong>PO Invoice Limit :</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::invoiceLimit($po->net_payable) ?? '' }}</p>
        </li>--}}

        <li>
          <strong>Invoice Approved:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $invc }}</p>
        </li>

        <li>
          <strong>Invoice In Process:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::proccessPoInvoice($po->id) }}</p>
        </li>

        <li class="w-33">
          <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::poBalance($po->id) }}</p>
        </li>
    </ul>
    <ul>
      <li class="col-md-12"><h5><strong>Inovoice Number:</strong>{{ $data->invoice_number ?? '' }}</h5></li>
       <li>
        <strong>Invoice Unique Id:</strong><p>{{ $data->order_id }}</p>
      </li>
      <li>
        <strong>Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->invoice_date) ?? '' }}</p>
      </li>
      <li>
        <strong>Payment Mode:</strong><p>{{ $data->advance_payment_mode }}</p>
      </li>
      <li>
        <strong>Amount:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->amount }}</p>
      </li>
      <li>
        <strong>Tax:</strong><p>{{ $data->tax }}%</p>
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
        <strong>TDS Section:</strong><p>{{ $data->tds_month ?? '' }}</p>
      </li>
      <li>
        <strong>TDS Amount:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->tds_amount }}</p>
      </li>
      <li>
        <strong>Net Payable:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->tds_payable }}</p>
      </li>
      <li>
        <strong>Status:</strong><p>{{ \App\Invoice::invoiceStatus($data->invoice_status)}}</p>
      </li>
      <li>
        <strong>Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->invoice_date) ?? '' }}</p>
      </li>
      <li>
        <strong>Employee:</strong><p>{{ json_decode($data->employee_ary)->name ?? '' }}</p>
      </li>
      <li>
        <strong>Code:</strong><p>{{ json_decode($data->employee_ary)->employee_code ?? '' }}</p>
      </li>
       <li>
        <strong>Created Date:</strong><p>{{ ($data->created_at) ? \App\Helpers\Helper::onlyDate($data->created_at) : '' }}</p>
      </li> 
      <li>
        <strong>Email:</strong><p>{{ json_decode($data->employee_ary)->email ?? '' }}</p>
      </li>
      <li>
        <strong>Manager:</strong><p>{{ json_decode($data->manager_ary)->name ?? '' }}</p>
      </li>
      <li>
        <strong>Code:</strong><p>{{ json_decode($data->manager_ary)->employee_code ?? '' }}</p>
      </li>
      <li>
        <strong>Email:</strong><p>{{ json_decode($data->manager_ary)->email ?? '' }}</p>
      </li>
       <li>
        <strong>Approval Date:</strong><p>{{ ($data->manager_date) ? \App\Helpers\Helper::onlyDate($data->manager_date) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p>{{ $data->manager_comment ?? '' }}</p>
      </li>
      <li>
        <strong>Accout Office:</strong><p>{{ json_decode($data->financer_ary)->name ?? '' }}</p>
      </li>
      <li>
        <strong>Code:</strong><p>{{ json_decode($data->financer_ary)->employee_code ?? '' }}</p>
      </li>
      <li>
        <strong>Email:</strong><p>{{ json_decode($data->financer_ary)->email ?? '' }}</p>
      </li>
       <li>
        <strong>Approval Date:</strong><p>{{ ($data->financer_date) ? \App\Helpers\Helper::onlyDate($data->financer_date) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p>{{ $data->financer_comment ?? '' }}</p>
      </li>
      <li>
        <strong>Trust Office:</strong><p>{{ json_decode($data->approver_ary)->name ?? '' }}</p>
      </li>
      <li>
        <strong>Code:</strong><p>{{ json_decode($data->approver_ary)->employee_code ?? '' }}</p>
      </li>
      <li>
        <strong>Email:</strong><p>{{ json_decode($data->approver_ary)->email ?? '' }}</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->trust_date) ? \App\Helpers\Helper::onlyDate($data->trust_date) : '' }}</p>
      </li>
       <li class="col-md-12">
        <strong>Comment:</strong><p>{{ $data->trust_comment ?? '' }}</p>
      </li>
      <li>
        <strong>File:</strong><p>{!! Html::decode(link_to('public/'.$data->invoice_file_path,\App\Helpers\Helper::getDocType($data->invoice_file_path,$data->po_file_type),['target'=>'_blank'])) !!}</p>
      </li>
    </ul>
    @if($data->item_detail)
       @php $sub_item=json_decode($data->item_detail); @endphp
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
          @forelse($sub_item as $subKey => $subVal)
            <tr>
              <td>{{ ++$subKey }}</td>
              <td>{{ $subVal->item_name }}</td>
              <td>{{ $subVal->quantity }} {{ $subVal->unit }}</td>
              <td>{{ env('CURRENCY_SYMBOL').''.$subVal->rate }}</td>
              <td>{{ $subVal->tax }}%</td>
              <td>{{ env('CURRENCY_SYMBOL').''.$subVal->tax_amt }}</td>
              <td>{{ $subVal->price_unit }}</td>
              <td>{{ env('CURRENCY_SYMBOL').''.$subVal->total }}</td>
            </tr>
          @empty
          @endforelse
        </table>
    @endif
    @if($data->form_by_account)
      @php $item=json_decode($data->form_by_account); @endphp
      <table class="table">
        <tr>
          <th><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></th>
          <th><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></th>
          <th><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></th>
        </tr>
        @if(Auth::guard('employee')->user()->role_id!=4)
        <tr>
          <th><strong>Transaction Id</strong><p>{{$data->transaction_id ?? ''}}</p></th>
          <th><strong>Transaction Date</strong><p>{{ ($data->transaction_date) ? \App\Helpers\Helper::onlyDate($data->transaction_date) : ''}}</p></th>
          <th><strong>Date of Payment</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p></th>
        </tr>
        @endif
      </table>
      <table class="table">
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
    @endif
  </div>
@endif


