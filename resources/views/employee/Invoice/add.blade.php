@extends('layouts.employee')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
 
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.invoices','Invoices',[],[])}}
              </li>
              <li class="breadcrumb-item active">Add</li>
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
            <h3 class="card-title">Add Invoice</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            {{ Form::open(['route'=>['employee.saveInvoice'],'files'=>true,'onSubmit'=>'return chkAmt()'])}}
              <div class="row">
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('vendor','Vendor') }}
                    {!!Form::select('vendor', $vendors, '', ['placeholder' => 'Vendor','class'=>'form-control custom-select select2','id'=>'vendor','required'=>true])!!}
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
                    @php $data=[]; @endphp
                  @endif
                    {{ Form::label('po_number','PO Number') }}
                    {!!Form::select('po_number', $data, '', ['placeholder' => 'Select PO Number','class'=>'form-control custom-select select2','id'=>'poList','required'=>true])!!}
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
               @if(old('po_number') && old('po_number'))
                    @php
                      $odata=\App\PurchaseOrder::where(['order_id'=>old('po_number'),'account_status'=>'4'])->first();
                      $poDate=date('Y-m-d',strtotime($odata->created_at));
                      $poNetAmt=$odata->net_payable;
                    @endphp
                  @else
                    @php 
                      $poDate='';
                      $poNetAmt='';
                    @endphp
                  @endif
              <div class="row" id="orDate">
               
              </div>
              <div class="row">
              
                <div class="col-md-12">
                  <div class="" id="Goods">
                      <div class="row">
                       {{-- <div class="col-md-1 srDiv">
                           <div class="form-group">
                             {{ Form::label('Sr','Sr.') }}
                              <p class="sr">1</p>
                            </div>
                          </div>--}}
                         <div class="col-md-4">
                           <div class="form-group">
                              {{ Form::label('Invoice Date','Invoice Date') }}
                              {{ Form::date('invoice_date','',['class'=>'form-control invoice_date','placeholder'=>'Invoice Date','required'=>true,'id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('invoice_date')}}</span>
                            </div>
                          </div>
                          <div class="col-md-4">
                           <div class="form-group">
                              {{ Form::label('Invoice Number','Invoice Number') }}
                              {{ Form::text('invoice_number','',['class'=>'form-control','placeholder'=>'Invoice Number','required'=>true,'id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('invoice_number')}}</span>
                            </div>
                          </div>
                          <div class="col-md-4">
                           <div class="form-group">
                              {{ Form::label('Advance_payment','Advance Payment') }}
                              {{ Form::select('advance_payment_mode',['Yes'=>'Yes','No'=>'No'],'',['class'=>'form-control custom-select select2','placeholder'=>'Advance Payment','required'=>true,'id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('advance_payment_mode')}}</span>
                            </div>
                          </div>
                         
                           <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('amount','Amount') }}
                                {{ Form::number('amount','',['class'=>'form-control','placeholder'=>'Amount','required'=>true,'id'=>'amount0','onKeyUp'=>"countVal(0)"]) }}
                                <span class="text-danger">{{ $errors->first('amount')}}</span>
                              </div>
                          </div>
                           <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('tax','Tax in %') }}
                                {{ Form::number('tax','',['class'=>'form-control','placeholder'=>'Tax in %','required'=>true,'id'=>'tax0','onKeyUp'=>"countVal(0)"]) }}
                                <span class="text-danger">{{ $errors->first('tax')}}</span>
                              </div>
                          </div>
                         
                          <div class="col-md-4">
                           <div class="form-group">
                              {{ Form::label('total','Total') }}
                              {{ Form::number('invoice_amount','',['class'=>'form-control total','placeholder'=>'Total','required'=>true,'id'=>'total0','readonly'=>true]) }}
                              <span class="text-danger">{{ $errors->first('total')}}</span>
                            </div>
                          </div>
                           <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('file','Invoice Image') }}
                                {{ Form::file('image',['class'=>'form-control total','required'=>true]) }}
                                <span class="text-danger">{{ $errors->first('image')}}</span>
                              </div>
                            </div>
                          </div>
                  </div>
                {{--  <div class="col-md-12 text-right">
                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                    
                  </div>--}}
                </div>
                 

              </div>
              
               <!--  <button class="btn btn-danger"><i class="fa fa-minus"></i></button> -->
                <!-- /.col   -->
            <!-- /.row -->
              <div class="card-footer">
                <p class="subAlt"></p>
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

function chkAmt() {
  /*var po_amt=$('#net_payable').attr('class');
   var sum = 0;
    $(".total").each(function(){
        sum += +$(this).val();
    });
  alert(po_amt,sum);
  return false;*/
}
</script>

<script type="text/javascript">
  
  $('.plus').click(function(){
    var min_date=$('#min_date').val();
    var max_date=$('#max_date').val();
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row Goods" id="removeItemRow'+cls+'"><div class="col-md-1 srDiv"><p class="sr">'+sr+'</p></div><div class="col-md-2"><div class="form-group"> <input class="form-control" placeholder="Invoice Date" required="" id="" name="invoice_date[]" type="date" min="'+min_date+'" max="'+max_date+'"></div></div><div class="col-md-1"><div class="form-group"> <input class="form-control" placeholder="Invoice Number" required name="invoice_number[]" type="text" value="" min="0" id=""> </div></div><div class="col-md-2"><div class="form-group"><select class="form-control custom-select select2" name="advance_payment_mode[]" required><option value="">Choose Mode</option><option value="Yes">Yes</option><option value="No">No</option></select></div></div><div class="col-md-1"> <div class="form-group"><input class="form-control" placeholder="Amount" name="amount[]" type="number" value="" required min="0" id="amount'+cls+'" onKeyUp="countVal('+cls+')"> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Tax" name="tax[]" type="number" value="" required min="0" id="tax'+cls+'" onKeyUp="countVal('+cls+')"></div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control total" placeholder="Total" name="invoice_amount[]" type="number" value="" required min="0" id="total'+cls+'" readonly></div></div><div class="col-md-2"><div class="form-group"><input class="form-control" name="image[]" type="file" value="" required min="0" id="rate'+cls+'"></div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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


