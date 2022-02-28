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
              <li class="breadcrumb-item active">Invoices</li>
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
                {{--  @if(Auth::guard('employee')->user()->role_id==4)
                  <div class="col-sm-12 col-md-1">
                    {{ link_to_route('employee.addInvoice','Add',[],['class'=>'btn btn-block btn-outline-primary','title'=>'Add New']) }}
                  </div>
                  @endif --}}
        					<div class="col-sm-12 col-md-12">
                    {!! Form::open(['method'=>'GET','files'=>true])!!}
                       <div class="row yemm_serachbox">
                        <div class="col-sm-12 col-md-12 main_serach">
                            <div class="form-group">
                                  {{ Form::text('po_number',$po_number,['class'=>'form-control','placeholder'=>'Search by PO or Invoice number']) }}
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
                    <th>PO Unique Id</th>
                    <th>Invoice Date</th>
                    <th>Invoice Unique Id</th>
                    <th>Vendor</th>
                    <th>Vendor Code</th>
                    <th>Amount</th>
                    <th>Date Of Approval</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                @forelse($data as $result)
                  @php
                    $invc=\App\Invoice::approvedPoInvoice($result->poDetail->id); 
                  @endphp
                  <tr>
                    <td>{{ ++$page }}</td>
                    <td>
                      {{ $result->poDetail->order_id }}
                    </td>
                    <td>
                      {{ date('d/m/Y',strtotime($result->invoice_date)) }}
                    </td>
                    <td>
                      {{ $result->order_id }}
                    </td>
                    <td>
                      {{json_decode($result->vendor_ary)->name ?? ''}}
                    </td>
                    <td>
                      {{json_decode($result->vendor_ary)->vendor_code ?? ''}}
                    </td>
                   
                    <td>
                      {{ env('CURRENCY_SYMBOL') }}{{ $result->invoice_amount ?? '' }}
                    </td>
                    <td>
                      {{ ($result->date_of_payment) ? \App\Helpers\Helper::onlyDate($result->date_of_payment) : '' }}
                    </td>
                    <td>
                      {{ \App\Invoice::invoiceStatus($result->invoice_status)}}
                    </td>
                    
                    <td>
                      {!! Html::decode(link_to_route('employee.PoInvoicePDF','<i class="fas fa-file-pdf"></i>PDF',$result->poDetail->order_id,['class'=>'btn btn-app btn-pdf'])) !!}
 
                      <button class="btn btn-app btn-view" title="All PO Invoices" onclick="getInvoiceDetail('{{ $result->poDetail->order_id }}','viewDetail')"><i class="fas fa-eye"></i>PO View</button>

                      <button class="btn btn-app btn-view" title="All PO Invoices" onclick="getInvoiceDetail('{{ $result->order_id }}','InvoiceDetail')"><i class="fas fa-eye"></i>Detail</button>

                      @if(Auth::guard('employee')->user()->role_id==4)
                        @if($result->invoice_status==1 || $result->invoice_status==2)
                            @if((Auth::guard('employee')->user()->role_id==4) &&( $result->poDetail->net_payable > $invc ))

                            {!! Html::decode(link_to_route('employee.invoiceAddItemView','<i class="fas fa-list-alt"></i>Item',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Item Detail'])) !!}
                            
                              {!! Html::decode(link_to_route('employee.editPendingInvoiceEdit','<i class="fas fa-edit"></i>Edit',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Invoice'])) !!}

                              {{--!! Html::decode(link_to_route('employee.editPendingInvoice','<i class="fas fa-plus"></i>Add',[$result->poDetail->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Add Invoice'])) !!--}}
                            @endif
                              {!! Html::decode(link_to_route('employee.removeInvoice','<i class="fas fa-trash"></i>Delete',[$result->order_id],['class'=>'btn btn-app btn-delete','title'=>'Remove','onclick'=>'return removeData()'])) !!}
                          @endif
                    @elseif((Auth::guard('employee')->user()->role_id==5 && Auth::guard('employee')->user()->id==$result->employee_id) && ($result->invoice_status==2 || $result->invoice_status==3))
                          @if($result->poDetail->net_payable > $invc)

                            {!! Html::decode(link_to_route('employee.invoiceAddItemView','<i class="fas fa-list-alt"></i>Item',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Item Detail'])) !!}
                            
                              {!! Html::decode(link_to_route('employee.editPendingInvoiceEdit','<i class="fas fa-edit"></i>Edit',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Edit Invoice'])) !!}

                              {{--!! Html::decode(link_to_route('employee.editPendingInvoice','<i class="fas fa-plus"></i>Add',[$result->poDetail->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Add Invoice'])) !!--}}
                            @endif
                              {!! Html::decode(link_to_route('employee.removeInvoice','<i class="fas fa-trash"></i>Delete',[$result->order_id],['class'=>'btn btn-app btn-delete','title'=>'Remove','onclick'=>'return removeData()'])) !!}

                    @elseif(Auth::guard('employee')->user()->role_id==5 && $result->invoice_status==1)
                    {!! Html::decode(link_to_route('employee.invoiceStatusApprove','<i class="fas fa-check"></i>Approval',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Approval'])) !!}

                    @elseif(Auth::guard('employee')->user()->role_id==7 && $result->invoice_status==4)
                      {!! Html::decode(link_to_route('employee.invoiceStatusApprove','<i class="fas fa-check"></i>Approval',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Approval'])) !!}
                    @elseif(Auth::guard('employee')->user()->role_id==9 && $result->invoice_status==3)
                      {!! Html::decode(link_to_route('employee.invoiceStatusApprove','<i class="fas fa-check"></i>Approval',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Approval'])) !!}
                    @elseif(Auth::guard('employee')->user()->role_id==10 && $result->invoice_status==5)
                      {{--!! Html::decode(link_to_route('employee.invoiceStatusApprove','<i class="fas fa-check"></i>Approval',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Approval'])) !!--}}
                    @elseif(Auth::guard('employee')->user()->role_id==11 && $result->invoice_status==6)
                      {{--!! Html::decode(link_to_route('employee.invoiceStatusApprove','<i class="fas fa-check"></i>Approval',[$result->order_id,$currentPage],['class'=>'btn btn-app btn-edit','title'=>'Approval'])) !!--}}
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
  function getInvoiceDetail(id,type) {
  if (id) {
      var url="{{ route('employee.getInvoiceDetail') }}";
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