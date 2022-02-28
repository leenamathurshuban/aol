@php $inr = Html::decode('<img src="'.url('assets/admin/inr-dark.png').'" style="height: 11px;">');@endphp
<table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
  <tr style="width: 100%">
    <th style="text-align: center;width: 100%" colspan="3"><strong>Request No:</strong> <p>{{ $data->order_id ?? '' }}</p></th>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Pay For Employee:</strong><p>{{json_decode($data->pay_for_employee_ary)->name ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
       <strong>Pay For Code:</strong><p>{{json_decode($data->pay_for_employee_ary)->employee_code ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Request Status:</strong><p>{{ \App\EmployeePay::requestStatus($data->status)}}</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Requested Employee:</strong><p>{{json_decode($data->employee_ary)->name ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Requested Employee Code:</strong><p>{{json_decode($data->employee_ary)->employee_code ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Requested Amount:</strong><p>{!! $inr !!}{{ $data->amount_requested }}</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Approved Amount:</strong><p>{!! $inr !!}{{ $data->amount_approved ?? '00' }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Address:</strong><p>{{ $data->address }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Bank Account Number:</strong><p>{{ $data->bank_account_number }}</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>IFSC:</strong><p>{{ $data->ifsc }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Pan Number:</strong><p>{{ $data->pan }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Nature Of Claim:</strong><p>{{ json_decode($data->nature_of_claim_ary)->name }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>TDS Required:</strong><p>{{ $data->required_tds ?? '' }}</p>
    </td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>TDS:</strong><p>{{ $data->tds }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>TDS Amount:</strong><p>{!! $inr !!}{{ $data->tds_amount }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>TDS Section:</strong><p>{{-- ($data->tds_month==0) ? '' : \App\EmployeePay::tdsMonth($data->tds_month) --}}{{ $data->tds_month }}</p>
    </td>
  </tr>
  @if(Auth::guard('employee')->user()->role_id!=4)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
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
    <td style="border: solid 1px #ccc;">
      <strong>Project Id:</strong><p>{{ $data->project_id }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Cost Center:</strong><p>{{ $data->cost_center }}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Description:</strong><p>{{ $data->description }}</p>
    </td>
  </tr>
  @if($data->form_by_account)
      @php $item=json_decode($data->form_by_account); @endphp
      <tr style="width: 100%">
        <td style="border: solid 1px #ccc;">
          <strong>Bank Account:</strong><p>{{$item->bank_account}}</p>
        </td>
        <td style="border: solid 1px #ccc;">
          <strong>IFSC:</strong><p>{{$item->ifsc}}</p>
        </td>
        <td style="border: solid 1px #ccc;">
          <strong>Bank Name:</strong><p>{{$item->bank_name}}</p>
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
    <td style="border: solid 1px #ccc;">
      <strong>Manager:</strong><p>{{json_decode($data->manager_ary)->name ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Manager Code:</strong><p>{{json_decode($data->manager_ary)->employee_code ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Manager Comment:</strong><p>{{$data->manager_comment}}</p>
    </td>
  </tr>
  @endif
  @if($data->account_dept_id && $data->account_dept_ary)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Account Office:</strong><p>{{json_decode($data->account_dept_ary)->name ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Account Code:</strong><p>{{json_decode($data->account_dept_ary)->employee_code ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Account Comment:</strong><p>{{$data->account_dept_comment}}</p>
    </td>
  </tr>
  @endif
  @if($data->trust_ofc_id && $data->trust_ofc_ary)
   <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Trust Office:</strong><p>{{json_decode($data->trust_ofc_ary)->name ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Trust Code:</strong><p>{{json_decode($data->trust_ofc_ary)->employee_code ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Trust Comment:</strong><p>{{$data->trust_ofc_comment}}</p>
    </td>
  </tr>
  @endif
  @if($data->payment_ofc_id && $data->payment_ofc_ary)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>Payment Office:</strong><p>{{json_decode($data->payment_ofc_ary)->name ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Payment Code:</strong><p>{{json_decode($data->payment_ofc_ary)->employee_code ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>Payment Comment:</strong><p>{{$data->payment_ofc_comment}}</p>
    </td>
  </tr>
  @endif
  @if($data->tds_ofc_id && $data->tds_ofc_ary)
   <tr style="width: 100%">
    <td style="border: solid 1px #ccc;">
      <strong>TDS Office:</strong><p>{{json_decode($data->tds_ofc_ary)->name ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>TDS Code:</strong><p>{{json_decode($data->tds_ofc_ary)->employee_code ?? ''}}</p>
    </td>
    <td style="border: solid 1px #ccc;">
      <strong>TDS Comment:</strong><p>{{$data->tds_ofc_comment}}</p>
    </td>
  </tr>
   @endif
  
  @if($data->item_detail && $data->nature_of_claim_id==1)
          @php $item=json_decode($data->item_detail); @endphp
          <tr style="width: 100%">
            <td colspan="3" style="padding: 0px;">
              <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
                <tr><td colspan="8"><h3>Item Detail</h3></td></tr>
                <tr>
                  <th style="border: solid 1px #ccc;">Sr</th>
                  <th style="border: solid 1px #ccc;">Bill Number</th>
                  <th style="border: solid 1px #ccc;">Date</th>
                  <th style="border: solid 1px #ccc;">Location</th>
                  <th style="border: solid 1px #ccc;">Category</th>
                  <th style="border: solid 1px #ccc;">Quantity</th>
                  <th style="border: solid 1px #ccc;">Rate</th>
                  <th style="border: solid 1px #ccc;">Amount</th>
                </tr>
                @forelse($item->itemDetail as $itemKey => $itemVal)
                  <tr style="width: 100%">
                    <td style="border: solid 1px #ccc;">{{ ++$itemKey }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->bill_number }}</td>
                    <td style="border: solid 1px #ccc;">{{ \App\Helpers\Helper::onlyDate($itemVal->date) ?? '' }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->location }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->category }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->quantity }}</td>
                    <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $itemVal->rate }}</td>
                    <td style="border: solid 1px #ccc;">{!! $inr !!}{{ ($itemVal->quantity*$itemVal->rate) }}</td>
                  </tr>
                @empty
                @endforelse
                <tr style="width: 100%">
                  <td colspan="7">Total Requested Amount</td>
                  <td style="border: solid 1px #ccc;">{!! $inr !!}{{ $data->amount_requested }}</td>
                </tr>
              </table>
            </td>
          </tr>
        @elseif($data->item_detail && $data->nature_of_claim_id==2)
        @php $item=json_decode($data->item_detail); @endphp
        <tr style="width: 100%">
            <td colspan="3" style="padding: 0px;">
              <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
                <tr style="width: 100%"><td colspan="8"><h3>Item Detail</h3></td></tr>
                <tr style="width: 100%">
                  <th style="border: solid 1px #ccc;">Sr</th>
                  <th style="border: solid 1px #ccc;">Bill Number</th>
                  <th style="border: solid 1px #ccc;">Date</th>
                  <th style="border: solid 1px #ccc;">From Location</th>
                  <th style="border: solid 1px #ccc;">To Location</th>
                  <th style="border: solid 1px #ccc;">Distance</th>
                  <th style="border: solid 1px #ccc;">Mode Of travel</th>
                  <th style="border: solid 1px #ccc;">Amount</th>
                </tr>
                @forelse($item->itemDetail as $itemKey => $itemVal)
                  <tr style="width: 100%">
                    <td style="border: solid 1px #ccc;">{{ ++$itemKey }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->bill_number }}</td>
                    <td style="border: solid 1px #ccc;">{{ \App\Helpers\Helper::onlyDate($itemVal->date) ?? '' }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->from_location }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->to_location }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->distance }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->category }}</td>
                    <td style="border: solid 1px #ccc;">{!! $inr !!}{{($itemVal->amount) }}</td>
                  </tr>
                @empty
                @endforelse
                <tr style="width: 100%">
                  <td colspan="7">Total Requested Amount</td>
                  <td style="border: solid 1px #ccc;">{!! $inr !!}{{$data->amount_requested }}</td>
                </tr>
              </table>
            </td>
        </tr>
        @elseif($data->item_detail && $data->nature_of_claim_id==3)
        @php $item=json_decode($data->item_detail); @endphp
        <tr style="width: 100%">
            <td colspan="3" style="padding: 0px;">
             <table style="width: 100%; text-align: left; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
                <tr style="width: 100%"><td colspan="5"><h3>Item Detail</h3></td></tr>
                <tr style="width: 100%">
                  <th style="border: solid 1px #ccc;">Sr</th>
                  <th style="border: solid 1px #ccc;">Bill Number</th>
                  <th style="border: solid 1px #ccc;">Date</th>
                  <th style="border: solid 1px #ccc;">
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
                  <th style="border: solid 1px #ccc;">Amount</th>
                </tr>
                @forelse($item->itemDetail as $itemKey => $itemVal)
                  <tr style="width: 100%">
                    <td style="border: solid 1px #ccc;">{{ ++$itemKey }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->bill_number }}</td>
                    <td style="border: solid 1px #ccc;">{{ \App\Helpers\Helper::onlyDate($itemVal->date) ?? '' }}</td>
                    <td style="border: solid 1px #ccc;">{{ $itemVal->category }} ( {{ $itemVal->sub_category }} )</td>
                    <td style="border: solid 1px #ccc;">{!! $inr !!}{{($itemVal->amount) }}</td>
                  </tr>
                @empty
                @endforelse
                <tr style="width: 100%">
                  <td colspan="4">Total Requested Amount</td>
                  <td style="border: solid 1px #ccc;">{!! $inr !!}{{$data->amount_requested }}</td>
                </tr>
              </table>
            </td>
        </tr>
          @if($subCatMedicle=='Medical welfare')
           <tr style="width: 100%">
              <td colspan="3">
                <strong>Pay To:</strong><p>{{ $item->medical->pay_to ?? ''}}</p>
              </td>
            </tr>
            @if(isset($item->medical->pay_to) && $item->medical->pay_to=='Pay to Hospital')
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;">
                <strong>Bank Name:</strong><p>{{ $item->medical->bank_name ?? ''}}</p>
              </td>
              <td style="border: solid 1px #ccc;">
                <strong>Bank Account Number:</strong><p>{{ $item->medical->bank_account_number ?? ''}}</p>
              </td>
              <td style="border: solid 1px #ccc;">
                <strong>Branch Address:</strong><p>{{ $item->medical->branch_address ?? ''}}</p>
              </td>
            </tr>
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;">
                <strong>Hospital Name:</strong><p>{{ $item->medical->hsptl_name ?? ''}}</p>
              </td>
              <td style="border: solid 1px #ccc;">
                <strong>Account Holder:</strong><p>{{ $item->medical->bank_account_holder ?? ''}}</p>
              </td>
              <td style="border: solid 1px #ccc;">
                <strong>IFSC:</strong><p>{{ $item->medical->ifsc ?? ''}}</p>
              </td>
            </tr>
            <tr style="width: 100%">
              <td style="border: solid 1px #ccc;">
                <strong>Pan:</strong><p>{{ $item->medical->pan ?? ''}}</p>
              </td>
              <td style="border: solid 1px #ccc;">
                
              </td>
              <td style="border: solid 1px #ccc;">
                
              </td>
            </tr>
          
            @endif
          @endif
        @endif
 
      @forelse($data->empReqImage as $key => $val)
         <tr style="width: 100%">
            <td colspan="1">
                {!! Html::decode(link_to('public/'.$val->emp_req_file_path,\App\Helpers\Helper::getDocType($val->emp_req_file_path,$val->emp_req_file_type),['target'=>'_blank'])) !!}
            </td>
            <td colspan="2">
              <p>{{ $val->emp_req_file_description }}</p>
            </td>
          </tr>
        @empty
        @endforelse
 
</table>

