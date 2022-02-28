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
                {{link_to_route('employee.withoutPoinvoices','Without PO Invoices',[],[])}}
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

            {{ Form::open(['route'=>['employee.saveWithoutPoInvoice'],'files'=>true])}}
              <div class="row">
               
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('vendor','Vendor') }}
                    {!!Form::select('vendor', $vendors, '', ['placeholder' => 'Vendor','class'=>'form-control custom-select select2','id'=>'vendor','required'=>true])!!}
                    <span class="text-danger">{{ $errors->first('vendor')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                   <div class="form-group">
                      {{ Form::label('Vendor Code','Vendor Code') }}
                      {{ Form::text('vendor_code','',['class'=>'form-control','placeholder'=>'Vendor Code','readonly'=>true,'id'=>'vCode']) }}
                      <span class="text-danger">{{ $errors->first('vendor_code')}}</span>
                    </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Apex','Apex') }}
                    {{ Form::select('apex',$apexes,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                    <span class="text-danger">{{ $errors->first('apex')}}</span>
                  </div>
                </div>
              </div>
              
              <div class="row">
              
                <div class="col-md-12">
                  <div class="" id="Goods">
                      <div class="row">
                        <div class="col-md-1 srDiv">
                           <div class="form-group">
                             {{ Form::label('Sr','Sr.') }}
                              <p class="sr">1</p>
                            </div>
                          </div>
                         <div class="col-md-2">
                           <div class="form-group">
                              {{ Form::label('Invoice Date','Invoice Date') }}
                              {{ Form::date('invoice_date[]','',['class'=>'form-control','placeholder'=>'Invoice Date','required'=>true,'id'=>'','max'=>date('Y-m-d')]) }}
                              <span class="text-danger">{{ $errors->first('invoice_date.*')}}</span>
                            </div>
                          </div>
                          <div class="col-md-2">
                           <div class="form-group">
                              {{ Form::label('Invoice Number','Invoice Number') }}
                              {{ Form::text('invoice_number[]','',['class'=>'form-control','placeholder'=>'Invoice Number','required'=>true,'id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('invoice_number.*')}}</span>
                            </div>
                          </div>
                          
                           <div class="col-md-2">
                             <div class="form-group">
                                {{ Form::label('amount','Amount') }}
                                {{ Form::number('amount[]','',['class'=>'form-control','placeholder'=>'Amount','required'=>true,'id'=>'amount0','onKeyUp'=>"countVal(0)"]) }}
                                <span class="text-danger">{{ $errors->first('amount')}}</span>
                              </div>
                          </div>
                           <div class="col-md-1">
                             <div class="form-group">
                                {{ Form::label('tax','Tax in %') }}
                                {{ Form::number('tax[]','',['class'=>'form-control','placeholder'=>'Tax in %','required'=>true,'id'=>'tax0','onKeyUp'=>"countVal(0)"]) }}
                                <span class="text-danger">{{ $errors->first('tax')}}</span>
                              </div>
                          </div>
                         
                          <div class="col-md-2">
                           <div class="form-group">
                              {{ Form::label('total','Total') }}
                              {{ Form::number('invoice_amount[]','',['class'=>'form-control total','placeholder'=>'Total','required'=>true,'id'=>'total0','readonly'=>true]) }}
                              <span class="text-danger">{{ $errors->first('total')}}</span>
                            </div>
                          </div>
                           <div class="col-md-2">
                             <div class="form-group">
                                {{ Form::label('file','Invoice Image') }}
                                {{ Form::file('image[]',['class'=>'form-control total','required'=>true]) }}
                                <span class="text-danger">{{ $errors->first('image.*')}}</span>
                              </div>
                            </div>
                          </div>
                  </div>
                  <div class="col-md-12 text-right">
                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                    
                  </div>
                </div>
                  {{-- <table class="table">
                     <tr>
                        <td width="80%" class="text-right">{{ Form::label('net_payable','Net Payable') }}</td>
                        <td> {{ Form::number('net_payable','',['class'=>'form-control net_payable','placeholder'=>'Net Payable','readonly'=>true]) }}
                          <span class="text-danger">{{ $errors->first('net_payable')}}</span></td>
                      </tr>
                    </table>--}}

              </div>
              
               <!--  <button class="btn btn-danger"><i class="fa fa-minus"></i></button> -->
                <!-- /.col   -->
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
     $('#vendor').change(function(){
      var vId=$(this).val();
      if (vId!='') {
        var url="{{ route('employee.WithoutPoinvoiceVendorAjax') }}";
             
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
    /*---*/
    /*---*/
  });


</script>
@php $today = date('Y-m-d'); @endphp
<script type="text/javascript">
  
  $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row Goods" id="removeItemRow'+cls+'"><div class="col-md-1 srDiv"><p class="sr">'+sr+'</p></div><div class="col-md-2"><div class="form-group"> <input class="form-control" placeholder="Invoice Date" required="" id="" name="invoice_date[]" type="date" value="" max="{{$today}}"> <span class="text-danger"></span></div></div><div class="col-md-2"><div class="form-group"> <input class="form-control" placeholder="Invoice Number" required name="invoice_number[]" type="text" value="" min="0" id=""> <span class="text-danger"></span></div></div><div class="col-md-2"> <div class="form-group"><input class="form-control" placeholder="Amount" name="amount[]" type="number" value="" required min="0" id="amount'+cls+'" onKeyUp="countVal('+cls+')"> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Tax" name="tax[]" type="number" value="" required min="0" id="tax'+cls+'" onKeyUp="countVal('+cls+')"></div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control total" placeholder="Total" name="invoice_amount[]" type="number" value="" required min="0" id="total'+cls+'" readonly></div></div><div class="col-md-2"><div class="form-group"><input class="form-control" name="image[]" type="file" value="" required min="0" id="rate'+cls+'"> <span class="text-danger"></span></div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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


