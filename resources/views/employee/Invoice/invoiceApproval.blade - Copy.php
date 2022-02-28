@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Invoice {{ $po->order_id }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingInvoice','Invoice',[],[])}}
              </li>
              <li class="breadcrumb-item active">Approve</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Approve Invoice {{ $po->order_id }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.changeInvoiceActStatus',$po->order_id,$page],'files'=>true])}}
                
                <div class="row">
                   <div class="col-md-12 model_title"><h3>PO No: {{ $po->order_id ?? '' }}</h3>
                    </div>

                  <div class="col-md-12 vander_dataview">
                    <ul>
                      <li>
                        <strong>Vendor:</strong><p>{{ json_decode($po->vendor_ary)->name ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Code:</strong><p>{{ json_decode($po->vendor_ary)->vendor_code ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Email:</strong><p>{{ json_decode($po->vendor_ary)->email ?? '' }}</p>
                      </li>

                      <li>
                        <strong>PO Total:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $po->net_payable ?? '' }}</p>
                      </li>

                      @php
                        
                        $invc=\App\Invoice::approvedPoInvoice($po->id);
                      @endphp

                      <li>
                        <strong>Invoice Approved:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $invc }}</p>
                      </li>

                      <li class="w-33">
                        <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $po->net_payable-$invc }}</p>
                      </li>

                    </ul>
                    
                  
                  </div>
                  <div class="col-md-12">
                     <div class="row">
                      <div class="col-md-12">
                         <table class="table">
                           <tr>
                            <th>Date</th>
                            <th>Number</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th>Image</th>
                          </tr>
                        @forelse($data->get() as $itemKey => $itemVal)
                       
                         
                          <tr>
                            <td>{{ date('d M Y',strtotime($itemVal->invoice_date)) }}</td>
                            <td>{{$itemVal->invoice_number}}</td>
                            <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->invoice_amount}}</td>
                            <td>
                              {{ \App\Invoice::invoiceStatus($itemVal->invoice_status) }}
                            </td>
                            <td>
                              @php
                                $comt='';
                                if($itemVal->invoice_status==3){
                                  $comt=$itemVal->manager_comment;
                                }
                                if($itemVal->invoice_status==4){
                                  $comt=$itemVal->financer_comment;
                                }
                                if($itemVal->invoice_status==5){
                                  $comt=$itemVal->trust_comment;
                                }
                              @endphp
                              {{ Form::hidden('invoice_id[]',$itemVal->id)}}
                              {!! Form::select('invoice_status[]',\App\Invoice::invoiceStatusChange(),[$itemVal->invoice_status],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'inv_status'.$itemVal->id,'onchange'=>"chkReq($itemVal->id)",'placeholder'=>'Invoice Status','required'=>true])!!}
                              <span class="text-danger">{{ $errors->first('invoice_status.*') }}</span>
                              {{ Form::textarea('invoice_status_comment[]',$comt,['class'=>'form-control textareaCustom','rows'=>'2','placeholder'=>'Comment here','id'=>'status_cmt_'.$itemVal->id])}}
                              <span class="text-danger" id="span{{$itemVal->id}}">{{ $errors->first('invoice_status_comment.*') }}</span>

                            </td>
                            <td>
                                 {!! Html::decode(link_to('public/'.$itemVal->invoice_file_path,\App\Helpers\Helper::getDocType($itemVal->invoice_file_path,$itemVal->po_file_type),['target'=>'_blank'])) !!}
                            </td>
                          </tr>
                        
                        @empty

                        @endforelse
                        </table>
                       
                      </div>
                       

                    </div>
                  
                </div>
              <!-- /.row -->
                <div class="card-footer">
                  {!! Form::submit('Save',['class'=>'btn btn-outline-primary']) !!}
                </div>
            {{ Form::close() }}
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@endsection

@section('footer')
<script type="text/javascript">
  function chkReq(a) {
   var stVal = ($('#inv_status'+a).val());
   if (stVal==2) {
      $('#status_cmt_'+a).attr('required',true);
   }else{
    $('#status_cmt_'+a).attr('required',false);
   }
  }
</script>
 @endsection