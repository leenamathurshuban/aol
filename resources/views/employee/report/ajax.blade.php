@if($type=='empPayDetail')
<div class="row">
    <div class="col-md-12 model_title"><h3>Request No: {{ $data->order_id ?? '' }}</h3>
    </div>

  <div class="col-md-12 vander_dataview">
    <ul>
      <li>
        <strong>Pay For Employee:</strong><p>{{json_decode($data->pay_for_employee_ary)->name ?? ''}}</p>
      </li>

      <li>
        <strong>Pay For Code:</strong><p>{{json_decode($data->pay_for_employee_ary)->employee_code ?? ''}}</p>
      </li>

      <li>
        <strong>Request Status:</strong><p>{{ \App\EmployeePay::requestStatus($data->status)}}</p>
      </li>

      <li>
        <strong>Requested Employee:</strong><p>{{json_decode($data->employee_ary)->name ?? ''}}</p>
      </li>

      <li>
        <strong>Requested Employee Code:</strong><p>{{json_decode($data->employee_ary)->employee_code ?? ''}}</p>
      </li>

      <li>
        <strong>Created Date:</strong><p>{{ ($data->created_at) ? \App\Helpers\Helper::onlyDate($data->created_at) : '' }}</p>
      </li>

      <li>
        <strong>Requested Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->amount_requested }}</p>
      </li>

       <li>
        <strong>Approved Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->amount_approved ?? '00' }}</p>
      </li>

      

      <li>
        <strong>Address:</strong><p>{{ $data->address }}</p>
      </li>

      <li>
        <strong>Bank Account Number:</strong><p>{{ $data->bank_account_number }}</p>
      </li>
      <li>
        <strong>IFSC:</strong><p>{{ $data->ifsc }}</p>
      </li>
      <li>
        <strong>Pan Number:</strong><p>{{ $data->pan }}</p>
      </li>
      <li>
        <strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p>
      </li>
      <li>
        <strong>Nature Of Claim:</strong><p>{{ json_decode($data->nature_of_claim_ary)->name }}</p>
      </li>
      <li>
        <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p>
      </li>
      <li>
        <strong>TDS Required:</strong><p>{{ $data->required_tds ?? '' }}</p>
      </li>
      <li>
        <strong>TDS:</strong><p>{{ $data->tds }}</p>
      </li>
      <li>
        <strong>TDS Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->tds_amount }}</p>
      </li>
      <li>
        <strong>TDS Section:</strong><p>{{-- ($data->tds_month==0) ? '' : \App\EmployeePay::tdsMonth($data->tds_month) --}}
        {{ ($data->tds_month) ? $data->tds_month : '' }}</p>
      </li>
      <li>
        <strong>Project Id:</strong><p>{{ $data->project_id }}</p>
      </li>

      <li>
        <strong>Cost Center:</strong><p>{{ $data->cost_center }}</p>
      </li>
      <li>
        <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
      </li>
      <li>
        <strong>Transaction Date:</strong><p>{{ $data->transaction_date }}</p>
      </li>
      <li class="col-md-12">
        <strong>Description:</strong><p>{{ $data->description }}</p>
      </li>

      @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
           <li>
              <strong>Bank Account:</strong><p>{{ $item->bank_account }}</p>
            </li>
            <li>
              <strong>IFSC:</strong><p>{{ $item->ifsc }}</p>
            </li> 
            <li>
              <strong>Bank Name:</strong><p>{{ $item->bank_name }}</p>
            </li>
        @endif

      <li class="col-md-12">
        @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
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
      </li>
    <!--  class="w-33" -->
    </ul>
    @if($data->manager_id && $data->manager_ary)
     <ul>
      <li class="col-md-6">
        <strong>Manager:</strong><p>{{json_decode($data->manager_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Manager Code:</strong><p>{{json_decode($data->manager_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Manager Comment:</strong><p>{{$data->manager_comment}}</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->manager_date) ? \App\Helpers\Helper::onlyDate($data->manager_date) : '' }}</p>
      </li>
     </ul>
    @endif

    @if($data->account_dept_id && $data->account_dept_ary)
     <ul>
      <li class="col-md-6">
        <strong>Account Office:</strong><p>{{json_decode($data->account_dept_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Account Code:</strong><p>{{json_decode($data->account_dept_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Account Comment:</strong><p>{{$data->account_dept_comment}}</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->account_date) ? \App\Helpers\Helper::onlyDate($data->account_date) : '' }}</p>
      </li>
     </ul>
    @endif

    @if($data->trust_ofc_id && $data->trust_ofc_ary)
     <ul>
      <li class="col-md-6">
        <strong>Trust Office:</strong><p>{{json_decode($data->trust_ofc_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Trust Code:</strong><p>{{json_decode($data->trust_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Trust Comment:</strong><p>{{$data->trust_ofc_comment}}</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->trust_date) ? \App\Helpers\Helper::onlyDate($data->trust_date) : '' }}</p>
      </li>
     </ul>
    @endif

    @if($data->payment_ofc_id && $data->payment_ofc_ary)
     <ul>
      <li class="col-md-6">
        <strong>Payment Office:</strong><p>{{json_decode($data->payment_ofc_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Payment Code:</strong><p>{{json_decode($data->payment_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Payment Comment:</strong><p>{{$data->payment_ofc_comment}}</p>
      </li>
     </ul>
    @endif
    @if($data->tds_ofc_id && $data->tds_ofc_ary)
     <ul>
      <li class="col-md-6">
        <strong>TDS Office:</strong><p>{{json_decode($data->tds_ofc_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>TDS Code:</strong><p>{{json_decode($data->tds_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>TDS Comment:</strong><p>{{$data->tds_ofc_comment}}</p>
      </li>
     </ul>
    @endif
  </div>

  <div class="col-md-12">
    <div class="table-responsive">
        @if($data->item_detail && $data->nature_of_claim_id==1)
          @php $item=json_decode($data->item_detail); @endphp
          <table class="table">
            <tr><td colspan="8"><h3>Item Detail</h3></td></tr>
            <tr>
              <th>Sr</th>
              <th>Bill Number</th>
              <th>Date</th>
              <th>Location</th>
              <th>Category</th>
              <th>Quantity</th>
              <th>Rate</th>
              <th>Amount</th>
            </tr>
            @forelse($item->itemDetail as $itemKey => $itemVal)
              <tr>
                <td>{{ ++$itemKey }}</td>
                <td>{{ $itemVal->bill_number }}</td>
                <td>{{ \App\Helpers\Helper::onlyDate($itemVal->date) ?? '' }}</td>
                <td>{{ $itemVal->location }}</td>
                <td>{{ $itemVal->category }}</td>
                <td>{{ $itemVal->quantity }}</td>
                <td>{{ env('CURRENCY_SYMBOL').''.$itemVal->rate }}</td>
                <td>{{ env('CURRENCY_SYMBOL').''.($itemVal->quantity*$itemVal->rate) }}</td>
              </tr>
            @empty
            @endforelse
            <tr>
              <td colspan="7">Total Requested Amount</td>
              <td>{{ env('CURRENCY_SYMBOL').''.$data->amount_requested }}</td>
            </tr>
          </table>
        @elseif($data->item_detail && $data->nature_of_claim_id==2)
        @php $item=json_decode($data->item_detail); @endphp
          <table class="table">
            <tr><td colspan="8"><h3>Item Detail</h3></td></tr>
            <tr>
              <th>Sr</th>
              <th>Bill Number</th>
              <th>Date</th>
              <th>From Location</th>
              <th>To Location</th>
              <th>Distance</th>
              <th>Mode Of travel</th>
              <th>Amount</th>
            </tr>
            @forelse($item->itemDetail as $itemKey => $itemVal)
              <tr>
                <td>{{ ++$itemKey }}</td>
                <td>{{ $itemVal->bill_number }}</td>
                <td>{{ \App\Helpers\Helper::onlyDate($itemVal->date) ?? '' }}</td>
                <td>{{ $itemVal->from_location }}</td>
                <td>{{ $itemVal->to_location }}</td>
                <td>{{ $itemVal->distance }}</td>
                <td>{{ $itemVal->category }}</td>
                <td>{{ env('CURRENCY_SYMBOL').''.($itemVal->amount) }}</td>
              </tr>
            @empty
            @endforelse
            <tr>
              <td colspan="7">Total Requested Amount</td>
              <td>{{ env('CURRENCY_SYMBOL').''.$data->amount_requested }}</td>
            </tr>
          </table>
        @elseif($data->item_detail && $data->nature_of_claim_id==3)
        @php $item=json_decode($data->item_detail); @endphp
          <table class="table">
            <tr><td colspan="5"><h3>Item Detail</h3></td></tr>
            <tr>
              <th>Sr</th>
              <th>Bill Number</th>
              <th>Date</th>
              <th>
                 @php $subCatMedicle = ''; @endphp
                          @if($data->nature_of_claim_id && $data->nature_of_claim_id=='3')
                            
                             @if($data->item_detail)
                                @php $item=json_decode($data->item_detail); @endphp
                                @forelse($item->itemDetail as $i_key => $i_val)
                                  @if($i_key==0)
                                    @php $subCatMedicle =$i_val->sub_category; @endphp
                                  @endif
                                @empty
                                @endforelse
                              @endif
                          @endif
              @if($subCatMedicle!='Medical welfare')
                Other description
              @elseif($subCatMedicle=='Medical welfare')
               Category
              @endif
            </th>
              <th>Amount</th>
            </tr>
            @forelse($item->itemDetail as $itemKey => $itemVal)
              <tr>
                <td>{{ ++$itemKey }}</td>
                <td>{{ $itemVal->bill_number }}</td>
                <td>{{ \App\Helpers\Helper::onlyDate($itemVal->date) ?? '' }}</td>
                <td>{{ $itemVal->category }} ( {{ $itemVal->sub_category }} )</td>
                <td>{{ env('CURRENCY_SYMBOL').''.($itemVal->amount) }}</td>
              </tr>
            @empty
            @endforelse
            <tr>
              <td colspan="4">Total Requested Amount</td>
              <td>{{ env('CURRENCY_SYMBOL').''.$data->amount_requested }}</td>
            </tr>
          </table>
          @if($subCatMedicle=='Medical welfare')
            <div class="col-md-12 vander_dataview">
              <ul>
                <li>
                  <strong>Pay To:</strong><p>{{ $item->medical->pay_to ?? ''}}</p>
                </li>
                @if(isset($item->medical->pay_to) && $item->medical->pay_to=='Pay to Hospital')
                  <li>
                    <strong>Bank Name:</strong><p>{{ $item->medical->bank_name ?? ''}}</p>
                  </li>
                  <li>
                    <strong>Bank Account Number:</strong><p>{{ $item->medical->bank_account_number ?? ''}}</p>
                  </li>
                  <li>
                    <strong>Branch Address:</strong><p>{{ $item->medical->branch_address ?? ''}}</p>
                  </li>
                  <li>
                    <strong>Hospital Name:</strong><p>{{ $item->medical->hsptl_name ?? ''}}</p>
                  </li>
                  <li>
                    <strong>Account Holder:</strong><p>{{ $item->medical->bank_account_holder ?? ''}}</p>
                  </li>
                  <li>
                    <strong>IFSC:</strong><p>{{ $item->medical->ifsc ?? ''}}</p>
                  </li>
                  <li>
                    <strong>Pan:</strong><p>{{ $item->medical->pan ?? ''}}</p>
                  </li>
                @endif
              </ul>
            </div>
          @endif

        @endif
      
  </div>

  @forelse($data->empReqImage as $key => $val)
      <div class="col-md-2">
       <div class="gallery_imgct">
            {!! Html::decode(link_to('public/'.$val->emp_req_file_path,\App\Helpers\Helper::getDocType($val->emp_req_file_path,$val->emp_req_file_type),['target'=>'_blank'])) !!}
        <p>{{ $val->emp_req_file_description }}</p>
       </div>
      </div>
    @empty
    @endforelse
</div>

@elseif($type=='vendorOrderList')
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
  <div class="col-md-2">
    <p>PO Start Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '' }}</strong></p>
      {!! Form::hidden('min_date',$data->po_start_date,['id'=>'min_date'])!!}
      {!! Form::hidden('max_date',$data->po_end_date,['id'=>'max_date'])!!}
      <script type="text/javascript">
        $('.invoice_date').attr('min','{{$data->po_start_date}}');
        $('.invoice_date').attr('max','{{$data->po_end_date}}');
        $('.Goods').remove();
      </script>
  </div>
  <div class="col-md-2">
    <p>PO End Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($data->po_end_date) ?? '' }}</strong></p>
  </div>
  <div class="col-md-2">
    <p>Order Amount: <br><strong>{{ env('CURRENCY_SYMBOL').''.$data->net_payable ?? '0' }}</strong></p>
  </div>
   @php
        
        $invc=\App\Invoice::approvedPoInvoice($data->id);
      @endphp
  <div class="col-md-3">
    <p>Approved Balance: <br><strong>{{ env('CURRENCY_SYMBOL').''.$invc }}</strong></p>
  </div>
  <div class="col-md-3">
    <p>Pending Balance: <br><strong>{{ env('CURRENCY_SYMBOL').''.($data->net_payable-$invc) }}</strong></p>
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
          <strong>PO Total:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $po->net_payable ?? '' }}</p>
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

        <li class="w-33">
          <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $po->net_payable-$invc }}</p>
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
                  <p><strong>Included Tax Total: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->invoice_amount }}</p>
                </td>
                <td>
                  <p><strong>TDS: </strong>{{ $itemVal->tds }}%</p>
                  <p><strong>TDS Section: </strong>{{ ($itemVal->tds_month) }}</p>
                  <p><strong>TDS Amount: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->tds_amount }}</p>
                  <p><strong>Included TDS Total: </strong>{{ env('CURRENCY_SYMBOL').''. $itemVal->tds_payable }}</p>
                </td>
                <td>
                  <p><strong>Invoice Unique Id:</strong>{{ $itemVal->order_id }}</p>
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
                      <tr>
                        <th><strong>Transaction Id</strong><p>{{$itemVal->transaction_id ?? ''}}</p></th>
                        <th><strong>Transaction Date</strong><p>{{$itemVal->transaction_date ?? ''}}</p></th>
                        <th></th>
                      </tr>
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
@elseif($type=='viewWithoutPoDetail')
<div class="row">
    <div class="col-md-12 model_title"><h3>Invoice No: {{ $data->invoice_number ?? '' }} Unique Id {{ $data->order_id ?? '' }}</h3>
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
        <strong>Tax:</strong><p>{{ $data->tax ?? '' }}</p>
      </li>
      <li>
        <strong>Tax Amount:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->tax_amount }}</p>
      </li>
       <li>
        <strong>Total:</strong><p>{{ env('CURRENCY_SYMBOL').''. $data->invoice_amount }}</p>
      </li>

       <li>
          <strong>Specified Person:</strong><p>{{$data->specified_person ?? '' }}</p>
        </li>

      <li>
        <strong>Status:</strong><p>{{ \App\Invoice::invoiceStatus($data->invoice_status)}}</p>
      </li>

      <li>
        <strong>Transaction Id:</strong><p>{{ $data->transaction_id ?? '' }}</p>
      </li>
      <li>
        <strong>Transaction Date:</strong><p>{{ $data->transaction_date ?? '' }}</p>
      </li>

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
        <strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->manager_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->manager_ary)->email ?? '' }}
                @endif</p>
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
        <strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->financer_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->financer_ary)->email ?? '' }}
                @endif</p>
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
        <strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->approver_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->approver_ary)->email ?? '' }}
                @endif</p>
      </li>
      <li class="col-md-12">
        <strong>Trust Office:</strong><p> @if($data->approver_trust) {{$data->trust_comment}}
                @endif</p>
      </li>

      <li>
        <strong>Payment Office:</strong><p> @if($data->approver_trust)
                  {{ json_decode($data->payment_ofc_ary)->name ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->payment_ofc_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->payment_ofc_ary)->email ?? '' }}
                @endif</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p> @if($data->payment_ofc_id) {{$data->payment_ofc_comment}}
                @endif</p>
      </li>

      <li>
        <strong>TDS Office:</strong><p> @if($data->approver_trust)
                  {{ json_decode($data->tds_ofc_ary)->name ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Code:</strong><p>@if($data->employee_id)
                {{ json_decode($data->tds_ofc_ary)->employee_code ?? '' }}
                @endif</p>
      </li>
      <li>
        <strong>Email:</strong><p>@if($data->employee_id)
                {{ json_decode($data->tds_ofc_ary)->email ?? '' }}
                @endif</p>
      </li>
      <li class="col-md-12">
        <strong>Comment:</strong><p> @if($data->tds_ofc_id) {{$data->tds_ofc_comment}}
                @endif</p>
      </li>

      @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
           <li>
              <strong>Bank Account:</strong><p>{{ $item->bank_account }}</p>
            </li>
            <li>
              <strong>IFSC:</strong><p>{{ $item->ifsc }}</p>
            </li> 
            <li>
              <strong>Bank Name:</strong><p>{{ $item->bank_name }}</p>
            </li>
        @endif
      <li class="col-md-12">
        @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
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
      </li>

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
@elseif($type=='getVendorDetail')
<div class="row">
                        <div class="col-md-12 model_title"><h3>{{ $data->name.' '.$data->vendor_code ?? 'Vendor Detail' }} </h3>
                         </div>
                         <div class="col-md-12 vander_dataview">
                            <ul>
                              <li><strong>Name:</strong><p>{{ $data->name ?? '' }}</p></li>
                              <li><strong>Email:</strong><p>{{ $data->email ?? '' }}</p></li>
                              <li><strong>Password:</strong><p>{{ $data->original_password ?? '' }}</p></li>
                              <li><strong>Contact:</strong> <p>{{ $data->phone ?? '' }}</p></li>
                              <li><strong>Form Type:</strong><p>{{ \App\Vendor::requestType($data->vendor_type) }}</p></li>
                            <li>
                              <strong>Added By Name:</strong><p>{{ json_decode($data->user_ary)->name ?? '' }}</p>
                            </li>
                             <li>
                              <strong>Code:</strong><p>{{ json_decode($data->user_ary)->employee_code ?? '' }}</p>
                            </li>
                            @if($data->approved_user_id)
                            <li>
                              <strong>Approver Name:</strong><p>{{ json_decode($data->approved_user_ary)->name ?? '' }}</p>
                            </li>

                             <li>
                              <strong>Code:</strong><p>{{ json_decode($data->approved_user_ary)->employee_code ?? '' }}</p>
                            </li>

                             <li>
                              <strong>Approver Mobile:</strong><p>{{ json_decode($data->approved_user_ary)->mobile_code ?? '' }} {{ json_decode($data->approved_user_ary)->mobile ?? '' }}</p>
                            </li>
                            @endif

                         
                            <li>
                              <strong>Bank Account Type:</strong><p>{{ $data->bank_account_type ?? '' }}</p>
                            </li>
                         

                            <li>
                              <strong>Bank Account:</strong><p>{{ $data->bank_account_number ?? '' }}</p>
                            </li>

                            <li>
                              <strong>Bank IFSC:</strong><p>{{ $data->ifsc ?? '' }}</p>
                            </li>


                            <li>
                              <strong>Pan Number:</strong><p>{{ $data->pan ?? '' }}</p>
                            </li>

                          
                            <li>
                              <strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p>
                            </li>
                            <li><strong>State:</strong> <p>{{ json_decode($data->state_ary)->name ?? '' }}</p></li>
                              <li><strong>City:</strong><p>{{ json_decode($data->city_ary)->name ?? '' }}</p></li>
                            
                             <li>
                              <strong>Address:</strong><p>{{ $data->address ?? '' }}</p>
                            </li>

                         
                            <li>
                              <strong>Location:</strong><p>{{ $data->location ?? '' }}</p>
                            </li>

                            <li>
                              <strong>Zip:</strong><p>{{ $data->zip ?? '' }}</p>
                            </li>


                            <li>
                              <strong>Constitution:</strong><p>{{ $data->constitution ?? '' }}</p>
                            </li>

                            <li>
                              <strong>GST:</strong><p>{{ $data->gst ?? '' }}</p>
                            </li>
                            @if($data->account_status)
                            <li>
                            <strong>Status:</strong> <p class="{{ ($data->account_status==3) ? 'btn btn-success' : 'btn btn-danger'}}">{{ \App\Vendor::accountStatus($data->account_status) }}</p>
                          </li>
                          @endif

                            </ul>
                         </div>
                         <div class="col-md-12 specify_other">
                             
                                <strong>Specify If Constitution Others:</strong> <p>{{ $data->specify_if_other ?? '' }}</p>
                              
                         </div>
                      <div class="row doc_imgswarp">
                         @if($data->pan_file)
                            <div class="col-md-3 doc_imgs">
                              <p><strong>Pan Image</strong></p>
                                    <div class="zkit_gall_img">
                                      <img src="{{ url('public/'.$data->pan_file) }}" alt="user" class="img-fluit edit-product-img" />
                                    </div>
                            </div>
                          @endif
                          @if($data->cancel_cheque_file)
                            <div class="col-md-3 doc_imgs">
                             <p><strong>Cancel Cheque</strong></p>
                                    <div class="zkit_gall_img">
                                      <img src="{{ url('public/'.$data->cancel_cheque_file) }}" alt="user" class="img-fluit edit-product-img" />
                                    </div>
                            </div>
                          @endif
                      </div>
                     
                    </div>
@elseif($type=='viewPoDetail')
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
            <strong>PO Invoice Limit :</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::invoiceLimit($data->net_payable) ?? '' }}</p>
          </li>--}}

          <li>
            <strong>Invoice Approved:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $invc }}</p>
          </li>

          <li class="w-33">
            <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable-$invc }}</p>
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
            <strong>Payment:</strong><p>{{ \App\PurchaseOrder::paymentMethod($data->payment_method) ?? '' }}</p>
          </li>

           <li>
            <strong>Nature Of Service:</strong><p>{{ \App\PurchaseOrder::natureOfService($data->nature_of_service) ?? '' }}</p>
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
            <li class="col-md-12">
              <strong>Manager Comments:</strong><p>{{ $data->account_status_level2_comment ?? '' }}</p>
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
      <ul>
        <hr>
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
        @endif

        @if($data->account_status_level3_comment)
          <div class="col-md-12 specify_other">
          <strong>Financer Comments:</strong> <p>{{ $data->account_status_level3_comment ?? '' }}</p>
        </div>
        @endif
      </ul>
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
            <th>No:</th>
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
               <td>{{ $itemVal->invoice_number }}</td>
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

      <div class="col-md-12">
          <p> <strong>PO Desciption :</strong> {{ $data->po_description }}</p>
      </div>

  </div>
@elseif($type=='getInternalTrnsDetail')
<div class="row">
    <div class="col-md-12 model_title"><h3>Request No: {{ $data->order_id ?? '' }}</h3>
    </div>

  <div class="col-md-12 vander_dataview">
    <ul>
      <li>
        <strong>Pay For:</strong><p>{{ $data->nature_of_request ?? ''}}</p>
      </li>

      
      <li>
        <strong>Request Status:</strong><p>{{ \App\InternalTransfer::requestStatus($data->status)}}</p>
      </li>

      <li>
        <strong>Requested Employee:</strong><p>{{json_decode($data->employee_ary)->name ?? ''}}</p>
      </li>

      <li>
        <strong>Requested Employee Code:</strong><p>{{json_decode($data->employee_ary)->employee_code ?? ''}}</p>
      </li>

      <li>
        <strong>Requested Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->employee_date) ?? ''}}</p>
      </li>

      <li>
        <strong>Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->amount ?? '0' }}</p>
      </li>

      <li>
        <strong>Transaction Id:</strong><p>{{ $data->transaction_id ?? '' }}</p>
      </li>
      <li>
        <strong>Transaction Date:</strong><p>{{ $data->transaction_date ?? '' }}</p>
      </li>

      @if($data->nature_of_request=='State requesting funds')
        <li>
        <strong>State:</strong><p>{{json_decode($data->apex_ary)->name ?? ''}}</p>
      </li>
       <li>
        <strong>Bank Name:</strong><p>{{ json_decode($data->state_bank_ary)->bank_name ?? '' }}</p>
      </li>
       <li>
        <strong>Bank Account Number:</strong><p>{{ json_decode($data->state_bank_ary)->bank_account_number ?? '' }}</p>
      </li>
      <li>
        <strong>Bank IFSC:</strong><p>{{ json_decode($data->state_bank_ary)->ifsc ?? '' }}</p>
      </li>
      <li>
        <strong>Bank Branch Address:</strong><p>{{ json_decode($data->state_bank_ary)->branch_address ?? '' }}</p>
      </li>
      <li>
        <strong>Bank Account Holder:</strong><p>{{ json_decode($data->state_bank_ary)->bank_account_holder ?? '' }}</p>
      </li>
       <li>
        <strong>Project Name:</strong><p>{{ $data->project_name ?? '' }}</p>
      </li>

      <li>
        <strong>Reason:</strong><p>{{ $data->reason ?? '' }}</p>
      </li>
       <li>
        <strong>Project Id:</strong><p>{{ $data->project_id ?? '' }}</p>
      </li>

      <li>
        <strong>Cost Center:</strong><p>{{ $data->cost_center ?? '' }}</p>
      </li>
 
      @elseif($data->nature_of_request=='Inter bank transfer')

      <li>
        <strong>Transfer From Bank:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_name ?? '' }}</p>
      </li>
       <li>
        <strong>From Account Number:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_account_number ?? '' }}</p>
      </li>
      <li>
        <strong>From Bank IFSC:</strong><p>{{ json_decode($data->transfer_from_ary)->ifsc ?? '' }}</p>
      </li>
      <li>
        <strong>From Bank Branch Address:</strong><p>{{ json_decode($data->transfer_from_ary)->branch_address ?? '' }}</p>
      </li>
      <li>
        <strong>From Bank Account Holder:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_account_holder ?? '' }}</p>
      </li>

      <li>
        <strong>Transfer To Bank:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_name ?? '' }}</p>
      </li>
       <li>
        <strong>To Account Number:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_account_number ?? '' }}</p>
      </li>
      <li>
        <strong>To Bank IFSC:</strong><p>{{ json_decode($data->transfer_to_ary)->ifsc ?? '' }}</p>
      </li>
      <li>
        <strong>To Bank Branch Address:</strong><p>{{ json_decode($data->transfer_to_ary)->branch_address ?? '' }}</p>
      </li>
      <li>
        <strong>To Bank Account Holder:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_account_holder ?? '' }}</p>
      </li>
      @else

      @endif

     @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
            <li class="col-md-12">
            {{--  <table class="table" width="100%">
                <tr>
                  <td><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></td>
                  <td><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></td>
                  <td><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></td>
                </tr>
              </table>--}}
            </li>
            <li class="col-md-12">
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
              </li>
          @endif
     
    
    <!--  class="w-33" -->
    </ul>
   

    @if($data->account_dept_id && $data->account_dept_ary)
     <ul>
      <li class="col-md-6">
        <strong>Account Office:</strong><p>{{json_decode($data->account_dept_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Account Code:</strong><p>{{json_decode($data->account_dept_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Account Comment:</strong><p>{{$data->account_dept_comment}}</p>
      </li>
     </ul>
    @endif

    @if($data->trust_ofc_id && $data->trust_ofc_ary)
     <ul>
      <li class="col-md-6">
        <strong>Trust Office:</strong><p>{{json_decode($data->trust_ofc_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Trust Code:</strong><p>{{json_decode($data->trust_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Trust Comment:</strong><p>{{$data->trust_ofc_comment}}</p>
      </li>
     </ul>
    @endif

    @if($data->payment_ofc_id && $data->payment_ofc_ary)
     <ul>
      <li class="col-md-6">
        <strong>Payment Office:</strong><p>{{json_decode($data->payment_ofc_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Payment Code:</strong><p>{{json_decode($data->payment_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Payment Comment:</strong><p>{{$data->payment_ofc_comment}}</p>
      </li>
     </ul>
    @endif
  </div>


  @forelse($data->internalTransferImage as $key => $val)
      <div class="col-md-2">
       <div class="gallery_imgct">
            {!! Html::decode(link_to('public/'.$val->internal_transfer_file_path,\App\Helpers\Helper::getDocType($val->internal_transfer_file_path,$val->internal_transfer_file_type),['target'=>'_blank'])) !!}
        <p>{{ $val->internal_transfer_file_description }}</p>
       </div>
      </div>
    @empty
    @endforelse
</div>
@elseif($type=='BulkUploadDetail')
  <div class="row">
    <div class="col-md-12 model_title"><h3>Request No: {{ $data->order_id ?? '' }}</h3>
    </div>

  <div class="col-md-12 vander_dataview">
    <ul>
      <li>
        <strong>Category:</strong><p>{{ \App\BulkUpload::categoryView($data->category) ?? ''}}</p>
      </li>
      <li>
        <strong>Bank Formate:</strong><p>{{ \App\BulkUpload::bankView($data->bank_formate) ?? ''}}</p>
      </li>
      <li>
        <strong>Payment Type:</strong><p>{{ \App\BulkUpload::paymentTypeView($data->payment_type) ?? ''}}</p>
      </li>
      <li>
        <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p>
      </li>
      <li>
        <strong>Request Status:</strong><p>{{ \App\BulkUpload::requestStatus($data->status)}}</p>
      </li>

      <li>
        <strong>Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->created_at) ?? '' }}</p>
      </li>
      <li>
        <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
      </li>
      <li>
        <strong>Transaction Date:</strong><p>{{ $data->transaction_date }}</p>
      </li>

      <li>
        <strong>Requested Employee:</strong><p>{{json_decode($data->employee_ary)->name ?? ''}}</p>
      </li>

      <li>
        <strong>Requested Employee Code:</strong><p>{{json_decode($data->employee_ary)->employee_code ?? ''}}</p>
      </li>

     
      <li>
        <strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p>
      </li>
 
      @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
            <li class="col-md-12">
              <table class="table" width="100%">
                <tr>
                  <td><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></td>
                  <td><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></td>
                  <td><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></td>
                </tr>
              </table>
            </li>
            <li class="col-md-12">
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
              </li>
          @endif
    <!--  class="w-33" -->
    </ul>
    @if($data->manager_id && $data->manager_ary)
     <ul>
      <li>
        <strong>Manager:</strong><p>{{json_decode($data->manager_ary)->name ?? ''}}</p>
      </li>
      <li>
        <strong>Manager Code:</strong><p>{{json_decode($data->manager_ary)->employee_code ?? ''}}</p>
      </li>
      <li>
        <strong>Manager Email:</strong><p>{{json_decode($data->manager_ary)->email ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Manager Comment:</strong><p>{{$data->manager_comment}}</p>
      </li>
     </ul>
    @endif

    @if($data->account_dept_id && $data->account_dept_ary)
     <ul>
      <li>
        <strong>Account Office:</strong><p>{{json_decode($data->account_dept_ary)->name ?? ''}}</p>
      </li>
      <li>
        <strong>Account Code:</strong><p>{{json_decode($data->account_dept_ary)->employee_code ?? ''}}</p>
      </li>
      <li>
        <strong>Account Email:</strong><p>{{json_decode($data->account_dept_ary)->email ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Account Comment:</strong><p>{{$data->account_dept_comment}}</p>
      </li>
     </ul>
    @endif

    @if($data->trust_ofc_id && $data->trust_ofc_ary)
     <ul>
      <li>
        <strong>Trust Office:</strong><p>{{json_decode($data->trust_ofc_ary)->name ?? ''}}</p>
      </li>
      <li>
        <strong>Trust Code:</strong><p>{{json_decode($data->trust_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li>
        <strong>Trust Email:</strong><p>{{json_decode($data->trust_ofc_ary)->email ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Trust Comment:</strong><p>{{$data->trust_ofc_comment}}</p>
      </li>
     </ul>
    @endif

    @if($data->payment_ofc_id && $data->payment_ofc_ary)
     <ul>
      <li>
        <strong>Payment Office:</strong><p>{{json_decode($data->payment_ofc_ary)->name ?? ''}}</p>
      </li>
      <li>
        <strong>Payment Code:</strong><p>{{json_decode($data->payment_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li>
        <strong>Payment Email:</strong><p>{{json_decode($data->payment_ofc_ary)->email ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>Payment Comment:</strong><p>{{$data->payment_ofc_comment}}</p>
      </li>
     </ul>
    @endif
    @if($data->tds_ofc_id && $data->tds_ofc_ary)
     <ul>
      <li>
        <strong>TDS Office:</strong><p>{{json_decode($data->tds_ofc_ary)->name ?? ''}}</p>
      </li>
      <li>
        <strong>TDS Code:</strong><p>{{json_decode($data->tds_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li>
        <strong>TDS Email:</strong><p>{{json_decode($data->tds_ofc_ary)->email ?? ''}}</p>
      </li>
      <li class="col-md-12">
        <strong>TDS Comment:</strong><p>{{$data->tds_ofc_comment}}</p>
      </li>
     </ul>
    @endif
  </div>

 <div class="col-md-2">
   <div class="gallery_imgct">
        {!! Html::decode(link_to('public/'.$data->bulk_attachment_path,\App\Helpers\Helper::getDocType($data->bulk_attachment_path,$data->bulk_attachment_type),['target'=>'_blank'])) !!}
    <p>{{ $data->bulk_attachment_description }}</p>
   </div>
  </div>
      
  @forelse($data->bulkReqImage as $key => $val)
      <div class="col-md-2">
       <div class="gallery_imgct">
            {!! Html::decode(link_to('public/'.$val->bulk_upload_file_path,\App\Helpers\Helper::getDocType($val->bulk_upload_file_path,$val->bulk_upload_file_type),['target'=>'_blank'])) !!}
        <p>{{ $val->bulk_upload_file_description }}</p>
       </div>
      </div>
    @empty
    @endforelse
</div>
<div class="row">
  <div class="col-md-12">
    @if($data->payment_type==1 || $data->payment_type==2)
    <table class="table">
      <tr>
        <th>Sr:</th>
        <th>Account Number</th>
        <th>Branch Code</th>
        <th>Date</th>
        <th>Dr Amount</th>
        <th>Cr Amount</th>
        <th>Refrence</th>
        <th>Description</th>
        <th>Pay Id</th>
      </tr>
      @forelse($data->bulkCsv as $ckey => $cval)
        <tr>
          <td>{{ ++$ckey }}</td>
          <td>{{ $cval->account_no }}</td>
          <td>{{ $cval->branch_code }}</td>
          <td>{{ $cval->amt_date }}</td>
          <td>{{ env('CURRENCY_SYMBOL') }}{{ $cval->dr_amount }}</td>
          <td>{{ env('CURRENCY_SYMBOL') }}{{ $cval->cr_amount }}</td>
          <td>{{ $cval->refrence }}</td>
          <td>{{ $cval->description }}</td>
          <td>{{ $cval->pay_id }}</td>
        </tr>
      @empty
      <tr>
        <td colspan="9" class="text-danger text-center">Not Found</td>
      </tr>
      @endforelse
    </table>
    @endif
    @if($data->payment_type==3)
    <table class="table">
      <tr>
        <th>Sr:</th>
        <th>Transaction Type</th>
        <th>Debit Account No</th>
        <th>IFSC</th>
        <th>Beneficiary Account No</th>
        <th>Beneficiary Name</th>
        <th>Amount</th>
        <th>Remarks For Client</th>
        <th>Remarks For Beneficiary</th>
        <th>ROutput Data</th>
      </tr>
      @forelse($data->bulkCsv as $ckey => $cval)
        <tr>
          <td>{{ ++$ckey }}</td>
          <td>{{ $cval->transaction_type }}</td>
          <td>{{ $cval->debit_account_no }}</td>
          <td>{{ $cval->ifsc }}</td>
          <td>{{ $cval->beneficiary_account_no }}</td>
          <td>{{ $cval->beneficiary_name }}</td>
          <td>{{ env('CURRENCY_SYMBOL') }}{{ $cval->amount }}</td>
          <td>{{ $cval->remarks_for_client }}</td>
          <td>{{ $cval->remarks_for_beneficiary }}</td>
          <td>{{ $cval->output_data }}</td>
        </tr>
      @empty
      <tr>
        <td colspan="10" class="text-danger text-center">Not Found</td>
      </tr>
      @endforelse
      </table>
    @endif
  </div>
</div>
@endif


