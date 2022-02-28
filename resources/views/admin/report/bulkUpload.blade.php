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
              <li class="breadcrumb-item active">Bulk Upload Report</li>
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
                  
                  {!! Form::open(['route'=>['admin.AdminSingleRequestExport','bulkUp'],'method'=>'','files'=>true])!!}
                  <div class="row">
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
                {{--	<div class="col-md-2">
                		{{ Form::label('Employee','Employee')}}
                		{{ Form::select('employee',$emp,$employee,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                	</div>
                 
                	<div class="col-md-2">
                		{{ Form::label('Status','Status')}}
                		{{ Form::select('status',\App\InternalTransfer::requestStatus(),$status,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                	</div>--}}
                	
                	<div class="col-md-3">
                		{{ Form::label('From','Payment Date From')}}
                		{{ Form::date('from',$from,['class'=>'form-control','placeholder'=>'From']) }}
                	</div>
                	<div class="col-md-3">
                		{{ Form::label('To','To')}}
                		{{ Form::date('to',$to,['class'=>'form-control','placeholder'=>'To']) }}
                	</div>
        			     <div class="col-sm-12 col-md-3">
                    	{{ Form::label('Order Id','Order Id')}}
                    	<div class="row yemm_serachbox">
	                        <div class="col-sm-12 col-md-12 main_serach">
	                            <div class="form-group">
	                                  {{ Form::text('order_id',$order_id,['class'=>'form-control','placeholder'=>'Unique Id']) }}
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
                            <th>Bulk Unique Id</th>
                            <th>Payment Date</th>
                            <th>Payment Bank Account</th>
                            <th>Payment Type</th>
                            <th>Apax</th>
                          {{--  <th>Employee</th>
                            <th>Code</th>--}}
                            <th>A/C Number</th>
                            <th>IFSC</th>
                            <th>Amount</th>
                            <th>DR Amount</th>
                            <th>CR Amount</th>
                            <th>Transaction Id</th>
                             <th>Transaction Date</th>
                            <th>Request By (Emp.Code)</th>
                           {{--  <th>Status</th>
                           <th>Date</th>
                            <th>View</th>--}}
                          </tr>
                          </thead>
                          <tbody>
                        @forelse($data as $result)
                         
                          <tr>
                            <td>{{ ++$page }}</td>
                            <td>
                              {{ $result->bulkUpload->order_id }}
                            </td>
                            <td>
                              {{ ($result->bulkUpload->date_of_payment) ? Helper::onlyDate($result->bulkUpload->date_of_payment) : 'Not updated' }}
                            </td>
                            <td>
                              {{ $result->account_no }}
                            </td>
                            <td>
                              {{ \App\BulkUpload::paymentTypeView($result->bulkUpload->payment_type) ?? ''}}
                            </td>
                           <td>
                             {{ json_decode($result->bulkUpload->apexe_ary)->name ?? '' }}
                           </td>
                          {{--  <td>
                              {{json_decode($result->bulkUpload->employee_ary)->name ?? ''}}
                            </td>
                             <td>{{json_decode($result->bulkUpload->employee_ary)->employee_code ?? ''}}
                            </td>--}}
                            @php $acc=$ifsc=''; @endphp
                            @if($result->bulkUpload->form_by_account)
                               @php $item=json_decode($result->bulkUpload->form_by_account);
                                  $acc=$item->bank_account ?? '';
                                  $ifsc=$item->ifsc ?? '';
                                @endphp
                              @endif
                              <td>{{ $acc }}</td>
                              <td>{{ $ifsc }}</td>
                            <td>
                              {{ env('CURRENCY_SYMBOL') }}{{ ($result->bulkUpload->payment_type==3) ? $result->amount : 0 }}
                            </td>
                            <td>
                              {{ env('CURRENCY_SYMBOL') }}{{ ($result->bulkUpload->payment_type!=3) ? $result->dr_amount : 0 }}
                            </td>
                            <td>
                              {{ env('CURRENCY_SYMBOL') }}{{ ($result->bulkUpload->payment_type!=3) ? $result->cr_amount : 0 }}
                            </td>
                            <td>
                              {{ ($result->bulkUpload->transaction_id) ? $result->bulkUpload->transaction_id : 'Not updated' }}
                            </td>
                             <td>
                              {{ ($result->bulkUpload->transaction_date) ? Helper::onlyDate($result->bulkUpload->transaction_date) : 'Not updated' }}
                            </td>
                            <td>
                              {{--json_decode($result->employee_ary)->name ?? ''--}} {{json_decode($result->bulkUpload->employee_ary)->employee_code ?? ''}}
                            </td>
                          {{--  <td>
                              {{ \App\BulkUpload::requestStatus($result->bulkUpload->status)}}
                            </td>
                            <td>
                            	{{ Helper::onlyDate($result->bulkUpload->created_at)}}
                            </td>
                            <td>
                            	<button class="btn btn-app btn-view" title="View" onclick="getAdminRequestRepDetail('{{ $result->bulkUpload->order_id }}','bulkUp')"><i class="fas fa-eye"></i>View</button>
                            </td>--}}
                           
                          </tr>
                         @empty
                         <tr>
                            <td colspan="14" class="text-center">Data Not Available</td>
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