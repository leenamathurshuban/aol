@extends('layouts.admin')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vendors Request : {{ $total }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item active">Vendor Request</li>
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
        					<div class="col-sm-12 col-md-12 mt-2">
                    {!! Form::open(['method'=>'GET','files'=>true])!!}
                       <div class="row yemm_serachbox">
                       
                        <div class="col-sm-12 col-md-10">
                          {{ Form::text('name',$name,['class'=>'form-control','placeholder'=>'Search by vendor name']) }}
                        </div>
                        <div class="col-sm-12 col-md-2 text-right">
                          {{ Form::submit('Search',['class'=>'btn btn-dark w-100']) }}
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
                      {{$result->email}}
                    </td>
                    <td>
                      {!!Form::open(['route'=>['admin.changeVendorStatus',$result->id],'file'=>'true'])!!}
                              {!! Form::select('status',['1'=>'Pending','2'=>'Approved'],[$result->status],['class'=>'form-control custom-select select2','onchange'=>'this.form.submit()','style'=>'width:100%'])!!}             
                         <span class="text-danger">{{ $errors->first('status')}}</span>               
                      {!!Form::close()!!}
                    </td>
                    <td>
                      <button class="btn btn-app btn-view" title="View" onclick="getVendorDetail('{{ $result->id }}')"><i class="fas fa-eye"></i>View</button>

                    	{!! Html::decode(link_to_route('admin.editVendorRequest','<i class="fas fa-edit"></i>Edit',[$result->id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit'])) !!}

                    	{!! Html::decode(link_to_route('admin.removeVendorRequest','<i class="fas fa-trash"></i>Delete',[$result->id],['class'=>'btn btn-app btn-delete','title'=>'Remove','onclick'=>'return removeData()'])) !!}
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
          <div class="modal-body" id="modal-body">
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
      function getVendorDetail(id) {
      if (id) {
          var url="{{ route('admin.getVendorRequestDetail') }}";
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