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
            {{ Form::open(['route'=>['employee.InternalTransferApprove',$data->order_id,$page],'files'=>true,'onSubmit'=>'return cheackAmount()'])}}
              <div class="row">
                <div class="col-md-12 vander_dataview mb-4">
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
                    <li>
                      <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
                    </li>
                    <li>
                      <strong>Transaction Date:</strong><p>{{ $data->transaction_date }}</p>
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
                 <div class="col-md-12 vander_dataview">
                   
                    
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
                 </div>
 
                    <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Approval','Approve') }}
                        {{ Form::select('status',\App\InternalTransfer::EmpPayStatusChange(),'',['class'=>'form-control custom-select select2','placeholder'=>'Give Approval','onchange'=>"chkReq()",'id'=>'status','required'=>true]) }}
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
                     @php $bnkitem=[];@endphp
                     @if($data->form_by_account)
                        @php $bnkitem=json_decode($data->form_by_account); @endphp
                      @endif
                    @if(Auth::guard('employee')->user()->role_id==9)
                     {{-- <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Bank Account','Bank Account') }}
                           {{-- Form::text('bank_account['.$data->id.']',$bnkitem->bank_account ?? '',['class'=>'form-control','placeholder'=>'Bank Account','id'=>'']) 

                           {{ Form::select('bank_account['.$data->id.']',\App\BankAccount::bnkPluck(),$bnkitem->bank_account ?? '',['class'=>'form-control custom-select select2','placeholder'=>'Bank Account','id'=>'bank_account_data']) }}
                          <span class="text-danger">{{ $errors->first('bank_account.*')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('IFSC','IFSC') }}
                          {{ Form::text('ifsc['.$data->id.']',$bnkitem->ifsc ?? '',['class'=>'form-control','placeholder'=>'IFSC','id'=>'ifsc_data']) }}
                          <span class="text-danger">{{ $errors->first('ifsc.*')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Bank Name','Bank Name') }}
                              {{ Form::text('bank_name['.$data->id.']',$bnkitem->bank_name ?? '',['class'=>'form-control','placeholder'=>'Bank Name','id'=>'bank_name_data']) }}
                              <span class="text-danger">{{ $errors->first('bank_name.*')}}</span>
                        </div>
                      </div>--}}
                    @endif
                  <!--  -->
                  
                        
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
                                        {{Helper::debitAccount($itemVal->debit_account)}}
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
                                         {{ Helper::debitAccount() }}
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
                                         {{ Helper::category() }}
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
                              {{--  <table class="table" width="100%">
                                  <tr>
                                    <td><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></td>
                                    <td><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></td>
                                    <td><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></td>
                                  </tr>
                                </table>--}}
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
                   
                    <!--  -->
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

@endsection

@section('footer')
@php 
$log_role = Auth::guard('employee')->user()->role_id;
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


     function rawRemove(a){
    $('#SavGoods'+a).remove();
    var sum = 0;
    $("input[class *= 'total']").each(function(){
        sum += +$(this).val();
    });
    var discount = $('#discount').val();
    $(".net_payable").val(sum-discount);
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
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
        var amount='{{ $data->amount }}';
        var sum = 0;
          $("input[class *= 'debit_amt']").each(function(){
              sum += +$(this).val();
          });
        if (amount==sum) {
          return true;
        }else{
          $('.subAlert').text('Request amount is ₹'+amount+'. So debit account must be equal according to invoice amount. Your current debit account amount is ₹'+sum);
          return false;
        }
    }
  }
</script>
 @endsection