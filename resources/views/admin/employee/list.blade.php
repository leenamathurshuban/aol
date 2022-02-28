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
                {{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item active">Employee</li>
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
                    {{ link_to_route('admin.addEmployees','Add',[],['class'=>'btn btn-outline-primary','title'=>'Add New']) }} 
                  </div>--}}
                 
                  <div class="col-sm-12 col-md-12">
                    {!! Form::open(['method'=>'GET','files'=>true])!!}
                       <div class="row yemm_serachbox">
                        <div class="col-sm-12 col-md-3">
                          {{ Form::select('role',$roles,$role,['class'=>'form-control custom-select select2','placeholder'=>'All role']) }}
                        </div>
                        <div class="col-sm-12 col-md-9 main_serach">
                          <div class="form-group">
                               {{ Form::text('name',$name,['class'=>'form-control','placeholder'=>'Search by employee name/emp code']) }}
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
                    <th>Role</th>
                    <th>Emp code</th>
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
                      {{ json_decode($result->role_ary)->name ?? '' }}
                    </td>
                    <td>
                      {{$result->employee_code}}
                    </td>
                    
                   
                    <td>
                    
                      {!!Form::open(['route'=>['admin.changeEmployeesStatus',$result->employee_code],'file'=>'true'])!!}
                              {!! Form::select('status',['1'=>'Active','2'=>'Inactive'],[$result->status],['class'=>'form-control custom-select select2','onchange'=>'this.form.submit()','style'=>'width:100%'])!!}             
                         <span class="text-danger">{{ $errors->first('status')}}</span>               
                      {!!Form::close()!!}
                    </td>
                    
                    <td>
                      {{--!! Html::decode(link_to_route('admin.viewChargingStation','<i class="fas fa-eye"></i>',[$result->employee_code],['class'=>'btn btn-app','title'=>'View'])) !!--}}
                      <button class="btn btn-app btn-view" title="View" onclick="getEmployeesDetail('{{ $result->employee_code }}')"><i class="fas fa-eye"></i>View</button>

                      {!! Html::decode(link_to_route('admin.editEmployees','<i class="fas fa-edit"></i>Edit',[$result->employee_code,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit'])) !!}

                      {!! Html::decode(link_to_route('admin.removeEmployees','<i class="fas fa-trash"></i>Delete',[$result->employee_code],['class'=>'btn btn-app btn-delete','title'=>'Remove','onclick'=>'return removeData()'])) !!}
                    
                    </td>
                  </tr>
                 @empty
                 <tr>
                    
                    <td colspan="6" class="text-center">Data Not Available</td>
                    
                    
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
      function getEmployeesDetail(id) {
      if (id) {
          var url="{{ route('admin.getEmployees') }}";
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