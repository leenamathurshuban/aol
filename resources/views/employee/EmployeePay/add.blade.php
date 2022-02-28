@extends('layouts.employee')

@section('header') @endsection
 
@section('body') 
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Form</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
          	{{link_to_route('employee.home','Home',[],[])}}
          </li>
          <li class="breadcrumb-item">
            {{link_to_route('employee.pendingEmpPay','Pending Request',[],[])}}
          </li>
          <li class="breadcrumb-item active">Add</li>
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
        <h3 class="card-title">Add Form</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">

        {{ Form::open(['route'=>['employee.EmployeePayFormSave'],'files'=>true])}}
          <div class="row">
              <div class="col-sm-6">
                <!-- radio -->
                {{ Form::label('Employee Form For','Employee Form For') }}
                <div class="form-group clearfix">
                 
                  <div class="icheck-primary d-inline">
                    {{ Form::radio('pay_for','self','',['class'=>'radio','id'=>'radioPrimary1']) }}
                    {{ Form::label('radioPrimary1','Self')}}
                  </div>
                  <div class="icheck-primary d-inline">
                    {{ Form::radio('pay_for','other','',['class'=>'radio','id'=>'radioPrimary2']) }}
                    {{ Form::label('radioPrimary2','Other Employee')}}
                  </div>
                </div>
                 <span class="text-danger">{{ $errors->first('pay_for')}}</span>
              </div>
              @php
                $empDiv="display:none";
                $bnkAccounts=[];
                if(old('pay_for') && old('pay_for')=='other'){
                  $empDiv="display:block";
                  $bnkAccounts=\App\EmployeeBankAccount::where('employees_id',old('employee'))->pluck('bank_account_number','bank_account_number');
                }
                if(old('pay_for') && old('pay_for')=='self'){
                  $bnkAccounts=\App\EmployeeBankAccount::where('employees_id',Auth::guard('employee')->user()->id)->pluck('bank_account_number','bank_account_number');
                }
              @endphp
             <div class="col-md-6 empDiv" style="{{$empDiv}}">
               <div class="form-group">
                  {{ Form::label('Employee','Employee') }}
                  {{ Form::select('employee',$employees,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose employee','id'=>'srchEmp']) }}
                  <span class="text-danger">{{ $errors->first('employee')}}</span>
                </div>
              </div>
              <div class="col-md-6" id="bank_account_holder">
                {{ Form::label('Bank Accounts','Bank Accounts')}}
                {{ Form::select('bank_account_number',$bnkAccounts,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Account','required'=>true]) }}
                <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
              </div>
              <div class="col-md-6" style="">
               <div class="form-group">
                  {{ Form::label('Employee Code','Employee Code') }}
                  {{ Form::text('employee_code','',['class'=>'form-control','readonly'=>'true','id'=>'employee_code']) }}
                  <span class="text-danger">{{ $errors->first('employee_code')}}</span>
                </div>
              </div>
               <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('address','Address') }}
                    {{ Form::text('address','',['class'=>'form-control','placeholder'=>'Address','id'=>'employee_address']) }}
                    <span class="text-danger">{{ $errors->first('address')}}</span>
                  </div>
                </div>

                {{--<div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('bank_account_number','Bank Account Number') }}
                    {{ Form::text('bank_account_number','',['class'=>'form-control','placeholder'=>'Bank name','id'=>'employee_bank_account']) }}
                    <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
                  </div>
                </div>--}}

              {{--  <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('ifsc','IFSC Code') }}
                    {{ Form::text('ifsc','',['class'=>'form-control','placeholder'=>'IFSC Code','id'=>'employee_ifsc']) }}
                    <span class="text-danger">{{ $errors->first('ifsc')}}</span>
                  </div>
                </div>--}}

                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('pan','PAN Number') }}
                    {{ Form::text('pan','',['class'=>'form-control','placeholder'=>'PAN number Code','id'=>'employee_pan']) }}
                    <span class="text-danger">{{ $errors->first('pan')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Employee','Nature Of Claim') }}
                    {{ Form::select('nature_of_claim',$claimType,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Nature Of Claim','id'=>'nature_of_claim','onchange'=>"getDataRow()"]) }}
                    <span class="text-danger">{{ $errors->first('nature_of_claim')}}</span>
                  </div>
                </div>
                 @php
                  $trv="display:none";
                  $othr="display:none";
                  if(old('nature_of_claim') && old('nature_of_claim')=='2'){
                    $trv="display:block";
                  }
                  if(old('nature_of_claim') && old('nature_of_claim')=='1'){
                    $othr="display:block";
                  }
                @endphp
                <!--  -->
                <div class="col-md-12">
                  <div class="row" id="subCat">
                    @if(old('nature_of_claim') && old('nature_of_claim')=='3')
                      <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('Employee Relief Category','Employee Relief Category')}}
                          <select name="sub_category" class="form-control custom-select select2" id="subCatId" required="required" onchange="getDataRow()">
                            <option value="">Choose</option>
                              @forelse(json_decode(\App\ClaimType::where('id',old('nature_of_claim'))->first()->category) as $ckey => $cval)
                                <option value="{{$cval}}">{{$cval}}</option>
                              @empty
                              @endforelse
                          </select>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              <div class="col-md-12 Goods" id="Goods">
              </div>
              <div class="col-md-12 text-right">
                  {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus','onClick'=>'getMoreDataRow()'])) !!}
                </div>
                <!--  -->
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Apex','Apex') }}
                    {{ Form::select('apex',$apexes,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                    <span class="text-danger">{{ $errors->first('apex')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('Amount Requested','Amount Requested') }}
                    {{ Form::number('amount_requested','',['class'=>'form-control','placeholder'=>'Amount Requested','id'=>'amount_requested','readonly'=>true]) }}
                    <span class="text-danger">{{ $errors->first('amount_requested')}}</span>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('Description','Short Description') }}
                    {{ Form::textarea('description','',['class'=>'form-control','placeholder'=>'Short Description','rows'=>3,'required'=>true]) }}
                    <span class="text-danger">{{ $errors->first('description')}}</span>
                  </div>
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
            {!! Form::submit('Save',['class'=>'btn btn-outline-primary']) !!}
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

  function countVal(argument) {
      var total =$('#quantity'+argument).val()*$('#rate'+argument).val();
      var sum = 0;
      $("#amount"+argument).val(total);
      var sum = 0;
      $("input[class *= 'amount']").each(function(){
          sum += +$(this).val();
      });
      $("#amount_requested").val(sum);
      }

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