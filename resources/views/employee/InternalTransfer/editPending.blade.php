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
            {{ Form::open(['route'=>['employee.InternalTransferUpdate',$data->order_id,$page],'files'=>true])}}


                     @php 
                       $self=($data->nature_of_request=='State requesting funds') ? true : false;
                       $odr=($data->nature_of_request=='Inter bank transfer') ? true : false;
                     @endphp
                 <div class="row">
                    <div class="col-sm-6">
                      <!-- radio -->
                      {{ Form::label('Nature Of Request','Nature Of Request') }}
                      <div class="form-group clearfix">
                       
                        <div class="icheck-primary d-inline">
                          {{ Form::radio('pay_for','State requesting funds',$self,['class'=>'radio','id'=>'d1']) }}
                          {{ Form::label('d1','State requesting funds')}}
                        </div>
                        <div class="icheck-primary d-inline">
                          {{ Form::radio('pay_for','Inter bank transfer',$odr,['class'=>'radio','id'=>'d2']) }}
                          {{ Form::label('d2','Inter bank transfer')}}
                        </div>
                       
                      </div>
                       <span class="text-danger">{{ $errors->first('pay_for')}}</span>
                    </div>
                  </div>
                    @php
                      $empDiv="display:none";
                      if((old('pay_for') && old('pay_for')=='State requesting funds') || $data->nature_of_request=='State requesting funds'){
                        $empDiv="display:block";
                      }
                    @endphp
                    <div class="col-md-12 stateDiv" style="{{$empDiv}}">
                      <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Apex','Apex') }}
                          {{ Form::select('state',$apexs,json_decode($data->apex_ary)->id ?? '',['class'=>'form-control custom-select select2','placeholder'=>'Choose State','id'=>'state']) }}
                          <span class="text-danger">{{ $errors->first('state')}}</span>
                        </div>
                      </div>
                    
                      @php 
                        $bnkAry=\App\BankAccount::where('apexe_id',json_decode($data->apex_ary)->id ?? '')->pluck('bank_account_number','id');
                        if(old('state')){
                          $bnkAry=\App\BankAccount::where('apexe_id',old('state'))->pluck('bank_account_number','id');
                        }
                      @endphp
                      <div class="col-md-6" id="bankAccount">
                        <div class="form-group">
                          {{ Form::label('Bank Account','Bank Account') }}
                          {{ Form::select('state_bank_id',$bnkAry,json_decode($data->state_bank_ary)->id ?? '',['class'=>'form-control srchBank','placeholder'=>'Choose Bank Account','id'=>'state_bankAccount']) }}
                          <span class="text-danger">{{ $errors->first('state_bank_id') }}</span>
                        </div>
                      </div> 

                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('IFSC','IFSC') }}
                          {{ Form::text('ifsc',json_decode($data->state_bank_ary)->ifsc ?? '',['class'=>'form-control','placeholder'=>'IFSC','id'=>'ifsc']) }}
                          <span class="text-danger">{{ $errors->first('ifsc')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('project_name','Project Name') }}
                          {{ Form::text('project_name',$data->project_name,['class'=>'form-control','placeholder'=>'Project Name','id'=>'project_name']) }}
                          <span class="text-danger">{{ $errors->first('project_name')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('project_id','Project Id') }}
                          {{ Form::text('project_id',$data->project_id,['class'=>'form-control','placeholder'=>'Project Id','id'=>'project_id']) }}
                          <span class="text-danger">{{ $errors->first('project_id')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('reason','Reason') }}
                          {{ Form::text('reason',$data->reason,['class'=>'form-control','placeholder'=>'Reason','id'=>'reason']) }}
                          <span class="text-danger">{{ $errors->first('reason')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('cost_center','Cost Center') }}
                          {{-- Form::text('cost_center',$data->cost_center,['class'=>'form-control','placeholder'=>'Cost Center','id'=>'cost_center']) --}}
                          {{--Helper::costCenter($data->cost_center)--}}
                          {{ Form::select('cost_center',\App\CostCenter::pluck('name','name'),$data->cost_center,['class'=>'form-control custom-select select2','placeholder'=>'Select Cost Center','required'=>'true']) }} 
                          <span class="text-danger">{{ $errors->first('cost_center')}}</span>
                        </div>
                      </div>
                      </div>
                    </div>
                    @php
                      $bnkDiv="display:none";
                      if((old('pay_for') && old('pay_for')=='Inter bank transfer') || $data->nature_of_request=='Inter bank transfer'){
                        $bnkDiv="display:block";
                      }
                    @endphp
                    <div class="col-md-12 bnkDiv" style="{{$bnkDiv}}">
                      <div class="row">
                         <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('Apex','Apex') }}
                              {{ Form::select('apex',$apexs,$data->apexe_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('apex')}}</span>
                            </div>
                          </div>
                      
                        <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Bank From','Transfer From') }}
                          {{ Form::select('transfer_from',$bankAccount,json_decode($data->transfer_from_ary)->id ?? '',['class'=>'form-control srchBank','placeholder'=>'Transfer From','id'=>'transfer_from']) }}
                          <span class="text-danger">{{ $errors->first('transfer_from')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Transfer From IFSC','Transfer From IFSC') }}
                          {{ Form::text('transfer_from_ifsc',json_decode($data->transfer_from_ary)->ifsc ?? '',['class'=>'form-control','placeholder'=>'Transfer From IFSC','id'=>'transfer_from_ifsc']) }}
                          <span class="text-danger">{{ $errors->first('transfer_from_ifsc')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Transfer From Account','Transfer From Account') }}
                          {{ Form::text('transfer_from_account',json_decode($data->transfer_from_ary)->bank_account_number ?? '',['class'=>'form-control','placeholder'=>'Transfer From Account','id'=>'transfer_from_account']) }}
                          <span class="text-danger">{{ $errors->first('transfer_from_account')}}</span>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Transfer To','Transfer To') }}
                          {{ Form::select('transfer_to',$bankAccount,json_decode($data->transfer_to_ary)->id ?? '',['class'=>'form-control srchBank','placeholder'=>'Transfer To','id'=>'transfer_to']) }}
                          <span class="text-danger">{{ $errors->first('transfer_to')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Transfer To IFSC','Transfer To IFSC') }}
                          {{ Form::text('transfer_to_ifsc',json_decode($data->transfer_to_ary)->ifsc ?? '',['class'=>'form-control','placeholder'=>'Transfer From IFSC','id'=>'transfer_to_ifsc']) }}
                          <span class="text-danger">{{ $errors->first('transfer_to_ifsc')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Transfer To Account','Transfer To Account') }}
                          {{ Form::text('transfer_to_account',json_decode($data->transfer_to_ary)->bank_account_number ?? '',['class'=>'form-control','placeholder'=>'Transfer From Account','id'=>'transfer_to_account']) }}
                          <span class="text-danger">{{ $errors->first('transfer_to_account')}}</span>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('amount','Amount') }}
                          {{ Form::number('amount',$data->amount,['class'=>'form-control','placeholder'=>'Amount','id'=>'amount']) }}
                          <span class="text-danger">{{ $errors->first('amount')}}</span>
                        </div>
                    </div>
                   
                  <!-- /.col  -->

                <div class="col-md-12">
                  <h3>Saved Files</h3>
                    <div class="row savedFile">
                      @forelse($data->internalTransferImage as $key => $val)
                      <div class="col-md-2">
                        <div class="savedimg_box">
                        {!! Html::decode(link_to('public/'.$val->internal_transfer_file_path,\App\Helpers\Helper::getDocType($val->internal_transfer_file_path,$val->internal_transfer_file_type),['target'=>'_blank','data-toggle'=>'tooltip','data-placement'=>'top','title'=>$val->internal_transfer_file_description])) !!}
                        {!! Html::decode(link_to_route('employee.InternalTransferPendIMG','<i class="fa fa-trash-alt" aria-hidden="true"></i>',$val->id,['class'=>'btn btn-danger'])) !!}
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

@endsection

@section('footer')
@php $today = date('Y-m-d'); @endphp
<script type="text/javascript">
  $(document).ready(function(){
      $('.srchBank').on('change',function(){
      var bnkId=$(this).val();
      var id=$(this).attr('id');
      //alert(bnkId);
      if (bnkId!='') {
        var url="{{ route('employee.getInternalTransBankAccountArray') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{bnkId:bnkId , _token: '{{csrf_token()}}',type:'getBankAccountArray'},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            if(id=='state_bankAccount'){
                $('#ifsc').val(response.ifsc);
            }
            if (id=='transfer_from') {
              $('#transfer_from_ifsc').val(response.ifsc);
              $('#transfer_from_account').val(response.bank_account_number);
            }
            if (id=='transfer_to') {
              $('#transfer_to_ifsc').val(response.ifsc);
              $('#transfer_to_account').val(response.bank_account_number);
            }
             
            // $('#employee_address').val(response.address);
            // $('#employee_bank_account').val(response.bank_account_number);
            // $('#employee_ifsc').val(response.ifsc);
            // $('#employee_pan').val(response.pan);
            //$('#preloader').hide();
          }
        });
      }else{
        if(id=='state_bankAccount'){
            $('#ifsc').val(null);
        }
        if (id=='transfer_from') {
              $('#transfer_from_ifsc').val(null);
              $('#transfer_from_account').val(null);
            }
            if (id=='transfer_to') {
              $('#transfer_to_ifsc').val(null);
              $('#transfer_to_account').val(null);
            }
       
      }
    });
  });
</script>
<script type="text/javascript">
  $('.radio').click(function(){
    if($(this).val()=='State requesting funds'){
      //$('#srchEmp').val("").trigger( "change" );
      $('.bnkDiv').hide();
      $('.stateDiv').show();
    }else{
      $('.stateDiv').hide();
      $('.bnkDiv').show();
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

</script>
<script>
  $('#state').change(function(){
    var id=$(this).val();
    if (id) {
        var url="{{ route('employee.getInternalTrnsDetail') }}";
          $.ajax({
            type:"POST",
            url:url,
            data:{slug:id , _token: '{{csrf_token()}}',type:'getBankByState'},
            beforeSend: function(){
            // $('#preloader').show();
            },
            success:function(response){
              if (response) {
                  $('#bankAccount').html(response);
                  //$('#modal-default').modal('show');
              }
             // $('#preloader').hide();
            }
          });
    }else{
      $('#bankAccount').html(null);
    }
  });
  /*function getInternalTrnsDetail(id) {
  if (id) {
      var url="{{ route('employee.getInternalTrnsDetail') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{slug:id , _token: '{{csrf_token()}}',type:'getBankByState'},
          beforeSend: function(){
          // $('#preloader').show();
          },
          success:function(response){
            if (response) {
                $('#modal-body').html(response);
                $('#modal-default').modal('show');
            }
           // $('#preloader').hide();
          }
        });
  }
}*/

  </script>
 @endsection