@if($type=='getEmpPayDetail')
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
        <strong>TDS Section:</strong><p>{{-- ($data->tds_month==0) ? '' : \App\EmployeePay::tdsMonth($data->tds_month) --}}{{ $data->tds_month }}</p>
      </li>
      <li>
        <strong>Project Id:</strong><p>{{ $data->project_id }}</p>
      </li>

      <li>
        <strong>Cost Center:</strong><p>{{ $data->cost_center }}</p>
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
@elseif($type=='getItemRowByClaim')
  @if($data->id==1)
    @if($headRow==0)
        <div class="row headRow">
          <div class="col-md-1 srDiv">
         <div class="form-group">
            {{ Form::label('Sr','Sr.') }}
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            {{ Form::label('Date','Date') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('location','Location') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('expenditure_category','Expenditure Category') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('qty','Quantity') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('rate','Rate') }}
          </div>
        </div>

        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('bill_number','Bill Number') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('amount','Amount') }}
          </div>
        </div>
      </div>
    @endif
    <div class="row newGD Goods" id="removeItemRow{{$cls}}">
      <div class="col-md-1 srDiv">
        <p class="sr">{{$cls}}</p>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="" max="{{date('Y-m-d')}}">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Location" id="" name="location[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <select name="category[]" class="form-control custom-select select2" id="">
            <option value="">Choose</option>
            @if($data->category)
              @forelse(json_decode($data->category) as $ckey => $cval)
                <option value="{{$cval}}">{{$cval}}</option>
              @empty
              @endforelse
            @endif
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Quantity" id="quantity{{$cls}}" name="quantity[]" type="number" value="" onKeyUp="countVal({{$cls}})" min="0">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Rate" id="rate{{$cls}}" name="rate[]" type="number" value="" onKeyUp="countVal({{$cls}})" min="0">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control amount" placeholder="Amount" id="amount{{$cls}}" name="amount[]" type="number" value="" readonly>
        </div>
      </div>
      <div class="col-md-1 ItemRemove">
        <div class="remRow_box">
          <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
  @elseif($data->id==2)
    @if($headRow==0)

        <div class="row headRow">
          <div class="col-md-1 srDiv">
         <div class="form-group">
            {{ Form::label('Sr','Sr.') }}
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            {{ Form::label('Date','Date') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('from_location','From') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('to_location','To') }}
          </div>
        </div>
         <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('distance','Distance') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('mode_of_travel','Mode of travel') }}
          </div>
        </div>
        
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('bill_number','Bill Number') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('amount','Amount') }}
          </div>
        </div>
      </div>
    
    @endif
    <div class="row newGDtrv Goods" id="removeItemRow{{$cls}}">
      <div class="col-md-1 srDiv">
        <p class="sr">{{$cls}}</p>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="" max="{{date('Y-m-d')}}">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Location" id="from_location" name="from_location[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Location" id="to_location" name="to_location[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Distance" id="distance0" name="distance[]" type="number" value="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <select name="category[]" class="form-control custom-select select2" id="">
            <option value="">Choose</option>
            @if($data->category)
              @forelse(json_decode($data->category) as $ckey => $cval)
                <option value="{{$cval}}">{{$cval}}</option>
              @empty
              @endforelse
            @endif
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="">
          <span class="text-danger"></span>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control amount_trv" placeholder="Amount" id="" name="amount[]" type="number" value="" onKeyUp="countVal()" min="0">
          <span class="text-danger"></span>
        </div>
      </div>
      <div class="col-md-1 ItemRemove">
        <div class="remRow_box">
          <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>
  @elseif($data->id==3)
        @if($headRow==0 && $subCatId=='Medical welfare')
          <div class="row hospital_sec">
            <div class="col-md-6">
              <!-- radio -->
              {{ Form::label('Pay to','Pay to') }}
              <div class="form-group clearfix">
                <div class="icheck-primary d-inline">
                  {{ Form::radio('pay_to','Pay to Hospital','',['class'=>'pay_to_radio','id'=>'pay_to1','required'=>true]) }}
                  {{ Form::label('pay_to1','Pay to Hospital')}}
                </div>
                <div class="icheck-primary d-inline">
                  {{ Form::radio('pay_to','Pay to Employee','',['class'=>'pay_to_radio','id'=>'pay_to2','required'=>true]) }}
                  {{ Form::label('pay_to2','Pay to Employee')}}
                </div>
              </div>
              <span class="text-danger">{{ $errors->first('pay_to')}}</span>
            </div>
          </div>
          <script type="text/javascript">
            $('.pay_to_radio').click(function(){
              var v=$(this).val();
              if (v=='Pay to Hospital') {
                $('.sub_hospital_sec').remove();
                $('.hospital_sec').append('<div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Bank Name">Bank Name</label> <input class="form-control" placeholder="Bank name" name="hsptl_bank_name" type="text" value="" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Bank Account Number">Bank Account Number</label> <input class="form-control" placeholder="Bank Account Number" name="hsptl_bank_account_number" type="text" value="" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Branch Address">Branch Address</label> <input class="form-control" placeholder="Branch Address" name="hsptl_branch_address" type="text" value="" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Branch Code">Hospital Name</label> <input class="form-control" placeholder="Hospital Name" name="hsptl_name" type="text" value="" required> </div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Account Holder Name">Account Holder Name</label> <input class="form-control" placeholder="Account Holder Name" name="hsptl_bank_account_holder" type="text" value="" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Bank IFSC">Bank IFSC Code</label> <input class="form-control" placeholder="Bank IFSC" name="hsptl_ifsc" type="text" value="" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Pan Number">Pan Number</label> <input class="form-control" placeholder="Pan" name="hsptl_pan" type="text" value=""></div></div>');
              }else{
                $('.sub_hospital_sec').remove();
              }
            });
          </script>
        @endif
        @if($headRow==0)
           <div class="row headRow">
              <div class="col-md-1 srDiv">
                 <div class="form-group">
                    {{ Form::label('Sr','Sr.') }}
                  </div>
                </div>
              <div class="col-md-2">
                <div class="form-group">
                  {{ Form::label('Date','Date') }}
                </div>
              </div>
              <div class="col-md-3">
               <div class="form-group">
                @if($subCatId!='Medical welfare')
                    {{ Form::label('Other description','Other description') }}
                  @elseif($subCatId=='Medical welfare')
                   {{ Form::label('category','Category') }}
                  @endif
                  
                </div>
              </div>
            
              <div class="col-md-3">
               <div class="form-group">
                  {{ Form::label('bill_number','Bill Number') }}
                </div>
              </div>
              <div class="col-md-2">
               <div class="form-group">
                  {{ Form::label('amount','Amount') }}
                </div>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-info" onClick="getMedicalPayHistory('{{$subCatId}}')" title="Payment History"><i class="fa fa-eye" aria-hidden="true"></i></button>
              </div>
             </div>
        @endif
      <div class="row newGDtrv Goods" id="removeItemRow{{$cls}}">
        <div class="col-md-1 srDiv">
          <p class="sr">{{$cls}}</p>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="" max="{{date('Y-m-d')}}">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            @if($subCatId!='Medical welfare')
              {{ Form::text('category[]','',['class'=>'form-control','placeholder'=>'Other description','required'=>false]) }}
            @elseif($subCatId=='Medical welfare')
              <select name="category[]" class="form-control custom-select select2" id="">
                <option value="">Choose</option>
                  @forelse(\App\EmployeePay::medicalCategory() as $ckey => $cval)
                    <option value="{{$cval}}">{{$cval}}</option>
                  @empty
                  @endforelse
              </select>
            @endif
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="">
            <span class="text-danger"></span>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <input class="form-control amount_trv" placeholder="Amount" id="" name="amount[]" type="number" value="" onKeyUp="countVal()" min="0">
            <span class="text-danger"></span>
          </div>
        </div>
        <div class="col-md-1 ItemRemove">
          <div class="remRow_box">
            <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
  @endif
<script type="text/javascript">
  function removeItemRow(argument) {
     // alert();
      $('#removeItemRow'+argument).remove();
      var p_sr=1;
      $("p[class *= 'sr']").each(function(){
          ($(this).text(p_sr++));
      });
      var sum = 0;
      $("input[class *= 'amount']").each(function(){
          sum += +$(this).val();
      });
      $("#amount_requested").val(sum);
    }
</script>
@elseif($type=='getItemSubCategory')

<div class="col-md-6">
  <div class="form-group">
    {{ Form::label('Employee Relief Category','Employee Relief Category')}}
    <select name="sub_category" class="form-control custom-select select2" id="subCatId" required="required" onchange="getDataRow()">
      <option value="">Choose</option>
      @if($data->category)
      @php $subMedCat =json_decode($data->category); @endphp
        @if(Auth::guard('employee')->user()->medical_welfare!='Yes')
            @php 
              if (($key = array_search('Medical welfare', $subMedCat)) !== false) {
                  unset($subMedCat[$key]);
              }
            @endphp
          @endif
        @forelse($subMedCat as $ckey => $cval)
          <option value="{{$cval}}">{{$cval}}</option>
        @empty
        @endforelse
      @endif
    </select>
  </div>
</div>
{{--<div class="col-sm-6">
  {{ Form::label('Pay to','Pay to') }}
  <div class="form-group clearfix">
   
    <div class="icheck-primary d-inline">
      {{ Form::radio('payment_to','Pay to Hospital','',['class'=>'radio1','id'=>'payment_to1','required'=>true]) }}
      {{ Form::label('payment_to1','Pay to Hospital')}}
    </div>
    <div class="icheck-primary d-inline">
      {{ Form::radio('payment_to','Pay to Employee','',['class'=>'radio1','id'=>'payment_to2','required'=>true]) }}
      {{ Form::label('payment_to2','Pay to Employee')}}
    </div>
   
  </div>
   <span class="text-danger">{{ $errors->first('payment_to')}}</span>
</div>--}}

@elseif($type=='getMedicalPayHistory')
<div class="row">
  <div class="col-md-4">
      {{ Form::label('Status','Status') }}
      {{ Form::select('status',['1'=>'Pending','2'=>'Reject','7'=>'Approved'],$status,['class'=>'form-control custom-select select2','id'=>'status','placeholder'=>'All','onchange'=>"getMedicalPayHistory('$sub_category')"]) }}
  </div>
  <div class="col-md-4">
    {{ Form::label('From date','From date') }}
    {{ Form::date('from_date',$from_date,['class'=>'form-control','id'=>'from_date','placeholder'=>'From date','onchange'=>"getMedicalPayHistory('$sub_category')"]) }}
  </div>
  <div class="col-md-4">
    {{ Form::label('Till date','Till date') }}
    {{ Form::date('till_date',$till_date,['class'=>'form-control','id'=>'till_date','placeholder'=>'Till date','onchange'=>"getMedicalPayHistory('$sub_category')"]) }}
  </div>
 
  <div class="col-md-12">
    <table class="table">
      <thead>
        <tr>
          <th>Sr:</th>
          <th>Requested Amount</th>
          <th>Approved Amount</th>
          <th>Status</th>
          <th>Category</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $key => $val)
          <tr>
            <td>{{++$key}}</td>
            <td>{{ env('CURRENCY_SYMBOL') }}{{ $val->amount_requested ?? '00' }}</td>
            <td>{{ env('CURRENCY_SYMBOL') }}{{ $val->amount_approved ?? '00' }}</td>
            <td>{{ \App\EmployeePay::requestStatus($val->status)}}</td>
            <td>{{ $val->sub_category }}</td>
            <td>{{ \App\Helpers\Helper::onlyDate($val->created_at) ?? '' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-danger text-center">Payment History Not Found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@elseif($type=='getEmpAccountArray')
  <div class="form-group">
    {{ Form::label('Bank Accounts','Bank Accounts')}}
    {{ Form::select('bank_account_number',$data,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Account','required'=>true]) }}
    <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
  </div>
@endif
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  });

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false;

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template");
  previewNode.id = "";
  var previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  });

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
  });

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
  });

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1";
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
  });

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0";
  });

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
  };
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true);
  };
  
  
</script>