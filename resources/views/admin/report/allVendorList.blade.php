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
              {!! Form::open(['method'=>'GET','files'=>true])!!}
              <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                    {{ Form::label('From','From')}}
                    {{ Form::date('from',$from,['class'=>'form-control','placeholder'=>'From']) }}
                  </div>
                  <div class="col-md-2">
                    {{ Form::label('To','To')}}
                    {{ Form::date('to',$to,['class'=>'form-control','placeholder'=>'To']) }}
                  </div>
                  <div class="col-md-4">
                    {{ Form::label('Status','Status')}}
                    {{ Form::select('status',\App\Vendor::accountStatus(),$status,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                  </div>
                  <div class="col-sm-12 col-md-4">
                    {{ Form::label('Name/Code','Name/Code')}}
                       <div class="row yemm_serachbox">
                         <div class="col-sm-12 col-md-12 main_serach">
                            <div class="form-group">
                                 {{ Form::text('name',$name,['class'=>'form-control','placeholder'=>'Search by name/code']) }}
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
                <table id="" class="table table-bordered table-striped report_table">
                  <thead>
                  <tr>
                    <th>Sr:</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Account</th>
                    <th>Date</th>
                    <th>view</th>
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
                      {!!Form::open(['route'=>['admin.vendorReportStatusChange',$result->id],'file'=>'true'])!!}
                              {!! Form::select('status',['1'=>'Active','2'=>'Inactive'],[$result->status],['class'=>'form-control custom-select select2','onchange'=>'this.form.submit()','style'=>'width:100%'])!!}             
                         <span class="text-danger">{{ $errors->first('status')}}</span>               
                      {!!Form::close()!!}
                    </td>
                    <td>
                      {{ \App\Vendor::accountStatus($result->account_status) }}
                    </td>
                    <td>
                      {{ Helper::onlyDate($result->created_at)}}
                    </td>
                    <td>
                      <button class="btn btn-app btn-view" title="View" onclick="getVendorDetail('{{ $result->id }}')"><i class="fas fa-eye"></i>View</button>
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
          var url="{{ route('admin.getReportVendorDetail') }}";
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