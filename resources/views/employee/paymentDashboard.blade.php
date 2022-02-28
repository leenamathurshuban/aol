@extends('layouts.employee')

@section('header')

@endsection

@section('body')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Total: {{ $total }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
         {{-- <li class="breadcrumb-item">
            {{ link_to_route('employee.home','Home',[],[]) }}
          </li>--}}
          <li class="breadcrumb-item active">{{ Auth::guard('employee')->user()->name }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
           <div class="card-header">
                {{-- link_to_route('employee.employeeAllRequestExport','WIthout PO Invoice Export','wdinv',['class'=>'btn btn-primary export-btn','title'=>'WIthout PO Invoice Export']) }}
              
                {{ link_to_route('employee.employeeAllRequestExport','PO Invoice Export','inv',['class'=>'btn btn-primary export-btn','title'=>'PO Invoice Export']) }}
              
                {{ link_to_route('employee.employeeAllRequestExport','Internal Transfer Export','bnkRtrn',['class'=>'btn btn-primary export-btn','title'=>'Internal Transfer Export']) }}
              
                
              
                {{ link_to_route('employee.employeeAllRequestExport','Emp. Pay Export','empPay',['class'=>'btn btn-primary export-btn','title'=>'Empployee Pay Export']) }}

                {{ link_to_route('employee.employeeAllRequestExport','Bulk Upload Export','bulkUp',['class'=>'btn btn-primary export-btn','title'=>'Bulk Upload Export']) --}}

                {{-- link_to_route('employee.employeeAllRequestExport','PO Export','po',['class'=>'btn btn-primary export-btn','title'=>'PO Export']) --}}
                {!! Form::open(['route'=>['employee.employeeAllRequestExport'],'method'=>'','files'=>true])!!}
                <div class="row">
                  {{--<div class="col-md-3">
                    {{ Form::label('From','From')}}
                    {{ Form::date('from','',['class'=>'form-control','placeholder'=>'From']) }}
                  </div>
                  <div class="col-md-3">
                    {{ Form::label('To','To')}}
                    {{ Form::date('to','',['class'=>'form-control','placeholder'=>'To']) }}
                  </div>--}}
                  <div class="col-md-3">
                    {{ Form::label('Request Export','Request Export')}}
                    {{ Form::select('request_type',['inv'=>'PO Invoices','wdinv'=>'Without PO Invoices','bnkRtrn'=>'Internal Transfer','empPay'=>'Employee Pay','bulkUp'=>'Bulk Upload'],'',['class'=>'form-control custom-select select2','placeholder'=>'Choose request type','required'=>true]) }}
                    <span class="text-danger">{{ $errors->first('request_type') }}</span>
                  </div>
                  <div class="col-md-3 mt-20">
                    {!! Html::decode(Form::button('<i class="fa fa-file-csv"></i>',['type' => 'submit', 'class'=>'btn btn-dark','title'=>'CSV Export'])) !!}
                  </div>
                </div>
                {{ Form::close() }}
          </div>
          
         <div class="row">
           <div class="col-md-6">
              {!! Form::open(['method'=>'GET','files'=>true])!!}
              <div class="card-header">
                <div class="row">
                  <div class="col-md-4">
                    {{ Form::label('From','From')}}
                    {{ Form::date('from',$from,['class'=>'form-control','placeholder'=>'From']) }}
                  </div>
                  <div class="col-md-4">
                    {{ Form::label('To','To')}}
                    {{ Form::date('to',$to,['class'=>'form-control','placeholder'=>'To']) }}
                  </div>
                {{--  <div class="col-md-4">
                    {{ Form::label('Request Type','Request Type')}}
                    {{ Form::select('request_type',['inv'=>'PO Invoices','wdinv'=>'Without PO Invoices','bnkRtrn'=>'Internal Transfer','empPay'=>'Employee Pay'],$request_type,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                    {{-- Form::select('request_type',['po'=>'Purchase Order','inv'=>'PO Invoices','wdinv'=>'Without PO Invoices','bnkRtrn'=>'Internal Transfer','empPay'=>'Employee Pay'],$request_type,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                  </div>--}}
                  <div class="col-sm-12 col-md-4">
                    {{ Form::label('Order Id','Order Id')}}
                       <div class="row yemm_serachbox">
                         <div class="col-sm-12 col-md-12 main_serach">
                            <div class="form-group">
                                 {{ Form::text('order_id',$order_id,['class'=>'form-control','placeholder'=>'Search by Order Id']) }}
                                 {!! Html::decode(Form::button('<i class="fa fa-search"></i>',['type' => 'submit', 'class'=>'btn btn-dark'])) !!}
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
              </div> 
              {!! Form::close() !!}
           </div>
           <div class="col-md-6">

              {!! Form::open(['route'=>['employee.paymentOfficeApproval'],'files'=>true])!!}
              <div class="card-header">
                <label>Approve Payment Import</label>
                <div class="row">
                  <div class="text text-danger col-md-12">
                      @if ($failures = Session::get('sheeterror'))
                          @foreach($failures->errors() as $failure)
                              There was an error on row {{ $failures->row() }}. {{ $failure }}
                          @endforeach
                      @endif
                  </div>
                 <div class="col-md-5">
                    {{ Form::select('type',Helper::reportType(),'',['class'=>'form-control custom-select select2','placeholder'=>'All','required'=>true]) }}
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                  </div>
                  <div class="col-sm-12 col-md-5">
                    {{ Form::file('data_request_file',['class'=>'form-control','title'=>'Import excel','required'=>true]) }} 
                    <span class="text-danger">{{ $errors->first('data_request_file') }}</span>
                  </div>
                  <div class="col-sm-12 col-md-2">
                    {{ Form::submit('Upload',['class'=>'btn btn-dark','title'=>'Upload data']) }}
                  </div>
                </div>
              </div>
              {!! Form::close() !!}
           </div>
         </div>
          
          <!-- /.card-header -->
          <div class="card-body">
            <table id="" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Sr:</th>
                <th>Unique ID</th>
                <th>Amount</th>
                <th>Type of Nature</th>
                <th>Status</th>
                <th>Date</th>
                <th>View</th>
              </tr>
              </thead>
              <tbody>
                @forelse($invoiceData as $result)
                  <tr>
                    <td>{{ ++$page }}</td>
                    <td>
                      {{--$result->invoice_number--}}
                      {{ $result->order_id }}
                    </td>
                    <td>
                      {{ env('CURRENCY_SYMBOL') }}{{ $result->tds_payable ?? '' }}
                    </td>
                    <td>
                      PO Invoices
                    </td>
                    <td>
                      {{ \App\Invoice::invoiceStatus($result->invoice_status)}}
                    </td>
                    <td>
                      {{ Helper::onlyDate($result->created_at)}}
                    </td>
                    <td>
                      <button class="btn btn-app btn-view" title="View" onclick="getAdminRequestRepDetail('{{ $result->po_id }}','inv')"><i class="fas fa-eye"></i>View</button>
                    </td>
                  </tr>
                 @empty
                @endforelse
                @forelse($withoutPOinvoiceData as $result)
                  <tr>
                    <td>{{ ++$page }}</td>
                    <td>
                      {{--$result->invoice_number--}}
                      {{ $result->order_id }}

                    </td>
                    <td>
                      {{ env('CURRENCY_SYMBOL') }}{{ $result->invoice_amount ?? '' }}
                    </td>
                    <td>
                      Without PO Invoices
                    </td>
                    <td>
                      {{ \App\Invoice::invoiceStatus($result->invoice_status)}}
                    </td>
                    <td>
                      {{ Helper::onlyDate($result->created_at)}}
                    </td>
                    <td>
                      <button class="btn btn-app btn-view" title="View" onclick="getAdminRequestRepDetail('{{ $result->order_id }}','wdinv')"><i class="fas fa-eye"></i>View</button>
                    </td>
                  </tr>
                 @empty
                @endforelse
                @forelse($poData as $result)
                  <tr>
                    <td>{{ ++$page }}</td>
                    <td>
                      {{$result->order_id}}
                    </td>
                    <td>
                      {{ env('CURRENCY_SYMBOL') }}{{ $result->net_payable ?? '' }}
                    </td>
                    <td>
                      Purchase Order
                    </td>
                    <td>
                      {{ \App\EmployeePay::requestStatus($result->account_status)}}
                    </td>
                    <td>
                      {{ Helper::onlyDate($result->created_at)}}
                    </td>
                    <td>
                      <button class="btn btn-app btn-view" title="View" onclick="getAdminRequestRepDetail('{{ $result->order_id }}','po')"><i class="fas fa-eye"></i>View</button>
                    </td>
                  </tr>
                 @empty
                @endforelse
                @forelse($bnkTransData as $result)
                  <tr>
                    <td>{{ ++$page }}</td>
                    <td>
                      {{$result->order_id}}
                    </td>
                    <td>
                      {{ env('CURRENCY_SYMBOL') }}{{ $result->amount ?? '' }}
                    </td>
                    <td>
                      Internal Transfer
                    </td>
                    <td>
                      {{ \App\InternalTransfer::requestStatus($result->status)}}
                    </td>
                    <td>
                      {{ Helper::onlyDate($result->created_at)}}
                    </td>
                    <td>
                      <button class="btn btn-app btn-view" title="View" onclick="getAdminRequestRepDetail('{{ $result->order_id }}','bnkRtrn')"><i class="fas fa-eye"></i>View</button>
                    </td>
                  </tr>
                 @empty
                @endforelse
                 @forelse($empPayData as $result)
                  <tr>
                    <td>{{ ++$page }}</td>
                    <td>
                      {{$result->order_id}}
                    </td>
                    <td>
                      {{ env('CURRENCY_SYMBOL') }}{{ $result->amount_requested ?? '' }}
                    </td>
                    <td>
                      Employee Pay
                    </td>
                    <td>
                      {{ \App\EmployeePay::requestStatus($result->status)}}
                    </td>
                    <td>
                      {{ Helper::onlyDate($result->created_at)}}
                    </td>
                    <td>
                      <button class="btn btn-app btn-view" title="View" onclick="getAdminRequestRepDetail('{{ $result->order_id }}','empPay')"><i class="fas fa-eye"></i>View</button>
                    </td>
                  </tr>
                 @empty
                @endforelse
                @forelse($bulkUpData as $result)
                      <tr>
                        <td>{{ ++$page }}</td>
                        <td>
                          {{$result->order_id}}
                        </td>
                        <td>
                          {{ env('CURRENCY_SYMBOL') }}{{ \App\BulkUpload::totCSVAmount($result->payment_type,$result->id)}}
                        </td>
                        <td>
                          Bulk Upload Data
                        </td>
                        <td>
                          {{ \App\Invoice::invoiceStatus($result->status)}}
                        </td>
                        <td>
                          {{ Helper::onlyDate($result->created_at)}}
                        </td>
                        <td>
                          <button class="btn btn-app btn-view" title="View" onclick="getAdminRequestRepDetail('{{ $result->order_id }}','bulkUp')"><i class="fas fa-eye"></i>View</button>
                        </td>
                      </tr>
                     @empty
                    @endforelse
              </tbody>
            </table>
            <div class="row">
                <div class="col-md-12 center-block">
                  @if ($invTot >= $widInvTot && $invTot >= $poTot && $invTot >= $bnkTransTot && $invTot >= $empPayTot && $invTot >= $bulkUpTot)
                     {{$invoiceData->appends($_GET)->links()}}
                  @elseif ($widInvTot >= $invTot && $widInvTot >= $poTot && $widInvTot >= $bnkTransTot && $widInvTot >= $empPayTot && $widInvTot >= $bulkUpTot)
                     {{$withoutPOinvoiceData->appends($_GET)->links()}}
                  @elseif($poTot >= $invTot && $poTot >= $widInvTot && $poTot >= $bnkTransTot && $poTot >= $empPayTot && $poTot >= $bulkUpTot)
                     {{$poData->appends($_GET)->links()}}
                  @elseif($bnkTransTot >= $invTot && $bnkTransTot >= $widInvTot && $bnkTransTot >= $poTot && $bnkTransTot >= $empPayTot && $bnkTransTot >= $bulkUpTot)
                     {{$bnkTransData->appends($_GET)->links()}}
                  @elseif($empPayTot >= $invTot && $empPayTot >= $widInvTot && $empPayTot >= $poTot && $empPayTot >= $bnkTransTot && $empPayTot >= $bulkUpTot)
                     {{$empPayData->appends($_GET)->links()}}
                  @elseif($bulkUpTot >= $invTot && $bulkUpTot >= $widInvTot && $bulkUpTot >= $poTot && $bulkUpTot >= $bnkTransTot && $bulkUpTot >= $empPayTot)
                     {{$empPayData->appends($_GET)->links()}}
                  @endif
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
  function getAdminRequestRepDetail(id,type) {
    if (id) {
        var url="{{ route('employee.getEmpRequestRepDetail') }}";
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
</script>
@endsection