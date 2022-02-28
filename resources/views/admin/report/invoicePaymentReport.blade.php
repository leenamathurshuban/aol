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
              <li class="breadcrumb-item active">Invoice Payment Report</li>
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
                  
                  {!! Form::open(['route'=>['admin.adminInvoicePaymentRequestExport'],'method'=>'','files'=>true])!!}
                  <div class="row">
                    <div class="col-md-3">
                      {{ Form::label('Vendor','Vendor')}}
                      {{ Form::select('vendor',$emp,[],['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                      <span class="text-danger">{{ $errors->first('vendor') }}</span>
                    </div>
                    <div class="col-md-3">
                      {{ Form::label('From','Payment Date From')}}
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
                  <div class="col-md-3">
                    {{ Form::label('Vendor','Vendor')}}
                    {{ Form::select('employee',$emp,$employee,['class'=>'form-control custom-select select2','placeholder'=>'All']) }}
                  </div>
                  <div class="col-md-2">
                    {{ Form::label('From','Payment Date From')}}
                    {{ Form::date('from',$from,['class'=>'form-control','placeholder'=>'From']) }}
                  </div>
                  <div class="col-md-2">
                    {{ Form::label('To','To')}}
                    {{ Form::date('to',$to,['class'=>'form-control','placeholder'=>'To']) }}
                  </div>
                  
                  <div class="col-sm-12 col-md-4">
                    {{ Form::label('Order Id','Order Id')}}
                       <div class="row yemm_serachbox">
                         <div class="col-sm-12 col-md-12 main_serach">
                            <div class="form-group">
                                 {{ Form::text('order_id',$order_id,['class'=>'form-control','placeholder'=>'Search by unique Id']) }}
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
                          <th>Payment Unique ID</th>
                          <th>Inv.Type</th>
                          <th>Payment Date</th>
                          <th>Transaction Id</th>
                          <th>Request Date</th>
                          <th>Apex</th>
                          <th>Vendor</th>
                          <th>Code</th>
                          <th>Inv.No.</th>
                          <th>Inv.Date</th>
                          <th>Amount</th>
                          <th>Inv.AMT.</th>
                          <th>TDS%</th>
                          <th>TDS Amount</th>
                          <th>Net Paid Amount</th>
                          <th>Bank A/C</th>
                        </tr>
                        </thead>
                        <tbody>
                          @forelse($invoiceData as $result)
                            <tr>
                              <td>{{ ++$page }}</td>
                              <td>
                                {{$result->order_id}}
                              </td>
                               <td>
                                PO Invoices
                              </td>
                              <td>
                                {{ ($result->date_of_payment) ? Helper::onlyDate($result->date_of_payment) : 'Not Updated'}}
                              </td>
                              <td>
                                {{ $result->transaction_id }}
                              </td>
                              <td>
                                {{ Helper::onlyDate($result->created_at)}}
                              </td>
                              <td>
                                {{ json_decode($result->apexe_ary)->name ?? '' }}
                              </td>
                              <td>
                                {{json_decode($result->vendor_ary)->name ?? ''}}
                              </td>
                              <td>{{json_decode($result->vendor_ary)->vendor_code ?? ''}}
                              </td>
                              <td>
                                {{ $result->invoice_number }}
                              </td>
                              <td>
                                {{ Helper::onlyDate($result->invoice_date)}}
                              </td>
                               <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->amount ?? '00' }}
                              </td>
                              <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->invoice_amount ?? '00' }}
                              </td>
                              <td>
                                {{ $result->tds ?? '00' }}%
                              </td>
                              <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->tds_amount ?? '00' }}
                              </td>
                              <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->tds_payable ?? '' }}
                              </td>
                              <td>
                                @if($result->form_by_account)
                                  @php $item=json_decode($result->form_by_account); @endphp
                                  {{$item->bank_account ?? ''}}
                                @endif
                              </td>
                            
                            </tr>
                           @empty
                          @endforelse
                          @forelse($withoutPOinvoiceData as $result)
                            <tr>
                              <td>{{ ++$page }}</td>
                              <td>
                                {{$result->order_id}}
                              </td>
                               <td>
                                Without PO Invoices
                              </td>
                              <td>
                                {{ ($result->date_of_payment) ? Helper::onlyDate($result->date_of_payment) : 'Not Updated'}}
                              </td>
                              <td>
                                {{ $result->transaction_date }}
                              </td>
                              <td>
                                {{ Helper::onlyDate($result->created_at)}}
                              </td>
                              <td>
                                {{ json_decode($result->apexe_ary)->name ?? '' }}
                              </td>
                              <td>
                                {{json_decode($result->vendor_ary)->name ?? ''}}
                              </td>
                              <td>{{json_decode($result->vendor_ary)->vendor_code ?? ''}}
                              </td>

                              <td>
                                {{ $result->invoice_number }}
                              </td>
                              <td>
                                {{ Helper::onlyDate($result->invoice_date)}}
                              </td>
                               <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->amount ?? '00' }}
                              </td>
                              <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->invoice_amount ?? '00' }}
                              </td>
                              <td>
                                {{ $result->tds ?? '00' }}%
                              </td>
                              <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->tds_amount ?? '00' }}
                              </td>
                               <td>
                                {{ env('CURRENCY_SYMBOL') }}{{ $result->tds_payable ?? '' }}
                              </td>
                              <td>
                                @if($result->form_by_account)
                                  @php $item=json_decode($result->form_by_account); @endphp
                                  {{$item->bank_account ?? ''}}
                                @endif
                              </td>
                             
                            </tr>
                           @empty
                          @endforelse
                          @if($total < 1)
                            <tr>
                              <td colspan="17">Data not found</td>
                            </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 center-block">
                      @if ($invTot >= $widInvTot)
                         {{$invoiceData->appends($_GET)->links()}}
                      @elseif ($widInvTot >= $invTot)
                         {{$withoutPOinvoiceData->appends($_GET)->links()}}
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