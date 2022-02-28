@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Invoice {{ $data->order_id }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.invoices','Invoice',[],[])}}
              </li>
              <li class="breadcrumb-item active">Edit</li>
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
            <h3 class="card-title">Edit Invoice {{ $data->order_id }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.updateInvoice',$po->order_id,$page],'files'=>true])}}
                
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                       <div class="form-group">
                          {{ Form::label('vendor','Vendor') }}
                          {!!Form::select('vendor', $vendors, $po->vendor_id, ['placeholder' => 'Vendor','class'=>'form-control custom-select select2','id'=>'vendor','required'=>true])!!}
                          <span class="text-danger">{{ $errors->first('vendor')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                       <div class="form-group" id="vCode">
                        @if(old('vendor') && old('vendor'))
                          @php
                            $data=\App\PurchaseOrder::where(['vendor_id'=>old('vendor'),'account_status'=>'4'])->pluck('order_id','order_id');
                          @endphp
                        @else
                          @php $data=\App\PurchaseOrder::where(['vendor_id'=>$po->vendor_id,'account_status'=>'4'])->pluck('order_id','order_id'); @endphp
                        @endif
                          {{ Form::label('po_number','PO Number') }}
                          {!!Form::select('po_number', $data, $po->order_id, ['placeholder' => 'Select PO Number','class'=>'form-control custom-select select2','id'=>'poList','required'=>true])!!}
                          <span class="text-danger">{{ $errors->first('po_number')}}</span>
                        </div>
                      </div>
                    </div>
                     <div class="row" id="orDate">
                        @if(old('po_number') && old('po_number'))
                          @php
                            $odata=\App\PurchaseOrder::where(['order_id'=>old('po_number'),'account_status'=>'4'])->first();
                            $poDate=date('Y-m-d',strtotime($odata->po_start_date));
                            $poEndDate=date('Y-m-d',strtotime($odata->po_end_date));
                            $poNetAmt=$odata->net_payable;
                          @endphp
                        @else
                          @php 
                           $odata=\App\PurchaseOrder::where(['order_id'=>$po->order_id,'account_status'=>'4'])->first();
                            $poDate=date('Y-m-d',strtotime($odata->po_start_date));
                            $poEndDate=date('Y-m-d',strtotime($odata->po_end_date));
                            $poNetAmt=$odata->net_payable;
                          @endphp
                        @endif
                         @php
        
                          $invc=\App\Invoice::where(['invoice_status'=>5,'po_id'=>$po->id])->where('invoice_status','!=','2')->sum('invoice_amount');
                        @endphp
                        <div class="col-md-2">
                            <div class="form-group">
                            {{ Form::label('Order_date','PO Start Date') }}
                            {!!Form::date('order_date',$poDate, ['placeholder' => 'Order date','class'=>'form-control','readonly'=>true])!!}
                          </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                            {{ Form::label('Order_date','PO End Date') }}
                            {!!Form::date('order_date',$poEndDate, ['placeholder' => 'Order date','class'=>'form-control','readonly'=>true])!!}
                          </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                            {{ Form::label('net_payable','Order Amount') }}
                            {!!Form::number('net_payable',$poNetAmt, ['placeholder' => 'Order Amount','class'=>'form-control','readonly'=>true])!!}
                          </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                            {{ Form::label('approved_balance','Approved Balance') }}
                            {!!Form::number('approved_balance', $invc, ['placeholder' => 'Approved Balance','class'=>'form-control','readonly'=>true])!!}
                          </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            {{ Form::label('pending_balance','Pending Balance') }}
                            {!!Form::number('pending_balance', $poNetAmt-$invc, ['placeholder' => 'Pending Balance','class'=>'form-control','readonly'=>true])!!}
                          </div>
                        </div>
                    </div>
                     <div class="row">
                      <div class="col-md-12">
                         <table class="table">
                           <tr>
                            <th>Invoice Date</th>
                            <th>Invoice Number</th>
                            <th>Invoice Amount</th>
                            <th>Invoice Image</th>
                          </tr>
                        @forelse(\App\Invoice::where(['po_id'=>$po->id])->whereIn('invoice_status',['1','2'])->get() as $itemKey => $itemVal)
                       
                         
                          <tr>
                            <td>{{ date('d M Y',strtotime($itemVal->invoice_date)) }}</td>
                            <td>{{$itemVal->invoice_number}}</td>
                            <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->invoice_amount}}</td>
                            <td>
                                 <a href="{{url('public/'.$itemVal->invoice_file_path)}}" target="_blank"><img src="{{ url('public/'.$itemVal->invoice_file_path) }}" alt="user" class="img-fluit edit-product-img" style="width: 70px;height: 70px;" /></a>
                            </td>
                          </tr>
                         {{-- <div class="row" id="SavGoods{{$itemKey}}">
                            <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::label('Invoice Date','Invoice Date') }}
                                  {{ Form::date('invoice_date[]',$itemVal->invoice_date,['class'=>'form-control','placeholder'=>'Invoice Date','required'=>true,'id'=>'']) }}
                                  <span class="text-danger">{{ $errors->first('invoice_date.*')}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                             <div class="form-group">
                                {{ Form::label('Invoice Number','Invoice Number') }}
                                {{ Form::text('invoice_number[]',$itemVal->invoice_number,['class'=>'form-control','placeholder'=>'Invoice Number','required'=>true,'id'=>'']) }}
                                <span class="text-danger">{{ $errors->first('invoice_number.*')}}</span>
                              </div>
                            </div>
                             <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::label('Invoice Amount','Invoice Amount') }}
                                  {{ Form::number('invoice_amount[]',$itemVal->invoice_amount,['class'=>'form-control','placeholder'=>'Invoice Amount','required'=>true,'id'=>'invoice_amount'.$itemKey,'onKeyUp'=>"countVal($itemKey)"]) }}
                                  <span class="text-danger">{{ $errors->first('invoice_amount.*')}}</span>
                                </div>
                            </div>
                             <div class="col-md-3">
                               <div class="form-group">
                                  {{ Form::label('file','Invoice Image') }}
                                  {{ Form::file('image[]',['class'=>'form-control total','required'=>true]) }}
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  <img src="{{ url('public/'.$itemVal->invoice_file_path) }}" alt="user" class="img-fluit edit-product-img" style="width: 70px;height: 70px;" />
                                </div>
                              </div>
                          </div>--}}
                        @empty

                        @endforelse
                        </table>
                        @if($invc < \App\Invoice::invoiceLimit($poNetAmt))
                        <div class="row" id="Goods">
                        </div>
                        <div class="col-md-12 text-right">
                          {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                        </div>
                        @endif
                      </div>
                        {{-- <table class="table">
                           <tr>
                              <td width="80%" class="text-right">{{ Form::label('net_payable','Net Payable') }}</td>
                              <td> {{ Form::number('net_payable','',['class'=>'form-control net_payable','placeholder'=>'Net Payable','readonly'=>true]) }}
                                <span class="text-danger">{{ $errors->first('net_payable')}}</span></td>
                            </tr>
                          </table>--}}

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
  $(document).ready(function(){
    function rawRemove(a){
      $('#SavGoods'+a).remove();
    }
    
      $('#vendor').change(function(){
      var vId=$(this).val();
      if (vId!='') {
        var url="{{ route('employee.vendorAjaxResponse') }}";
             
              $.ajax({
                type:"POST",
                url:url,
                data:{vId:vId , _token: '{{csrf_token()}}'},
                beforeSend: function(){
                 //$('#preloader').show();
                },
                success:function(response){
                  var json = $.parseJSON(response);
                  $('#vCode').val(json.vendor_code);//vendor_code
                   //$('#cityDiv').empty().append(response);
                  //$('#preloader').hide();
                }
              });
      }else{
        $('#vCode').val(null);
      }
    });
  });

</script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#vendor').change(function(){
      var vId=$(this).val();
      if (vId!='') {
        var url="{{ route('employee.invoiceVendorAjax') }}";
             
              $.ajax({
                type:"POST",
                url:url,
                data:{vId:vId , _token: '{{csrf_token()}}','type':'vendorOrderList'},
                beforeSend: function(){
                 //$('#preloader').show();
                },
                success:function(response){
                  //var json = $.parseJSON(response);
                  //$('#vCode').val(json.vendor_code);//vendor_code
                  $('#orDate').empty();
                   $('#vCode').empty().append(response);
                  //$('#preloader').hide();
                }
              });
      }else{
        $('#vCode').val(null);
      }
    });
    /*---*/
     $('#poList').change(function(){
        var order_id=$(this).val();
        if (order_id!='') {
          var url="{{ route('employee.InvoicePOAjaxResponse') }}";
               
                $.ajax({
                  type:"POST",
                  url:url,
                  data:{order_id:order_id , _token: '{{csrf_token()}}','type':'poDetail'},
                  beforeSend: function(){
                   //$('#preloader').show();
                  },
                  success:function(response){
                    //var json = $.parseJSON(response);
                    //$('#vCode').val(json.vendor_code);//vendor_code
                     $('#orDate').empty().append(response);
                    //$('#preloader').hide();
                  }
                });
        }else{
          $('#vCode').val(null);
        }
      });
    /*---*/
  });


</script>

<script type="text/javascript">
  
  $('.plus').click(function(){
    var cls = $('.Goods').length;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row Goods" id="removeItemRow'+cls+'"><div class="col-md-3"><div class="form-group"> <label for="Item Name">Invoice Date</label> <input class="form-control" placeholder="Invoice Date" required="" id="" name="invoice_date[]" type="date" value=""> <span class="text-danger"></span></div></div><div class="col-md-3"><div class="form-group"> <label for="invoice_number">Invoice Number</label> <input class="form-control" placeholder="Invoice Number" required name="invoice_number[]" type="text" value="" min="0" id=""> <span class="text-danger"></span></div></div><div class="col-md-3"><div class="form-group"> <label for="invoice_amount">Invoice Amount</label> <input type="number" class="form-control" name="invoice_amount[]" required placeholder="Invoice Amount"> <span class="text-danger"></span></div></div><div class="col-md-2"><div class="form-group"> <label for="rate">Invoice Image</label> <input class="form-control" name="image[]" type="file" value="" required min="0" id="rate'+cls+'"> <span class="text-danger"></span></div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
    $('#Goods').append(clone);
    var cls = $('.Goods').length;
    if (cls) {
      $('.trash').show();
    }
  });
  function countVal(argument) {
    var total =$('#quantity'+argument).val()*$('#rate'+argument).val();
    $('#total'+argument).val(total);
    
    var sum = 0;
    $("input[class *= 'total']").each(function(){
        sum += +$(this).val();
    });
    var discount = $('#discount').val();
    $(".net_payable").val(sum-discount);


  }

  function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).hide();
  }
</script>
 @endsection