@extends('layouts.employee')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
 
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingEmpPay','Pending Request',[],[])}}
              </li>
              <li class="breadcrumb-item active">Update</li>
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
            <h3 class="card-title">Update Form</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            {{ Form::open(['route'=>['employee.EmployeePayFormUpdate',$data->order_id,$page],'files'=>true])}}
              <div class="row">

                  <div class="col-sm-6">
                    <!-- radio -->
                    {{ Form::label('Employee Form For','Employee Form For') }}
                    <div class="form-group clearfix">
                     @php 
                       $self=($data->pay_for=='self') ? true : false;
                       $odr=($data->pay_for=='other') ? true : false;
                     @endphp
                      <div class="icheck-primary d-inline">
                        {{ Form::radio('pay_for','self',$self,['class'=>'radio','id'=>'radioPrimary1']) }}
                        {{ Form::label('radioPrimary1','Self')}}
                      </div>
                      <div class="icheck-primary d-inline">
                        {{ Form::radio('pay_for','other',$odr,['class'=>'radio','id'=>'radioPrimary2']) }}
                        {{ Form::label('radioPrimary2','Other Employee')}}
                      </div>
                     
                    </div>
                     <span class="text-danger">{{ $errors->first('pay_for')}}</span>
                  </div>
                  
                  @php
                    $empDiv="display:none";
                    $bnkAccounts=[];
                    if((old('pay_for') && old('pay_for')=='other') || $data->pay_for=='other'){
                      $empDiv="display:block";
                    }
                  @endphp
                 <div class="col-md-6 empDiv" style="{{$empDiv}}">
                   <div class="form-group">
                      {{ Form::label('Employee','Employee') }}
                      {{ Form::select('employee',$employees,$data->pay_for_employee_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose employee','id'=>'srchEmp']) }}
                      <span class="text-danger">{{ $errors->first('employee')}}</span>
                    </div>
                  </div>
                  @if(old('employee'))
                    @php $ordCode=\App\Employee::where('id',old('employee'))->where(['role_id' => 4])->orWhere(['role_id' => 5])->first()->employee_code;
                    $bnkAccounts=\App\EmployeeBankAccount::where('employees_id',old('employee'))->pluck('bank_account_number','bank_account_number');
                     @endphp
                  @else
                    @php $ordCode=\App\Employee::where('id',$data->pay_for_employee_id)->where(['role_id' => 4])->orWhere(['role_id' => 5])->first()->employee_code;
                    $bnkAccounts=\App\EmployeeBankAccount::where('employees_id',$data->pay_for_employee_id)->pluck('bank_account_number','bank_account_number');
                     @endphp
                  @endif
                  <div class="col-md-6" id="bank_account_holder">
                    {{ Form::label('Bank Accounts','Bank Accounts')}}
                    {{ Form::select('bank_account_number',$bnkAccounts,$data->bank_account_number,['class'=>'form-control custom-select select2','placeholder'=>'Choose Account','required'=>true]) }}
                    <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
                  </div>
                  <div class="col-md-6" style="">
                   <div class="form-group">
                      {{ Form::label('Employee Code','Employee Code') }}
                      {{ Form::text('employee_code',$ordCode,['class'=>'form-control','readonly'=>'true','id'=>'employee_code']) }}
                      <span class="text-danger">{{ $errors->first('employee_code')}}</span>
                    </div>
                  </div>
                   <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('address','Address') }}
                        {{ Form::text('address',$data->address,['class'=>'form-control','placeholder'=>'Address','id'=>'employee_address']) }}
                        <span class="text-danger">{{ $errors->first('address')}}</span>
                      </div>
                    </div>

                  {{--  <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('bank_account_number','Bank Account Number') }}
                        {{ Form::text('bank_account_number',$data->bank_account_number,['class'=>'form-control','placeholder'=>'Bank name','id'=>'employee_bank_account']) }}
                        <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('ifsc','IFSC Code') }}
                        {{ Form::text('ifsc',$data->ifsc,['class'=>'form-control','placeholder'=>'IFSC Code','id'=>'employee_ifsc']) }}
                        <span class="text-danger">{{ $errors->first('ifsc')}}</span>
                      </div>
                    </div>--}}

                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('pan','PAN Number') }}
                        {{ Form::text('pan',$data->pan,['class'=>'form-control','placeholder'=>'PAN number Code','id'=>'employee_pan']) }}
                        <span class="text-danger">{{ $errors->first('pan')}}</span>
                      </div>
                    </div>

                    <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Employee','Nature Of Claim') }}
                        {{ Form::select('nature_of_claim',$claimType,$data->nature_of_claim_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose Nature Of Claim','id'=>'nature_of_claim','onchange'=>"getDataRow()"]) }}
                        <span class="text-danger">{{ $errors->first('nature_of_claim')}}</span>
                      </div>
                    </div>
                      <div class="col-md-12">
                        @if(old('nature_of_claim') && old('nature_of_claim')=='3')
                            @php 
                              $nature_of_claim =old('nature_of_claim');
                              $subCatMedicle = '';
                            @endphp
                             @if($data->item_detail)
                                @php $item=json_decode($data->item_detail); @endphp
                                @forelse($item->itemDetail as $i_key => $i_val)
                                  @if($i_key==0)
                                    @php $subCatMedicle =$i_val->sub_category ?? ''; @endphp
                                  @endif
                                @empty
                                @endforelse
                              @endif 
                          @else
                          @php $nature_of_claim =$data->nature_of_claim_id;$subCatMedicle = ''; @endphp
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

                          @endif
                         @php $bankName=$bankAcc=$brchAdd=$bchCode=$bnkAccHld=$bnkIfsc=$hPan=''; @endphp

                        <div class="row" id="subCat">
                          
                            @if($nature_of_claim=='3')
                              <div class="col-md-6">
                                <div class="form-group">
                                  {{ Form::label('Employee Relief Category','Employee Relief Category')}}
                                  <select name="sub_category" class="form-control custom-select select2" id="subCatId" required="required" onchange="getDataRow()">
                                    <option value="">Choose</option>
                                      @if($nature_of_claim)
                                        @php $subMedCat =json_decode(\App\ClaimType::where('id',$nature_of_claim)->first()->category); @endphp
                                          @if(Auth::guard('employee')->user()->medical_welfare!='Yes')
                                              @php 
                                                if (($key = array_search('Medical welfare', $subMedCat)) !== false) {
                                                    unset($subMedCat[$key]);
                                                }
                                              @endphp
                                            @endif
                                          @forelse($subMedCat as $ckey => $cval)
                                            <option value="{{$cval}}" @if($subCatMedicle==$cval) selected @endif>{{$cval}}</option>
                                          @empty
                                          @endforelse
                                        @endif
                                  </select>
                                </div>
                              </div>

                              @if($subCatMedicle=='Medical welfare')
                                <div class="col-md-6 hospital_sec allSubCat">
                                  <!-- radio -->
                                  {{ Form::label('Pay to','Pay to') }}
                                  <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                      {{ Form::radio('pay_to','Pay to Hospital',(isset($item->medical->pay_to) && $item->medical->pay_to=='Pay to Hospital') ? true : false,['class'=>'pay_to_radio','id'=>'pay_to1','required'=>true]) }}
                                      {{ Form::label('pay_to1','Pay to Hospital')}}
                                    </div>
                                    <div class="icheck-primary d-inline">
                                      {{ Form::radio('pay_to','Pay to Employee',(isset($item->medical->pay_to) && $item->medical->pay_to=='Pay to Employee') ? true : false,['class'=>'pay_to_radio','id'=>'pay_to2','required'=>true]) }}
                                      {{ Form::label('pay_to2','Pay to Employee')}}
                                    </div>
                                  </div>
                                  <span class="text-danger">{{ $errors->first('pay_to')}}</span>
                                </div>

                                @if(isset($item->medical->pay_to) && $item->medical->pay_to=='Pay to Hospital')
                                  <div class="col-md-6 sub_hospital_sec allSubCat">
                                     <div class="form-group">{{ Form::label('Bank Name','Bank Name') }}
                                      {{ Form::text('hsptl_bank_name',$item->medical->bank_name ?? '',['class'=>'form-control','placeholder'=>'Bank name','required'=>true])}}</div>

                                  </div>


                                  <div class="col-md-6 sub_hospital_sec allSubCat">
                                     <div class="form-group">
                                       {{ Form::label('Bank Account Number','Bank Account Number') }}
                                       {{ Form::text('hsptl_bank_account_number',$item->medical->bank_account_number ?? '',['class'=>'form-control','placeholder'=>'Bank Account Number','required'=>true])}}
                                     </div>
                                  </div>
                                  <div class="col-md-6 sub_hospital_sec allSubCat">
                                     <div class="form-group"> 
                                      {{ Form::label('Branch Address','Branch Address') }}
                                      {{ Form::text('hsptl_branch_address',$item->medical->branch_address ?? '',['class'=>'form-control','placeholder'=>'Branch Address','required'=>true])}}
                                      </div>
                                  </div>
                                  <div class="col-md-6 sub_hospital_sec allSubCat">
                                     <div class="form-group">
                                     {{ Form::label('Hospital Name','Hospital Name') }}
                                      {{ Form::text('hsptl_name',$item->medical->hsptl_name ?? '',['class'=>'form-control','placeholder'=>'Hospital Name','required'=>true])}}
                                    </div>
                                  </div>
                                  @php $bankName=$item->medical->bank_name ?? '';
                                  $bankAcc=$item->medical->bank_account_number ?? '';
                                  $brchAdd=$item->medical->branch_address ?? '';
                                  $bchCode=$item->medical->hsptl_name ?? '';
                                  $bnkAccHld=$item->medical->bank_account_holder ?? '';
                                  $bnkIfsc=$item->medical->ifsc ?? '';
                                  $hPan=$item->medical->pan ?? ''; @endphp

                                  <div class="col-md-6 sub_hospital_sec allSubCat">
                                     <div class="form-group">
                                     {{ Form::label('Account Holder Name','Account Holder Name') }}
                                      {{ Form::text('hsptl_bank_account_holder',$item->medical->bank_account_holder ?? '',['class'=>'form-control','placeholder'=>'Account Holder Name','required'=>true])}}
                                    </div>
                                  </div>
                                  <div class="col-md-6 sub_hospital_sec allSubCat">
                                     <div class="form-group">
                                     {{ Form::label('Bank IFSC Code','Bank IFSC Code') }}
                                      {{ Form::text('hsptl_ifsc',$item->medical->ifsc ?? '',['class'=>'form-control','placeholder'=>'Bank IFSC','required'=>true])}}
                                    </div>
                                  </div>
                                  <div class="col-md-6 sub_hospital_sec allSubCat">
                                     <div class="form-group">
                                     {{ Form::label('Pan Number','Pan Number') }}
                                     {{ Form::text('hsptl_pan',$item->medical->pan ?? '',['class'=>'form-control','placeholder'=>'Bank Pan Number','required'=>true])}}
                                     </div>
                                  </div>
                                @endif
                              @endif
                            @endif
                        </div>
                      </div>
                    
                    <!--  -->
                    <div class="col-md-12 Goods" id="Goods">
                      @if($data->item_detail)
                      @php $item=json_decode($data->item_detail);
                        $claimId=$data->nature_of_claim_id;
                        if(old('nature_of_claim')){
                          $claimId=old('nature_of_claim');
                        }
                        $claim_type=\App\ClaimType::where('id',$claimId)->first();
                       @endphp
                        @if((old('nature_of_claim') && old('nature_of_claim')==3) || $data->nature_of_claim_id==3)
                          @forelse($item->itemDetail as $i_key => $i_val)
                            @if($i_key==0)
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
                                    @if($subCatMedicle!='Medical welfare')
                                      {{ Form::label('Other description','Other description') }}
                                    @elseif($subCatMedicle=='Medical welfare')
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
                                  <button type="button" class="btn btn-info" onClick="getMedicalPayHistory('{{$subCatMedicle}}')" title="Payment History"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                             </div>
                            @endif
                            @php $cls=rand(11111,99999).$i_key; @endphp
                            <div class="row newGDtrv Goods" id="removeItemRow{{$cls}}">
                              <div class="col-md-1 srDiv">
                                <p class="sr">{{++$i_key}}</p>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="{{$i_val->date}}" max="{{date('Y-m-d')}}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                 
                                  @if($subCatMedicle!='Medical welfare')
                                    {{ Form::text('category[]',$i_val->category ?? '',['class'=>'form-control','placeholder'=>'Other description','required'=>false]) }}
                                  @elseif($subCatMedicle=='Medical welfare')
                                    <select name="category[]" class="form-control custom-select select2" id="">
                                      <option value="">Choose</option>
                                        @forelse(\App\EmployeePay::medicalCategory() as $ckey => $cval)
                                          <option value="{{$cval}}" @if($cval==$i_val->category) selected @endif> {{$cval}} </option>
                                        @empty
                                        @endforelse
                                    </select>
                                  @endif
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="{{$i_val->bill_number}}">
                                  <span class="text-danger"></span>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <input class="form-control amount_trv" placeholder="Amount" id="" name="amount[]" type="number" value="{{$i_val->amount}}" onKeyUp="countVal()" min="0">
                                  <span class="text-danger"></span>
                                </div>
                              </div>
                              <div class="col-md-1 ItemRemove">
                                <div class="remRow_box">
                                  <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>
                                </div>
                              </div>
                            </div>
                          @empty
                          @endforelse
                        @elseif((old('nature_of_claim') && old('nature_of_claim')==2) || $data->nature_of_claim_id==2)
                        @forelse($item->itemDetail as $i_key => $i_val)
                            @if($i_key==0)
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
                            @php $cls=rand(11111,99999).$i_key; @endphp
                            <div class="row newGDtrv Goods" id="removeItemRow{{$cls}}">
                              <div class="col-md-1 srDiv">
                                <p class="sr">{{++$i_key}}</p>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="{{$i_val->date}}" max="{{date('Y-m-d')}}">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <input class="form-control" placeholder="Location" id="from_location" name="from_location[]" type="text" value="{{$i_val->from_location}}">
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-group">
                                  <input class="form-control" placeholder="Location" id="to_location" name="to_location[]" type="text" value="{{$i_val->to_location}}">
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-group">
                                  <input class="form-control" placeholder="Distance" id="distance0" name="distance[]" type="number" value="{{$i_val->distance}}">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <select name="category[]" class="form-control custom-select select2" id="">
                                    <option value="">Choose</option>
                                    @if($claim_type->category)
                                      @forelse(json_decode($claim_type->category) as $ckey => $cval)
                                        <option value="{{$cval}}" @if($cval==$i_val->category) selected @endif>{{$cval}}</option>
                                      @empty
                                      @endforelse
                                    @endif
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-group">
                                  <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="{{$i_val->bill_number}}">
                                  <span class="text-danger"></span>
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-group">
                                  <input class="form-control amount" placeholder="Amount" id="" name="amount[]" type="number" value="{{$i_val->amount}}" onKeyUp="countVal()" min="0">
                                  <span class="text-danger"></span>
                                </div>
                              </div>
                              <div class="col-md-1 ItemRemove">
                                <div class="remRow_box">
                                  <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>
                                </div>
                              </div>
                            </div>
                          @empty
                          @endforelse
                          @elseif((old('nature_of_claim') && old('nature_of_claim')==1) || $data->nature_of_claim_id==1)
                          @forelse($item->itemDetail as $i_key => $i_val)
                              @if($i_key==0)
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
                              @php $cls=rand(11111,99999).$i_key; @endphp
                              <div class="row newGD Goods" id="removeItemRow{{$cls}}">
                                <div class="col-md-1 srDiv">
                                  <p class="sr">{{++$i_key}}</p>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="{{$i_val->date}}" max="{{date('Y-m-d')}}">
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <input class="form-control" placeholder="Location" id="" name="location[]" type="text" value="{{$i_val->location}}">
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <select name="category[]" class="form-control custom-select select2" id="">
                                      <option value="">Choose</option>
                                      @if($claim_type->category)
                                        @forelse(json_decode($claim_type->category) as $ckey => $cval)
                                          <option value="{{$cval}}" @if($cval==$i_val->category) selected @endif>{{$cval}}</option>
                                        @empty
                                        @endforelse
                                      @endif
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-1">
                                  <div class="form-group">
                                    <input class="form-control" placeholder="Quantity" id="quantity{{$cls}}" name="quantity[]" type="number" value="{{$i_val->quantity}}" onKeyUp="countVal({{$cls}})" min="0">
                                  </div>
                                </div>
                                <div class="col-md-1">
                                  <div class="form-group">
                                    <input class="form-control" placeholder="Rate" id="rate{{$cls}}" name="rate[]" type="number" value="{{$i_val->rate}}" onKeyUp="countVal({{$cls}})" min="0">
                                  </div>
                                </div>
                                <div class="col-md-1">
                                  <div class="form-group">
                                    <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="{{$i_val->bill_number}}">
                                  </div>
                                </div>
                                <div class="col-md-1">
                                  <div class="form-group">
                                    <input class="form-control amount" placeholder="Amount" id="amount{{$cls}}" name="amount[]" type="number" value="{{$i_val->amount}}" readonly>
                                  </div>
                                </div>
                                <div class="col-md-1 ItemRemove">
                                  <div class="remRow_box">
                                    <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                          @empty
                          @endforelse
                        @endif
                      @endif
                    </div>
                    <div class="col-md-12 text-right">
                        {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus','onClick'=>'getMoreDataRow()'])) !!}
                    </div>
                    <!--  -->
                    <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Apex','Apex') }}
                        {{ Form::select('apex',$apexes,$data->apexe_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                        <span class="text-danger">{{ $errors->first('apex')}}</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('Amount Requested','Amount Requested') }}
                        {{ Form::number('amount_requested',$data->amount_requested,['class'=>'form-control','placeholder'=>'Amount Requested','id'=>'amount_requested']) }}
                        <span class="text-danger">{{ $errors->first('amount_requested')}}</span>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        {{ Form::label('Description','Short Description') }}
                        {{ Form::textarea('description',$data->description,['class'=>'form-control','placeholder'=>'Short Description','rows'=>3,'required'=>true]) }}
                        <span class="text-danger">{{ $errors->first('description')}}</span>
                      </div>
                    </div>
                <!-- /.col  -->
              </div>

                <div class="col-md-12">
                  <h3>Saved Files</h3>
                    <div class="row savedFile">
                      @forelse($data->empReqImage as $key => $val)
                      <div class="col-md-2">
                        <div class="savedimg_box">
                        {!! Html::decode(link_to('public/'.$val->emp_req_file_path,\App\Helpers\Helper::getDocType($val->emp_req_file_path,$val->emp_req_file_type),['target'=>'_blank','data-toggle'=>'tooltip','data-placement'=>'top','title'=>$val->emp_req_file_description])) !!}
                        {!! Html::decode(link_to_route('employee.empReqPendIMG','<i class="fa fa-trash-alt" aria-hidden="true"></i>',$val->id,['class'=>'btn btn-danger'])) !!}
                         </div>
                      </div>
                    @empty
                    <p><strong>Files not found.</strong></p>
                    @endforelse
                    </div>
                </div>
                <!--  -->
                 <div class="row imgSection">
                    <div class="col-md-3"  id="IMAGESEC">
                        <div class="form-group">
                          {!!Form::label('file', 'Employee Request file')!!}
                             {!!Form::file('emp_req_file[]',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                          @if($errors->has('emp_req_file'))
                              <p class="text-danger">{{$errors->first('emp_req_file')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                          {!!Form::label('description', 'Description')!!}
                             {!!Form::textarea('emp_req_file_description[]','',['class'=>'form-control','rows'=>3])!!}
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
@php $today = date('Y-m-d'); @endphp
<script type="text/javascript">
  $(document).ready(function(){
      $('#srchEmp').on('change',function(){
      var empId=$(this).val();
      if (empId!='') {
        var url="{{ route('employee.getEmpPayFullArray') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{empId:empId , _token: '{{csrf_token()}}',type:'getEmpPayFullArray'},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#employee_code').val(response.employee_code);
            $('#employee_address').val(response.address);
            $('#employee_bank_account').val(response.bank_account_number);
            $('#employee_ifsc').val(response.ifsc);
            $('#employee_pan').val(response.pan);
            //$('#preloader').hide();
          }
        });
        $.ajax({
          type:"POST",
          url:url,
          data:{empId:empId , _token: '{{csrf_token()}}',type:'getEmpAccountArray'},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#bank_account_holder').html(response);
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
        $('#employee_code').val(null);
        $('#employee_address').val(null);
        $('#employee_bank_account').val(null);
        $('#employee_ifsc').val(null);
        $('#employee_pan').val(null);
        $('#srchEmp').val("").trigger( "change" );
        $('.empDiv').show();
      }else{
        $('.empDiv').hide();
        var empId="{{Auth::guard('employee')->user()->id}}";
        var url="{{ route('employee.getEmpPayFullArray') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{empId:empId , _token: '{{csrf_token()}}',type:'getEmpPayFullArray'},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#employee_code').val(response.employee_code);
            $('#employee_address').val(response.address);
            $('#employee_bank_account').val(response.bank_account_number);
            $('#employee_ifsc').val(response.ifsc);
            $('#employee_pan').val(response.pan);
            //$('#preloader').hide();
          }
        });
        $.ajax({
          type:"POST",
          url:url,
          data:{empId:empId , _token: '{{csrf_token()}}',type:'getEmpAccountArray'},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#bank_account_holder').html(response);
            //$('#preloader').hide();
          }
        });
      }
    });


  $('.addIMg').click(function() {
    var cls = $('.IMGRow').length;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="col-md-3 IMGRow"><div class="form-group"> <label for="file">Order file</label> <input class="dropify form-control" data-default-file="" id="input-file-now-custom-1" name="emp_req_file[]" type="file" required> </div> <div class="form-group"> <label for="description">Description</label> <textarea class="form-control" rows="3" name="emp_req_file_description[]" cols="50"></textarea> </div></div>';
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

    function getDataRow() {

    var subCatId=$("#subCatId").val() ?? '';
    //alert(subCatId);

    $("#amount_requested").val(null);
    $('#Goods').empty();
    var nature_of_claim = $('#nature_of_claim').val();
    if (nature_of_claim!='' && nature_of_claim!='3') {
      $('#subCat').empty();
      var cls = $('.Goods').length;
      var headRow = $('.headRow').length;
        var url="{{ route('employee.getEmpPayItemRowByClaim') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{nature_of_claim:nature_of_claim , _token: '{{csrf_token()}}',type:'getItemRowByClaim',cls:cls,headRow:headRow,subCatId:subCatId},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#Goods').append(response);
            //$('#preloader').hide();
          }
        });
      }
      else if (nature_of_claim=='3' && subCatId=='') {
        var cls = $('.Goods').length;
        var headRow = $('.headRow').length;
          var url="{{ route('employee.getEmpPayItemRowByClaim') }}";
          $.ajax({
            type:"POST",
            url:url,
            data:{nature_of_claim:nature_of_claim , _token: '{{csrf_token()}}',type:'getItemSubCategory',cls:cls,headRow:headRow,subCatId:subCatId},
            beforeSend: function(){
             //$('#preloader').show();
            },
            success:function(response){
              $('#subCat').empty().append(response);
              //$('#preloader').hide();
            }
          });
      }else if (nature_of_claim=='3' && subCatId!='') {
        if (subCatId!='Medical welfare') {
          $('.allSubCat').remove();
        }
      //$('#subCat').empty();
      var cls = $('.Goods').length;
      var headRow = $('.headRow').length;
        var url="{{ route('employee.getEmpPayItemRowByClaim') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{nature_of_claim:nature_of_claim , _token: '{{csrf_token()}}',type:'getItemRowByClaim',cls:cls,headRow:headRow,subCatId:subCatId},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#Goods').append(response);
            //$('#preloader').hide();
          }
        });
      }
      else{
        $('#subCat').empty();
        $('#Goods').empty();
      }
  }
  function getMoreDataRow() {
    var subCatId=$("#subCatId").val() ?? '';
    var nature_of_claim = $('#nature_of_claim').val();
    if (nature_of_claim!='' && nature_of_claim!='3') {
      var cls = $('.Goods').length;
      var headRow = $('.headRow').length;
        var url="{{ route('employee.getEmpPayItemRowByClaim') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{nature_of_claim:nature_of_claim , _token: '{{csrf_token()}}',type:'getItemRowByClaim',cls:cls,headRow:headRow,subCatId:subCatId},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#Goods').append(response);
            //$('#preloader').hide();
          }
        });
      }else if (nature_of_claim!='' && nature_of_claim=='3' && subCatId!='') {
      var cls = $('.Goods').length;
      var headRow = $('.headRow').length;
        var url="{{ route('employee.getEmpPayItemRowByClaim') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{nature_of_claim:nature_of_claim , _token: '{{csrf_token()}}',type:'getItemRowByClaim',cls:cls,headRow:headRow,subCatId:subCatId},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            $('#Goods').append(response);
            //$('#preloader').hide();
          }
        });
      }else{
        alert('Choose claim type or category');
        return false;
      }
  }

  function countVal(argument=null) {
      var total =$('#quantity'+argument).val()*$('#rate'+argument).val();
      var sum = 0;
      $("#amount"+argument).val(total);
      var sum = 0;
      $("input[class *= 'amount']").each(function(){
          sum += +$(this).val();
      });
      $("#amount_requested").val(sum);
    }
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
<script type="text/javascript">
  $('.pay_to_radio').click(function(){
    var v=$(this).val();
    if (v=='Pay to Hospital') {
      $('.sub_hospital_sec').remove();
      $('.hospital_sec').after('<div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Bank Name">Bank Name</label> <input class="form-control" placeholder="Bank name" name="hsptl_bank_name" type="text" value="{{$bankName}}" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Bank Account Number">Bank Account Number</label> <input class="form-control" placeholder="Bank Account Number" name="hsptl_bank_account_number" type="text" value="{{$bankAcc}}" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Branch Address">Branch Address</label> <input class="form-control" placeholder="Branch Address" name="hsptl_branch_address" type="text" value="{{$brchAdd}}" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Branch Code">Hospital Name</label> <input class="form-control" placeholder="Hospital Name" name="hsptl_name" type="text" value="{{$bchCode}}" required> </div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Account Holder Name">Account Holder Name</label> <input class="form-control" placeholder="Account Holder Name" name="hsptl_bank_account_holder" type="text" value="{{$bnkAccHld}}" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Bank IFSC">Bank IFSC Code</label> <input class="form-control" placeholder="Bank IFSC" name="hsptl_ifsc" type="text" value="{{$bnkIfsc}}" required></div></div><div class="col-md-6 sub_hospital_sec"> <div class="form-group"> <label for="Pan Number">Pan Number</label> <input class="form-control" placeholder="Pan" name="hsptl_pan" type="text" value="{{$hPan}}"></div></div>');
    }else{
      $('.sub_hospital_sec').remove();
    }
  });

  function getMedicalPayHistory(argument) {
    var url="{{ route('employee.getMedicalEmpPayHistory') }}";
    var emp_type = $("input[type=radio][name=pay_for]:checked").val();
    var emp_id='';
        if (emp_type=='self') {
            var emp_id="{{Auth::guard('employee')->user()->id}}";
        }
        else if (emp_type=='other') {
            var emp_id=$('#srchEmp').val() ?? '';
            if (emp_id=='') {
              alert('Employee not selected');
              return false;
            }
        }else{
          alert('Employee not selected');
          return false;
        }
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
</script>
 @endsection