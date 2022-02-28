@extends('layouts.employee')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
 
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingEmpPay','Pending Request',[],[])}}
              </li>
              <li class="breadcrumb-item active">Approve</li>
            </ol> 
          </div>
        </div> 
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Approve Form {{ $data->order_id }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            {{ Form::open(['route'=>['employee.EmployeePayFormApprove',$data->order_id,$page],'files'=>true,'onSubmit'=>'return cheackAmount()'])}}
              <div class="row">

                    <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Approval','Approve') }}
                        {{ Form::select('status',\App\EmployeePay::EmpPayStatusChange(),'',['class'=>'form-control custom-select select2','placeholder'=>'Give Approval','onchange'=>"chkReq()",'id'=>'status','required'=>true]) }}
                        <span class="text-danger">{{ $errors->first('status')}}</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Comment','Comment') }}
                        {{ Form::textarea('comment','',['class'=>'form-control','placeholder'=>'Comment here','id'=>'status_cmt','rows'=>3]) }}
                        <span class="text-danger">{{ $errors->first('comment')}}</span>
                      </div>
                    </div>
                    <!--  -->

 

                    <!--  -->
                  @php
                    $dataTds=$data->tds ?? '';
                    $tds_amount=$data->tds_amount ?? '';
                    $tds_month=$data->tds_month ?? '';
                    $project_id=$data->project_id ?? '';
                    $cost_center=$data->cost_center ?? '';
                  @endphp
                @if(Auth::guard('employee')->user()->role_id==9)
                  <div class="col-sm-6 tds_param">
                    <!-- radio -->
                    {{ Form::label('Required TDS','Required TDS') }}
                    <div class="form-group clearfix">
                     @php 
                       $self=($data->required_tds=='Yes' || old('required_tds')=='Yes') ? true : false;
                       $odr=($data->required_tds=='No' || old('required_tds')=='No') ? true : false;
                     @endphp
                      <div class="icheck-primary d-inline">
                        {{ Form::radio('required_tds','Yes',$self,['class'=>'tds_radio','id'=>'required_tds1']) }}
                        {{ Form::label('required_tds1','Yes')}}
                      </div>
                      <div class="icheck-primary d-inline">
                        {{ Form::radio('required_tds','No',$odr,['class'=>'tds_radio','id'=>'required_tds2']) }}
                        {{ Form::label('required_tds2','No')}}
                      </div>
                     
                    </div>
                     <span class="text-danger">{{ $errors->first('required_tds')}}</span>
                  </div>

                  
                  @if($data->required_tds=='Yes' || old('required_tds')=='Yes')
                  <div class="col-md-6 tds_fld">
                     <div class="form-group">
                        {{ Form::label('tds','TDS') }}
                        {{ Form::number('tds',$data->tds ,['class'=>'form-control tds','placeholder'=>'TDS','required'=>true,'onkeyup'=>"chlAmt()"]) }}
                        <span class="text-danger">{{ $errors->first('tds')}}</span>
                      </div>
                    </div>
                    <div class="col-md-6 tds_fld">
                     <div class="form-group">
                        {{ Form::label('tds_amount','TDS Amount') }}
                        {{ Form::number('tds_amount',($data->tds_amount==0) ? '' : $data->tds_amount,['class'=>'form-control tds_amt','placeholder'=>'TDS','required'=>true]) }}
                        <span class="text-danger">{{ $errors->first('tds_amount')}}</span>
                      </div>
                    </div>
                    <div class="col-md-6 tds_fld">
                     <div class="form-group">
                        {{ Form::label('tds_month','TDS Section') }}
                        {{-- Form::select('tds_month',\App\EmployeePay::tdsMonth(),($data->tds_month==0) ? '' : $data->tds_month,['class'=>'form-control custom-select select2','placeholder'=>'Select TDS Section','required'=>true]) --}}
                        {{ Form::text('tds_month',$tds_month,['class'=>'form-control','placeholder'=>'TDS Section','required'=>true]) }}
                        <span class="text-danger">{{ $errors->first('tds_month')}}</span>
                      </div>
                    </div>

                    <div class="col-md-6 tds_fld">
                     <div class="form-group">
                        {{ Form::label('project_id','Project Id') }}
                        {{ Form::text('project_id',$data->project_id,['class'=>'form-control','placeholder'=>'Project id','required'=>true]) }}
                        <span class="text-danger">{{ $errors->first('project_id')}}</span>
                      </div>
                    </div>
                    <div class="col-md-6 tds_fld">
                     <div class="form-group">
                        {{ Form::label('sec_cost_center','Cost Center') }}
                        {{ Form::text('sec_cost_center',$data->cost_center,['class'=>'form-control','placeholder'=>'Cost Center','required'=>true]) }}
                        <span class="text-danger">{{ $errors->first('sec_cost_center')}}</span>
                      </div>
                    </div>
                    @endif
                @endif

                @if(Auth::guard('employee')->user()->role_id==7)
                  <div class="col-md-6">
                   <div class="form-group">
                      {{ Form::label('amount_approved','Amount Approved') }}
                      {{ Form::number('amount_approved',$data->amount_approved ? $data->amount_approved : $data->amount_requested,['class'=>'form-control','placeholder'=>'Amount Approved','readonly'=>true]) }}
                      <span class="text-danger">{{ $errors->first('amount_approved')}}</span>
                    </div>
                  </div>
                @endif
               
                @if(Auth::guard('employee')->user()->role_id==9)
                  <div class="col-md-6">
                   <div class="form-group">
                      {{ Form::label('specified_person','Specified Person') }}
                      {{ Form::select('specified_person',['Yes'=>'Yes','No'=>'No'],$data->specified_person,['class'=>'form-control custom-select select2','placeholder'=>'Specified person']) }}
                      <span class="text-danger">{{ $errors->first('specified_person')}}</span>
                    </div>
                  </div>
                @endif 
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
                        <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name }}</p>
                      </li>
                      <li>
                        <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
                      </li>
                      <li>
                        <strong>Transaction Date:</strong><p>{{ $data->transaction_date }}</p>
                      </li>

                  </ul>
                    @if(Auth::guard('employee')->user()->role_id!=5)
                      <ul>
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
                            <strong>TDS Section:</strong><p>{{ $data->tds_month }}</p>
                          </li>
                          <li>
                            <strong>Project Id:</strong><p>{{ $data->project_id }}</p>
                          </li>

                          <li>
                            <strong>Cost Center:</strong><p>{{ $data->cost_center }}</p>
                          </li>
                      </ul>
                    @endif
                      @if($data->manager_id && $data->manager_ary)
                       <ul>
                        <li class="col-md-6">
                          <strong>Manager:</strong><p>{{json_decode($data->manager_ary)->name ?? ''}}</p>
                        </li>
                        <li class="col-md-6">
                          <strong>Manager Code:</strong><p>{{json_decode($data->manager_ary)->employee_code ?? ''}}</p>
                        </li>
                        <li class="col-md-12">
                          <strong>Manager Comment:</strong><p>{{ $data->manager_comment }}</p>
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
                          <strong>Account Comment:</strong><p>{{ $data->account_dept_comment }}</p>
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
                          <strong>Trust Comment:</strong><p>{{ $data->trust_ofc_comment }}</p>
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
                          <strong>Payment Comment:</strong><p>{{ $data->payment_ofc_comment }}</p>
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
                          <strong>TDS Comment:</strong><p>{{ $data->ptds_ofc_comment }}</p>
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
                            <th>Expenditure Category</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Amount</th>
                          </tr>
                          @forelse($item->itemDetail as $itemKey => $itemVal)
                            <tr>
                              <td>{{ ++$itemKey }}</td>
                              <td>{{ $itemVal->bill_number }}</td>
                              <td>{{ $itemVal->date }}</td>
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
                      @endif
                      @if($data->item_detail && $data->nature_of_claim_id==2)
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
                              <td>{{ $itemVal->date }}</td>
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
                              <th>Amount <button type="button" class="btn btn-info" onClick="getMedicalPayHistory('{{$subCatMedicle}}')" title="Payment History"><i class="fa fa-eye" aria-hidden="true"></i></button></th>
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
                                    <strong>Branch Code:</strong><p>{{ $item->medical->branch_code ?? ''}}</p>
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
                </div>

                <!--  -->
                 <div class="col-md-12">
                   <div class="row">
                   @php $bnkitem=[];@endphp
                     @if($data->form_by_account)
                        @php $bnkitem=json_decode($data->form_by_account); @endphp
                      @endif
                    @if(Auth::guard('employee')->user()->role_id==9)
                      <div class="col-md-4">
                        <div class="form-group">
                          {{ Form::label('Bank Account','Bank Account') }}
                           {{-- Form::text('bank_account['.$data->id.']',$bnkitem->bank_account ?? '',['class'=>'form-control','placeholder'=>'Bank Account','id'=>'bank_account_data']) --}}
 
                           {{ Form::select('bank_account['.$data->id.']',\App\BankAccount::bnkHeadOfcPluck(),$bnkitem->bank_account ?? '',['class'=>'form-control custom-select select2','placeholder'=>'Bank Account','id'=>'bank_account_data','required'=>true]) }}
                          <span class="text-danger">{{ $errors->first('bank_account.*')}}</span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          {{ Form::label('IFSC','IFSC') }}
                          {{ Form::text('ifsc['.$data->id.']',$bnkitem->ifsc ?? '',['class'=>'form-control','placeholder'=>'IFSC','id'=>'ifsc_data']) }}
                          <span class="text-danger">{{ $errors->first('ifsc.*')}}</span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          {{ Form::label('Bank Name','Bank Name') }}
                              {{ Form::text('bank_name['.$data->id.']',$bnkitem->bank_name ?? '',['class'=>'form-control','placeholder'=>'Bank Name','id'=>'bank_name_data']) }}
                              <span class="text-danger">{{ $errors->first('bank_name.*')}}</span>
                        </div>
                      </div>
                    @endif
                 </div>
                    @if(Auth::guard('employee')->user()->role_id==9)
                      <div class="col-md-12">
                            <div class="row">
                               <div class="col-md-3">
                                 <div class="form-group">
                                      {{ Form::label('Debit account','Debit account',['class'=>'sr']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                 <div class="form-group">
                                      {{ Form::label('Amount','Amount') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                 <div class="form-group">
                                      {{ Form::label('Cost Center','Cost Center') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                 <div class="form-group">
                                      {{ Form::label('Category','Category') }}
                                    </div>
                                </div>
                                
                            </div>
                          </div>
                        @if($data->form_by_account)
                            @php $item=json_decode($data->form_by_account); @endphp
                            @forelse($item->form_by_account as $itemKey => $itemVal)
                              <div class="row w-100" id="SavGoods{{$itemKey}}">
                                 <div class="col-md-3">
                                   <div class="form-group">
                                        
                                        {{-- Form::text('debit_account[]',$itemVal->debit_account,['class'=>'form-control','placeholder'=>'Debit account','required'=>true,'id'=>'']) --}}
                                        {{ Helper::debitAccount($itemVal->debit_account)}}
                                        <span class="text-danger">{{ $errors->first('debit_account.*')}}</span>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                   <div class="form-group">
                                       
                                        {{ Form::number('amount[]',$itemVal->amount,['class'=>'form-control debit_amt','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
                                        <span class="text-danger">{{ $errors->first('amount.*')}}</span>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                   <div class="form-group">
                                        
                                        {{-- Form::text('cost_center[]',$itemVal->cost_center,['class'=>'form-control','placeholder'=>'Cost Center','required'=>true,'id'=>'']) --}}
                                        {{Helper::costCenter($itemVal->cost_center)}}
                                        <span class="text-danger">{{ $errors->first('cost_center.*')}}</span>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                   <div class="form-group">
                                       {{-- Form::text('category[]',$itemVal->category,['class'=>'form-control','placeholder'=>'Category','required'=>true,'id'=>'']) --}}
                                       {{Helper::category($itemVal->category)}}
                                        <span class="text-danger">{{ $errors->first('category.*')}}</span>
                                      </div>
                                  </div>
                                <div class="col-md-1 ItemRemove">
                                 <div class="form-group">
                                    {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger','onclick'=>"rawRemove($itemKey)"])) !!}
                                 </div>
                                </div>
                              </div>
                            @empty
                            @endforelse
                        @endif
                            <div class="col-md-12">
                              @if($data->form_by_account=='')
                                <div class="row">
                                 <div class="col-md-3">
                                   <div class="form-group">
                                         {{-- Form::text('debit_account[]','',['class'=>'form-control','placeholder'=>'Debit account','required'=>true,'id'=>'']) --}}
                                         {{Helper::debitAccount()}}
                                        <span class="text-danger">{{ $errors->first('debit_account.*')}}</span>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                   <div class="form-group">
                                        {{ Form::number('amount[]','',['class'=>'form-control debit_amt','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
                                        <span class="text-danger">{{ $errors->first('amount.*')}}</span>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                   <div class="form-group">
                                        {{-- Form::text('cost_center[]','',['class'=>'form-control','placeholder'=>'Cost Center','required'=>true,'id'=>'']) --}}
                                        {{Helper::costCenter()}}
                                        <span class="text-danger">{{ $errors->first('cost_center.*')}}</span>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                   <div class="form-group">
                                         {{-- Form::text('category[]','',['class'=>'form-control','placeholder'=>'Category','required'=>true,'id'=>'']) --}}
                                         {{Helper::category()}}
                                        <span class="text-danger">{{ $errors->first('category.*')}}</span>
                                      </div>
                                  </div>
                              </div>
                              @endif
                              <div id="Goods">
                              </div>
                              <div class="col-md-12 text-right">
                                {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                              </div>
                            </div>
                    @else
                            @if($data->form_by_account)
                              @php $item=json_decode($data->form_by_account); @endphp
                              <div class="col-md-12"> 
                                <table class="table" width="100%">
                                  <tr>
                                    <td><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></td>
                                    <td><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></td>
                                    <td><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></td>
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
                                      <td>{{$itemVal->debit_account}}
                                    </td>
                                      <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->amount}}
                                      {{ Form::hidden('amount[]',$itemVal->amount,['class'=>'form-control debit_amt','placeholder'=>'Amount','id'=>'']) }}
                                    </td>
                                      <td>{{$itemVal->cost_center}}</td>
                                      <td>{{$itemVal->category}}</td>
                                    </tr>
                                  @empty
                                  @endforelse
                                </table>
                              </div>
                            @endif
                    @endif 
                 </div>
                <!-- /.col  -->
              </div>

              <div class="row imgSection">
                  <div class="col-md-3" id="IMAGESEC">
                        <div class="form-group">
                          {!!Form::label('Attachments', 'Attachments')!!}
                             {!!Form::file('emp_req_file[]',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                          @if($errors->has('emp_req_file'))
                              <p class="text-danger">{{$errors->first('emp_req_file')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                          {!!Form::label('description', 'Attachment Description')!!}
                             {!!Form::textarea('emp_req_file_description[]','',['class'=>'form-control','rows'=>3,'placeholder'=>'Description about attachment file'])!!}
                          @if($errors->has('emp_req_file_description'))
                              <p class="text-danger">{{$errors->first('emp_req_file_description')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 text-left editIcon">
                      {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary addIMg'])) !!}
                      {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger removeIMg','style'=>'display:none'])) !!}
                    </div>
              </div>
            <!-- /.row -->
              <div class="card-footer">
                <p class="text-danger subAlert"></p>
                {!! Form::submit('Update',['class'=>'btn btn-outline-primary']) !!}
              </div>
           {{ Form::close() }}
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

 <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header noprint">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body P-0" id="modal-body">

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>

@endsection

@section('footer')
@php
$log_role = Auth::guard('employee')->user()->role_id;
$monthAry=['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'];
/*$selectDrop=Form::select('tds_month',$monthAry,$tds_month,['class'=>'form-control custom-select select2','required'=>true,'id'=>'tds_month','placeholder'=>'Select TDS Month']);*/

$selectDrop=Form::text('tds_month',$tds_month,['class'=>'form-control','required'=>true,'id'=>'tds_month','placeholder'=>'TDS Section']);

$debitAccount=Helper::debitAccount();
$costCenter=Helper::costCenter();
$category=Helper::category();
@endphp
<script type="text/javascript">
  function chkReq() {
   var stVal = ($('#status').val());
   if (stVal==2) {
      $('#status_cmt').attr('required',true);
   }else{
    $('#status_cmt').attr('required',false);
   }
  }

  $(document).ready(function(){
      $('#srchEmp').on('change',function(){
      var empId=$(this).val();
      if (empId!='') {
        var url="{{ route('employee.getEmpCodeEmpPay') }}";
             
              $.ajax({
                type:"POST",
                url:url,
                data:{empId:empId , _token: '{{csrf_token()}}',type:'getEmpCodeEmpPay'},
                beforeSend: function(){
                 //$('#preloader').show();
                },
                success:function(response){
                   $('#employee_code').val(response);
                  //$('#preloader').hide();
                }
              });
      }else{
        $('#employee_code').empty();
      }
    });
  });
</script>
<script type="text/javascript">
  $('.radio').click(function(){
    if($(this).val()=='other'){
      $('.empDiv').show();
    }else{
      $('.empDiv').hide();
    }
  });

  $('.addIMg').click(function() {
    var cls = $('.IMGRow').length;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="col-md-3 IMGRow"> <div class="form-group"> <label for="file">Attachment</label> <input class="dropify form-control" data-default-file="" id="input-file-now-custom-1" name="emp_req_file[]" type="file" required> </div><div class="form-group"> <label for="description">Attachment Description</label> <textarea class="form-control" rows="3" name="emp_req_file_description[]" cols="50" placeholder="Description about attachment file"></textarea> </div></div>';
      $('#IMAGESEC').after(clone);
      var cls = $('.IMGRow').length;
      if (cls) {
        $('.removeIMg').show();
      }
  });
  $('.removeIMg').click(function(){
      var cls = $('.IMGRow').length;
      if (cls == 1) {
        $('.removeIMg').hide();
      }
      $('.IMGRow').last().remove();
  });

  $('.tds_radio').click(function(){
    var tds=$("input[type=radio][name=required_tds]:checked").val();
    if (tds=='Yes') {
      $('.tds_fld').remove();
      $('.tds_param').after('<div class="col-md-6 tds_fld"> <div class="form-group"> <label for="tds">TDS</label> <input class="form-control tds" placeholder="TDS" required="" name="tds" type="number" value="{{$dataTds}}" id="tds" onkeyup="chlAmt()"> <span class="text-danger"></span> </div></div><div class="col-md-6 tds_fld"> <div class="form-group"> <label for="tds_amount">TDS Amount</label> <input class="form-control tds_amt" placeholder="TDS Amount" required="" name="tds_amount" type="number" value="{{$tds_amount}}" id="tds_amount"> <span class="text-danger"></span> </div></div><div class="col-md-6 tds_fld"> <div class="form-group"> <label for="tds_month">TDS Section</label>{{$selectDrop}}</div></div><div class="col-md-6 tds_fld"> <div class="form-group"> <label for="project_id">Project Id</label> <input class="form-control" placeholder="Project id" required="" name="project_id" type="text" id="project_id" value="{{$project_id}}"> <span class="text-danger"></span> </div></div><div class="col-md-6 tds_fld"> <div class="form-group"> <label for="cost_center">Cost Center</label> <input class="form-control" placeholder="Cost Center" required="" name="sec_cost_center" type="text" id="cost_center" value="{{$cost_center}}"> <span class="text-danger"></span> </div></div>');
    }else{
      $('.tds_fld').remove();
    }
  });

   function getMedicalPayHistory(argument) {
    var url="{{ route('employee.getMedicalEmpPayHistory') }}";
    var emp_type = $("input[type=radio][name=pay_for]:checked").val();
    var emp_id='{{ $data->pay_for_employee_id ?? 0 }}';
       
      var status=$('#status').val() ?? '';
      var from_date=$('#from_date').val() ?? '';
      var till_date=$('#till_date').val() ?? '';
    $.ajax({
          type:"POST",
          url:url,
          data:{sub_category:argument , _token: '{{csrf_token()}}',type:'getMedicalPayHistory',emp_id:emp_id,status:status,from_date:from_date,till_date:till_date},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#modal-body').html(response);
            $('#modal-default').modal('show');
            //$('#preloader').hide();
          }
        });
  }

    $('.trash').click(function(){
      var cls = $('.Goods').length;
      if (cls == 1) {
        $('.trash').hide();
      }
      $('.Goods').last().remove();
  });
  $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-3"> <div class="form-group">{{$debitAccount}}<span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group"> <input class="form-control debit_amt" placeholder="Amount" required="" id="" name="amount[]" type="number" value=""> <span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group">{{$costCenter}}<span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group">{{$category}}<span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
    $('#Goods').append(clone);
    var cls = $('.Goods').length;
    var p_sr=1; 
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
    if (cls) {
      $('.trash').show();
    }
  });


   function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }

  $('#bank_account_data').change(function(){
    var accNo=$(this).val();
    if (accNo) {
      var url="{{ route('employee.getBankCommonDetail') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{accNo:accNo , _token: '{{csrf_token()}}'},
          beforeSend: function(){
          // $('#preloader').show();
          },
          success:function(response){
            if (response) {
              $('#ifsc_data').val(response.ifsc);
              $('#bank_name_data').val(response.bank_name);
                // $('#modal-body').html(response);
                // $('#modal-default').modal('show');
            }
           // $('#preloader').hide();
          }
        });
    }else{
      $('#ifsc_data').val(null);
      $('#bank_name_data').val(null);
    }
  });

function cheackAmount() {
  var role ='{{ $log_role }}';
  if (role==9) {
    var amount='{{ $data->amount_requested }}';
    var sum = 0;
      $("input[class *= 'debit_amt']").each(function(){
          sum += +$(this).val();
      });
    if (amount==sum) {
      return true;
    }else{
      $('.subAlert').text('Employee pay request amount is ₹'+amount+'. So debit account must be equal according to invoice amount. Your current debit account amount is ₹'+sum);
      return false;
    }
  }
}

function chlAmt() {
    var amt='{{$data->amount_requested}}';
    var tds=$('.tds').val();
    var tax_amount='{{$data->tax_amount}}';
    var tds_amt=(amt*tds)/100;
    $('.tds_amt').val(parseInt(tds_amt));
    var final=parseFloat(amt)-parseFloat(tds_amt)+parseFloat(tax_amount);
    //alert(amt+'-'+tds_amt+'-'+tax_amount);
    $('.tds_payable').val(parseInt(final));
  }
</script>
 @endsection
