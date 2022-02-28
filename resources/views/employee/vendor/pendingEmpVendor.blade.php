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
              <li class="breadcrumb-item active">Vendor</li>
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
                  {{--<div class="col-sm-12 col-md-1">
                    {{ link_to_route('employee.addVendor','Add',[],['class'=>'btn btn-block btn-outline-primary','title'=>'Add New']) }}
                  </div>--}}
        					<div class="col-sm-12 col-md-12">
                    {!! Form::open(['method'=>'GET','files'=>true])!!}
                       <div class="row yemm_serachbox">
                          <div class="col-sm-12 col-md-12 main_serach">
                              <div class="form-group">
                                    {{ Form::text('name',$name,['class'=>'form-control','placeholder'=>'Search by vendor name / code']) }}
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
                    <th>Name</th>
                    <th>Code</th>
                    <th>Email</th>
                     <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                @forelse($data as $result)
                  <tr>
                    <td>{{ ++$page }}</td>
                    <td>
                      {{$result->name}}
                    </td>
                    <td>
                      {{$result->vendor_code}}
                    </td>
                    <td>
                      {{$result->email}}
                    </td>
                    <td>
                      @if(Auth::guard('employee')->user()->role_id==8)
                      {!!Form::open(['route'=>['employee.changeVendorRequestStatus',$result->vendor_code],'file'=>'true','id'=>'venForm'.$result->id,'onsubmit'=>"return chkCMT($result->id)"])!!}
                              {!! Form::select('account_status',\App\Vendor::accountStatus(),[$result->account_status],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'status_'.$result->id])!!}             
                         <span class="text-danger" id="span{{$result->id}}"></span>
                         {{ Form::textarea('account_status_comment','',['class'=>'form-control textareaCustom','rows'=>'2','id'=>'status_cmt_'.$result->id])}}
                        <button type="submit" class="btn btn-primary">Save</button>{!!Form::close()!!}
                      @else
                        {{ \App\Vendor::accountStatus($result->account_status) }}
                        @if($result->account_status==2)
                        <a href="#" class="popoverComment" data-toggle="popover" title="Comment" data-content="{{$result->account_status_comment}}"><span>?</span></a>
                        @endif
                      @endif
                    </td> 
                    <td>
                      {!! Html::decode(link_to_route('employee.vendorPDF','<i class="fas fa-file-pdf"></i>PDF',$result->vendor_code,['class'=>'btn btn-app btn-pdf'])) !!}
                      
                      <button class="btn btn-app btn-view" title="View" onclick="getVendorDetail('{{ $result->vendor_code }}')"><i class="fas fa-eye"></i>View</button>

                    	{!! Html::decode(link_to_route('employee.editPendingVendor','<i class="fas fa-edit"></i>Edit',[$result->vendor_code,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit'])) !!}

                    	{!! Html::decode(link_to_route('employee.removeVendor','<i class="fas fa-trash"></i>Delete',[$result->vendor_code],['class'=>'btn btn-app btn-delete','title'=>'Remove','onclick'=>'return removeData()'])) !!}
                    </td>
                  </tr>
                 @empty
                 <tr>
                    <td colspan="5" class="text-center">Data Not Available</td>
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
function chkCMT(id) {
  var st=$('#status_'+id).val();
  var cmt=$('#status_cmt_'+id).val();
  if (st==2 && cmt=='') {
    $('#span'+id).text('Comment is required');
    return false;
  }
  
}
function getVendorDetail(id) {
if (id) {
  var url="{{ route('employee.getVendor') }}";
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
  </script>

@endsection