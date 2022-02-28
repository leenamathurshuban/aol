@extends('layouts.employee')

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
              <li class="breadcrumb-item active">Pending Pay Request</li>
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
                <div class="row">
        					<div class="col-sm-12 col-md-12">
                    {!! Form::open(['method'=>'GET','files'=>true])!!}
                       <div class="row yemm_serachbox">
                        <div class="col-sm-12 col-md-12 main_serach">
                            <div class="form-group">
                                 {{ Form::text('request_number',$request_number,['class'=>'form-control','placeholder'=>'Search by request number']) }}
                                 {!! Html::decode(Form::button('<i class="fa fa-search"></i>',['type' => 'submit', 'class'=>'btn btn-dark'])) !!}
                            </div>
                          </div>
                      </div>
                    {!! Form::close() !!}
                  </div>
        				</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr:</th>
                    <th>Request No.</th>
                    <th>Category</th>
                    <th>Bank Formate</th>
                    <th>Payment Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
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
                      {{ \App\BulkUpload::categoryView($result->category) ?? ''}}
                    </td>
                    <td>
                      {{ \App\BulkUpload::bankView($result->bank_formate) ?? ''}}
                    </td>
                    <td>
                      {{ \App\BulkUpload::paymentTypeView($result->payment_type) ?? ''}}
                    </td>
                    <td>
                      {{ \App\EmployeePay::requestStatus($result->status)}}
                    </td>

                    <td>
                      {{ \App\Helpers\Helper::onlyDate($result->created_at) ?? '' }}
                    </td>
                    
                    <td>
                      {!! Html::decode(link_to_route('employee.bulkUploadPDF','<i class="fas fa-file-pdf"></i>PDF',$result->order_id,['class'=>'btn btn-app btn-pdf'])) !!}
                      
                      <button class="btn btn-app btn-view" title="Bulk Invoice View" onclick="getBulkUploadDetail('{{ $result->order_id }}')"><i class="fas fa-eye"></i>View</button>
                      
                        @if(Auth::guard('employee')->user()->role_id==4)
                          @if($result->status==1 || $result->status==2)
                              
                                {{--!! Html::decode(link_to_route('employee.editPendingBulkUpload','<i class="fas fa-edit"></i>Edit',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Request'])) !!--}}
                             
                              	{!! Html::decode(link_to_route('employee.removeBulkUpload','<i class="fas fa-trash"></i>Delete',[$result->order_id],['class'=>'btn btn-app btn-delete','title'=>'Remove','onclick'=>'return removeData()'])) !!}
                       
                          @endif
                         @elseif(Auth::guard('employee')->user()->role_id==5  && $result->status==1)

                          {!! Html::decode(link_to_route('employee.statusApproveBulkUpload','<i class="fas fa-check"></i>Approve',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Request'])) !!}
                        @elseif(Auth::guard('employee')->user()->role_id==9  && $result->status==3)

                          {!! Html::decode(link_to_route('employee.statusApproveBulkUpload','<i class="fas fa-check"></i>Approve',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Request'])) !!}
                        @elseif(Auth::guard('employee')->user()->role_id==7  && $result->status==4)

                          {!! Html::decode(link_to_route('employee.statusApproveBulkUpload','<i class="fas fa-check"></i>Approve',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Request'])) !!}
                        @elseif(Auth::guard('employee')->user()->role_id==10  && $result->status==5)

                          {{--!! Html::decode(link_to_route('employee.statusApproveBulkUpload','<i class="fas fa-check"></i>Approve',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Request'])) !!--}}
                        @elseif(Auth::guard('employee')->user()->role_id==11  && $result->status==6)

                          {{--!! Html::decode(link_to_route('employee.statusApproveBulkUpload','<i class="fas fa-check"></i>Approve',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Request'])) !!--}}
 
                        @endif
                    </td>
                  </tr>
                 @empty
                 <tr>
                    <td colspan="10" class="text-center">Data Not Available</td>
                  </tr>
                @endforelse
                  </tbody>
                </table>
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
  function getBulkUploadDetail(id) {
  if (id) {
      var url="{{ route('employee.getBulkUploadDetail') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{slug:id , _token: '{{csrf_token()}}'},
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

function chkCMT(id) {
  var st=$('#status_'+id).val();
  var cmt=$('#status_cmt_'+id).val();
  if (st==2 && cmt=='') {
    $('#span'+id).text('Comment is required');
    return false;
  }
  
}
  </script>

@endsection