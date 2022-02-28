@extends('layouts.admin')
@section('header') @endsection
 
@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Total: {{ $total }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item active">Employee Wise Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  
                  {!! Form::open(['route'=>['admin.AdminSingleRequestExport','empPay'],'method'=>'','files'=>true])!!}
                  <div class="row">
                    <div class="col-md-3">
                    {{ Form::label('Employee','Employee')}}
                    {{ Form::select('employee',$emp,[],['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                  </div>
                    <div class="col-md-3">
                      {{ Form::label('From','Request From')}}
                      {{ Form::date('from','',['class'=>'form-control','placeholder'=>'From']) }}
                    </div>
                    <div class="col-md-3">
                      {{ Form::label('To','To')}}
                      {{ Form::date('to','',['class'=>'form-control','placeholder'=>'To']) }}
                    </div>
                   
                    <div class="col-md-3 mt-20">
                      {!! Html::decode(Form::button('<i class="fa fa-file-csv"></i>',['type' => 'submit', 'class'=>'btn btn-dark','title'=>'CSV Export'])) !!}
                    </div>
                  </div>
                  {{ Form::close() }}
              </div>
            {!! Form::open(['method'=>'GET','files'=>true])!!}
              <div class="card-header">
                <div class="row">
                	<div class="col-md-2">
                		{{ Form::label('Employee','Employee')}}
                		{{ Form::select('employee',$emp,$employee,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                	</div>
                  <div class="col-md-2">
                    {{ Form::label('From',' Request Date From')}}
                    {{ Form::date('from',$from,['class'=>'form-control','placeholder'=>'From']) }}
                  </div>
                  <div class="col-md-2">
                    {{ Form::label('To','To')}}
                    {{ Form::date('to',$to,['class'=>'form-control','placeholder'=>'To']) }}
                  </div>
                {{--  <div class="col-md-2">
                    {{ Form::label('Pay For','Pay For')}}
                    {{ Form::select('pay_for',$emp,$pay_for,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                  </div>
                	<div class="col-md-2">
                		{{ Form::label('Status','Status')}}
                		{{ Form::select('status',\App\EmployeePay::requestStatus(),$status,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                	</div>--}}
        			     <div class="col-sm-12 col-md-2">
                    	{{ Form::label('Unique Id','Unique Id')}}
                    	<div class="row yemm_serachbox">
	                        <div class="col-sm-12 col-md-12 main_serach">
	                            <div class="form-group">
	                                  {{ Form::text('unique_id',$unique_id,['class'=>'form-control','placeholder'=>'Unique Id']) }}
	                                 {!! Html::decode(Form::button('<i class="fa fa-search"></i>',['type' => 'submit', 'class'=>'btn btn-dark'])) !!}
	                            </div>
	                        </div>
	                     </div>
                	</div>
        		  </div>
            </div>
            {!! Form::close() !!}
              <!-- /.card-header -->
              <div class="card-body report_main">
                <div class="wrapper1">
                    <div class="div1">
                    </div>
                </div>
                <div class="wrapper2">
                    <div class="div2">
                      <table id="" class="table table-bordered table-striped report_table">
                        <thead>
                        <tr>
                          <th>Sr:</th>
                          <th>Request Id</th>
                          <th>Request Date</th>
                          <th>Employee</th>
                          <th>Code</th>
                          <th>Employee A/c.No.</th>
                          <th>IFSC Code</th>
                          <th>Nature Of Claim</th>
                          <th>Apex</th>
                          <th>Amount</th>
                          <th>Request By (Empl.Code)</th>
                           <th>Debit Account</th>
                            <th>Amount</th>
                            <th>Cost Center</th>
                            <th>Category</th>

                        </tr>
                        </thead>
                        <tbody>
                      @forelse($data as $result)
                       
                        <tr>
                          <td>{{ ++$page }}</td>
                          <td>
                            {{ $result->order_id }}
                          </td>
                           <td>
                            {{ Helper::onlyDate($result->created_at)}}
                          </td>
                           <td>
                            {{json_decode($result->employee_ary)->name ?? ''}}
                          </td>
                           <td>{{json_decode($result->employee_ary)->employee_code ?? ''}}
                          </td>
                          <td>{{ $result->bank_account_number }}</td>
                           <td>{{ $result->ifsc }}</td>
                          <td>{{ json_decode($result->nature_of_claim_ary)->name }}</td>
                          <td>{{ json_decode($result->apexe_ary)->name ?? '' }}</td>
                          <td>{{ env('CURRENCY_SYMBOL') }}{{ $result->amount_requested }}</td>
                         
                          <td>{{json_decode($result->employee_ary)->employee_code ?? ''}}</td>
                          <td colspan="4">
                             @if($result->form_by_account)
                              @php $item=json_decode($result->form_by_account); @endphp
                                <table class="table">
                                  @forelse($item->form_by_account as $itemKey => $itemVal)
                                      <tr>
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
                       <tr>
                          <td colspan="15" class="text-center">Data Not Available</td>
                        </tr>
                      @endforelse
                        </tbody>
                      </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 center-block">
                        {{$data->appends($_GET)->links()}}
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-xl">
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
	<script>
  function getAdminRequestRepDetail(id,type) {
      if (id) {
          var url="{{ route('admin.getAdminRequestRepDetail') }}";
            $.ajax({
              type:"POST",
              url:url,
              data:{slug:id ,type:type, _token: '{{csrf_token()}}'},
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
    }
$(function(){
    $(".wrapper1").scroll(function(){
        $(".wrapper2")
            .scrollLeft($(".wrapper1").scrollLeft());
    });
    $(".wrapper2").scroll(function(){
        $(".wrapper1")
            .scrollLeft($(".wrapper2").scrollLeft());
    });
});

var wid=$('.table').width();
$('.div1,.div2').width(wid+'px');
  </script>

@endsection