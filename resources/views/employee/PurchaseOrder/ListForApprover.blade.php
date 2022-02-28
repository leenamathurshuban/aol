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
              <li class="breadcrumb-item active">Purchase Order</li>
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
                                    {{ Form::text('po_number',$po_number,['class'=>'form-control','placeholder'=>'Search by PO nomber']) }}
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
                    <th>PO No.</th>
                    <th>Nature type</th>
                    <th>Vendor</th>
                    <th>Vendor Code</th>
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
                      {{ \App\PurchaseOrder::natureOfService($result->nature_of_service) }}
                    </td>
                     <td>
                      {{ json_decode($result->vendor_ary)->name ?? '' }}
                    </td>
                    <td>
                      {{ json_decode($result->vendor_ary)->vendor_code ?? '' }}
                    </td>
                    <td>
                      {!! Html::decode(link_to_route('employee.poPDF','<i class="fas fa-file-pdf"></i>PDF',$result->order_id,['class'=>'btn btn-app btn-pdf'])) !!}
                      
                      <button class="btn btn-app btn-view" title="View" onclick="getVendorDetail('{{ $result->order_id }}')"><i class="fas fa-eye"></i>View</button>
                      {!! Html::decode(link_to_route('employee.poPDF','<i class="fas fa-print"></i>PDF',$result->order_id,['class'=>'btn btn-app btn-edit','title'=>'PDF'])) !!}
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
      function getVendorDetail(id) {
      if (id) {
          var url="{{ route('employee.getPoDetail') }}";
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