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
                {{link_to_route('employee.pendingInvoice','Invoice',[],[])}}
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

            {{ Form::open(['route'=>['employee.updatePendingInvoice',$po->order_id,$page],'files'=>true])}}
                
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                       <div class="form-group">
                          {{ Form::label('vendor','Vendor') }}
                          {!!Form::select('vendor', $vendors, $po->vendor_id, ['placeholder' => 'Vendor','class'=>'form-control','id'=>'vendor','readonly'=>true])!!}
                          <span class="text-danger">{{ $errors->first('vendor')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                       <div class="form-group" id="vCode">
                        @if(old('vendor') && old('vendor'))
                          @php
                            $data=\App\PurchaseOrder::where(['vendor_id'=>old('vendor'),'account_status'=>'4','user_id'=>Auth::guard('employee')->user()->id])->pluck('order_id','order_id');
                          @endphp
                        @else
                          @php $data=\App\PurchaseOrder::where(['vendor_id'=>$po->vendor_id,'account_status'=>'4','user_id'=>Auth::guard('employee')->user()->id])->pluck('order_id','order_id'); @endphp
                        @endif
                          {{ Form::label('po_number','PO Number') }}
                          {!!Form::select('po_number', $data, $po->order_id, ['placeholder' => 'Select PO Number','class'=>'form-control','id'=>'poList','readonly'=>true])!!}
                          <span class="text-danger">{{ $errors->first('po_number')}}</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                       <div class="form-group">
                          {{ Form::label('Apex','Apex') }}
                          {{ Form::select('apex',$apexes,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'','required'=>true]) }}
                          <span class="text-danger">{{ $errors->first('apex')}}</span>
                        </div>
                      </div>
                    </div>
                     <div class="row" id="orDate">
                        @if(old('po_number') && old('po_number'))
                          @php
                            $odata=\App\PurchaseOrder::where(['order_id'=>old('po_number'),'account_status'=>'4'])->first();
                            $poDate=date('Y-m-d',strtotime($odata->created_at));
                            $poNetAmt=$odata->net_payable;
                          @endphp
                        @else
                          @php 
                           $odata=\App\PurchaseOrder::where(['order_id'=>$po->order_id,'account_status'=>'4'])->first();
                            $poDate=date('Y-m-d',strtotime($odata->created_at));
                            $poNetAmt=$odata->net_payable;
                          @endphp
                        @endif
                         @php
        
                          $invc=\App\Invoice::approvedPoInvoice($po->id);
                        @endphp
                        <div class="col-md-2">
                          <p>PO Start Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($po->po_start_date) ?? '' }}</strong></p>
                      </div>
                      <div class="col-md-2">
                           <p>PO End Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($po->po_end_date) ?? '' }}</strong></p>
                      </div>
                        <div class="col-md-2">
                          <p>Order Amount: <br><strong>{{ env('CURRENCY_SYMBOL').''.$poNetAmt ?? '0' }}</strong></p>
                        </div>

                        <div class="col-md-3">
                          <p>Approved Balance: <br><strong>{{ env('CURRENCY_SYMBOL').''.$invc }}</strong></p>
                        </div>
                        <div class="col-md-3">
                          <p>Pending Balance: <br><strong>{{ env('CURRENCY_SYMBOL').''.($poNetAmt-$invc) }}</strong></p>
                        </div>
                    </div>
                     <div class="row">
                      <div class="col-md-12">
                        
                         @forelse ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                            @empty
                        @endforelse
                      </div>
                      <div class="col-md-12">
                         <table class="table">
                           <tr>
                            <th>Sr:</th>
                            <th>Date</th>
                            <th>Number</th>
                            <th>Advance Payment</th>
                            <th>Amount</th>
                            <th>Tax</th>
                            <th>tax Amount</th>
                            <th>Total</th>
                            <th>Image</th>
                          </tr>
                        @forelse(\App\Invoice::where(['po_id'=>$po->id])->whereIn('invoice_status',['1','2'])->get() as $itemKey => $itemVal)
                          <tr>
                            <td>
                              <p class="sr">{{++$itemKey}}</p>
                            </td>
                            <td>{{ date('d M Y',strtotime($itemVal->invoice_date)) }}</td>
                            <td>{{$itemVal->invoice_number}}</td>
                            <td>{{$itemVal->advance_payment_mode ?? ''}}</td>
                            <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->amount}}</td>
                            <td>{{$itemVal->tax}}</td>
                            <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->tax_amount}}</td>
                             <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->invoice_amount}}</td>
                            <td>
                                 {!! Html::decode(link_to('public/'.$itemVal->invoice_file_path,\App\Helpers\Helper::getDocType($itemVal->invoice_file_path,$itemVal->po_file_type),['target'=>'_blank'])) !!}
                            </td>
                          </tr>
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
    var min_date='{{$po->po_start_date}}';
    var max_date='{{$po->po_end_date}}';
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row Goods" id="removeItemRow'+cls+'"><div class="col-md-1 srDiv"><p class="sr">'+sr+'</p></div><div class="col-md-2"><div class="form-group"> <input class="form-control" placeholder="Invoice Date" required="" id="" name="invoice_date[]" type="date" min="'+min_date+'" max="'+max_date+'"></div></div><div class="col-md-1"><div class="form-group"> <input class="form-control" placeholder="Invoice Number" required name="invoice_number[]" type="text" value="" min="0" id=""></div></div><div class="col-md-2"><div class="form-group"><select class="form-control custom-select select2" name="advance_payment_mode[]" required><option value="">Choose Mode</option><option value="Yes">Yes</option><option value="No">No</option></select></div></div><div class="col-md-1"> <div class="form-group"><input class="form-control" placeholder="Amount" name="amount[]" type="number" value="" required min="0" id="amount'+cls+'" onKeyUp="countVal('+cls+')"> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Tax" name="tax[]" type="number" value="" required min="0" id="tax'+cls+'" onKeyUp="countVal('+cls+')"></div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control total" placeholder="Total" name="invoice_amount[]" type="number" value="" required min="0" id="total'+cls+'" readonly></div></div><div class="col-md-2"><div class="form-group"><input class="form-control" name="image[]" type="file" value="" required min="0" id="rate'+cls+'"></div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
    $('#Goods').append(clone);
    var cls = $('.Goods').length;
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
    if (cls) {
      $('.trash').show();
    }
  });
  function countVal(argument) {
    var amount =$('#amount'+argument).val();
    var tax =$('#tax'+argument).val();
    var charge=$('#amount'+argument).val()*$('#tax'+argument).val()/100;
    var tot=parseInt(charge)+parseInt(amount);
    $('#total'+argument).val(tot);
  }
  function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }
</script>
 @endsection