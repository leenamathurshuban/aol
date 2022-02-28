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
                {{link_to_route('employee.pendingBulkUpload','Pending Request',[],[])}}
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
            {{ Form::open(['route'=>['employee.BulkUploadApprove',$data->order_id,$page],'files'=>true])}}
              <div class="row">
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
                      <strong>Request Status:</strong><p>{{ \App\EmployeePay::requestStatus($data->status)}}</p>
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
                  </ul>
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
                @if(Auth::guard('employee')->user()->role_id==9)
                  <div class="col-md-6">
                   <div class="form-group">
                      {{ Form::label('specified_person','Specified Person') }}
                      {{ Form::select('specified_person',['Yes'=>'Yes','No'=>'No'],$data->specified_person,['class'=>'form-control custom-select select2','placeholder'=>'Specified person']) }}
                      <span class="text-danger">{{ $errors->first('specified_person')}}</span>
                    </div>
                  </div>
                @endif 
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
                           {{-- Form::text('bank_account['.$data->id.']',$bnkitem->bank_account ?? '',['class'=>'form-control','placeholder'=>'Bank Account','id'=>'']) --}}

                           {{ Form::select('bank_account['.$data->id.']',\App\BankAccount::bnkHeadOfcPluck(),$bnkitem->bank_account ?? '',['class'=>'form-control custom-select select2','placeholder'=>'Bank Account','id'=>'bank_account_data']) }}
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
                                        {{Helper::debitAccount($itemVal->debit_account)}}
                                        <span class="text-danger">{{ $errors->first('debit_account.*')}}</span>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                   <div class="form-group">
                                       
                                        {{ Form::number('amount[]',$itemVal->amount,['class'=>'form-control','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
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
                                      {{ Helper::category($itemVal->category) }}
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
                                        {{ Form::number('amount[]','',['class'=>'form-control','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
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
                                      <td>{{$itemVal->debit_account}}</td>
                                      <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->amount}}</td>
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
            <!-- /.row -->
              <div class="card-footer">
                {!! Form::submit('Save',['class'=>'btn btn-outline-primary']) !!}
              </div>
           {{ Form::close() }}
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
@endsection

@section('footer')
@php 
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
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-3"> <div class="form-group">{{$debitAccount}}<span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group"> <input class="form-control" placeholder="Amount" required="" id="" name="amount[]" type="number" value=""> <span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group">{{$costCenter}}<span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group">{{$category}}<span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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

  function countVal(argument) {
    var total =$('#quantity'+argument).val()*$('#rate'+argument).val();
    var tx = (total*$('#tax'+argument).val())/100;
    $('#tax_value'+argument).val(tx);
    $('#total'+argument).val(total+tx);
    
    var sum = 0;
    $("input[class *= 'total']").each(function(){
        sum += +$(this).val();
    });
    var discount = $('#discount').val();
    $(".net_payable").val(sum-discount);
  }
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
</script>
@endsection
