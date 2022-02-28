@extends('layouts.employee')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Purchase Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
 
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingPO','Purchase Orders',[],[])}}
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
            <h3 class="card-title">Add Purchase Order</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.savePO'],'files'=>true])}}
              <div class="row">

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Order No','Order No') }}
                    {{ Form::text('order_no',$ordNo,['class'=>'form-control','placeholder'=>'Odrer NO:','required'=>true,'readonly'=>true]) }}
                    <span class="text-danger">{{ $errors->first('order_no')}}</span>
                  </div>
                </div>

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
                    {{ Form::label('po_start_date','Start Date') }}
                    {{ Form::date('po_start_date','',['class'=>'form-control','placeholder'=>'Start Date','required'=>true,'max'=>'']) }}
                    <span class="text-danger">{{ $errors->first('po_start_date')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('po_end_date','End Date') }}
                    {{ Form::date('po_end_date','',['class'=>'form-control','placeholder'=>'End Date','required'=>true,'max'=>'']) }}
                    <span class="text-danger">{{ $errors->first('po_end_date')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('payment_method','Payment Method') }}
                    {{ Form::select('payment_method',\App\PurchaseOrder::paymentMethod(),'',['class'=>'form-control custom-select select2','placeholder'=>'Payment Method','required'=>true]) }}
                    <span class="text-danger">{{ $errors->first('payment_method')}}</span>
                  </div>
                </div>
               

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('nature_of_service','Nature Of Goods') }}
                    {{ Form::select('nature_of_service',\App\PurchaseOrder::natureOfService(),'',['class'=>'form-control custom-select select2','placeholder'=>'Nature Of Goods','id'=>"chkNature",'required'=>true]) }}
                    <span class="text-danger">{{ $errors->first('nature_of_service')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Apex','Apex') }}
                    {{ Form::select('apex',$apexes,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                    <span class="text-danger">{{ $errors->first('apex')}}</span>
                  </div>
                </div>
                  @php
                  $none = 'display:none';
                    if(old('nature_of_service')!='Goods' && old('nature_of_service')){
                      $none = '';
                    }
                  @endphp
                <div class="col-md-12" id="Services" style="{{$none}}">
                 <div class="form-group">
                    {{ Form::label('service_detail','Service Detail') }}
                    {{ Form::textarea('service_detail','',['class'=>'form-control','placeholder'=>'Service Detail','rows'=>5]) }}
                    <span class="text-danger">{{ $errors->first('service_detail')}}</span>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="row Goods" id="Goods">
                    <div class="row">
                      <div class="col-md-1 srDiv">
                       <div class="form-group">
                          {{ Form::label('Sr','Sr.') }}
                          <p class="sr">1</p>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          {{ Form::label('Item Name','Item Name') }}
                          {{ Form::text('item_name[]','',['class'=>'form-control','placeholder'=>'Item Name','required'=>true,'id'=>'']) }}
                          <span class="text-danger">{{ $errors->first('item_name')}}</span>
                        </div>
                      </div>
                      <div class="col-md-1">
                       <div class="form-group">
                          {{ Form::label('quantity','Quantity') }}
                          {{ Form::number('quantity[]','',['class'=>'form-control','placeholder'=>'Quantity','required'=>true,'id'=>'quantity0','onKeyUp'=>"countVal(0)"]) }}
                          <span class="text-danger">{{ $errors->first('quantity')}}</span>
                        </div>
                      </div>
                      <div class="col-md-1">
                       <div class="form-group">
                          {{ Form::label('unit','Unit') }}
                          {{-- Form::select('unit[]',\App\PurchaseOrder::unit(),'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Unit','required'=>true]) --}}
                          {{ Form::text('unit[]','',['class'=>'form-control unit','placeholder'=>'Unit','required'=>true,'id'=>'u1']) }}
                          <span class="text-danger u1">{{ $errors->first('unit')}}</span>
                        </div>
                      </div>
                      <div class="col-md-1">
                       <div class="form-group">
                          {{ Form::label('rate','Rate') }}
                          {{ Form::number('rate[]','',['class'=>'form-control','placeholder'=>'Rate','required'=>true,'id'=>'rate0','onKeyUp'=>"countVal(0)"]) }}
                          <span class="text-danger">{{ $errors->first('rate')}}</span>
                        </div>
                      </div>
                       <div class="col-md-1">
                         <div class="form-group">
                            {{ Form::label('tax','Tax in %') }}
                            {{ Form::number('tax[]','',['class'=>'form-control','placeholder'=>'Tax in %','required'=>true,'id'=>'tax0','onKeyUp'=>"countVal(0)"]) }}
                            <span class="text-danger">{{ $errors->first('tax')}}</span>
                          </div>
                      </div>
                      <div class="col-md-1">
                         <div class="form-group">
                            {{ Form::label('Tax Value','Tax Value') }}
                            {{ Form::number('tax_value[]','',['class'=>'form-control','placeholder'=>'Value','readonly'=>true,'id'=>'tax_value0','onKeyUp'=>"countVal(0)"]) }}
                            <span class="text-danger">{{ $errors->first('tax_value')}}</span>
                          </div>
                      </div>
                       <div class="col-md-2">
                         <div class="form-group">
                            {{ Form::label('Comment','Comment') }}
                            {{-- Form::select('price_unit[]',\App\PurchaseOrder::unit(),'',['class'=>'form-control custom-select select2','placeholder'=>'Price unit','required'=>true]) --}}
                            {{ Form::text('price_unit[]','',['class'=>'form-control','placeholder'=>'Comment']) }}
                            <span class="text-danger">{{ $errors->first('price_unit')}}</span>
                          </div>
                      </div>
                      <div class="col-md-1">
                       <div class="form-group">
                          {{ Form::label('total','Total') }}
                          {{ Form::number('total[]','',['class'=>'form-control total','placeholder'=>'Total','required'=>true,'id'=>'total0','readonly'=>true]) }}
                          <span class="text-danger">{{ $errors->first('total')}}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 text-right">
                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                    
                  </div>
                </div>
                   <table class="table">
                      <tr>
                        <td width="80%" class="text-right"> {{ Form::label('discount','Discount') }}</td>
                        <td>{{ Form::number('discount','',['class'=>'form-control discount','placeholder'=>'Discount','min'=>'0','onKeyUp'=>"countVal(0)"]) }}
                          <span class="text-danger">{{ $errors->first('discount')}}</span></td>
                      </tr>
                       <tr>
                        <td width="80%" class="text-right">{{ Form::label('net_payable','Net Payable') }}</td>
                        <td> {{ Form::number('net_payable','',['class'=>'form-control net_payable','placeholder'=>'Net Payable','readonly'=>true]) }}
                          <span class="text-danger">{{ $errors->first('net_payable')}}</span></td>
                      </tr>
                    </table>
                  
                
                @if(Auth::guard('employee')->user()->role_id==5)
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('advance_tds','Advance TDS on purchase of Goods') }}
                    {{ Form::select('advance_tds',['Yes'=>'Yes','No'=>'No'],'',['class'=>'form-control custom-select select2','placeholder'=>'Advance TDS']) }}
                    <span class="text-danger">{{ $errors->first('advance_tds')}}</span>
                  </div>
                </div>
                @endif
                <div class="col-md-12">
                  {{ Form::label('po_description','PO Description') }}
                  {{ Form::textarea('po_description','',['class'=>'form-control','placeholder'=>'PO Description','rows'=>'5'])}}
                   <span class="text-danger">{{ $errors->first('po_description')}}</span>
                </div>
                
              </div>
              <div class="row imgSection">
                    <div class="col-md-3" id="IMAGESEC">
                        <div class="form-group">
                          {!!Form::label('Attachments', 'Attachments')!!}
                             {!!Form::file('po_file[]',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                          @if($errors->has('po_file'))
                              <p class="text-danger">{{$errors->first('po_file')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                          {!!Form::label('description', 'Attachment Description')!!}
                             {!!Form::textarea('po_file_description[]','',['class'=>'form-control','rows'=>3,'placeholder'=>'Description about attachment file'])!!}
                          @if($errors->has('po_file'))
                              <p class="text-danger">{{$errors->first('po_file_description')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 text-left editIcon">
                      {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary addIMg'])) !!}
                      {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger removeIMg','style'=>'display:none'])) !!}
                    </div>
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
  $('#chkNature').change(function(){
    if($('#chkNature').val()=='Goods'){
      $('.newGD').remove();
      $('#Services').hide();
    }else{
     $('.newGD').remove();
      $('#Services').show();
    }
  });
</script>
<script type="text/javascript">

  $('.addIMg').click(function() {
    var cls = $('.IMGRow').length;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="col-md-3 IMGRow"> <div class="form-group"> <label for="file">Attachment</label> <input class="dropify form-control" data-default-file="" id="input-file-now-custom-1" name="po_file[]" type="file" required> </div><div class="form-group"> <label for="description">Attachment Description</label> <textarea class="form-control" rows="3" name="po_file_description[]" cols="50" placeholder="Description about attachment file"></textarea> </div></div>';
      $('#IMAGESEC').after(clone);
      var cls = $('.IMGRow').length;
      if (cls) {
        $('.removeIMg').show();
      }
  });
  $('.removeIMg').click(function(){
      var cls = $('.IMGRow').length;
      if (cls == 1) {
        $('.removeIMg').hide();
      }
      $('.IMGRow').last().remove();
  });

  
  
  $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-1 srDiv"><p class="sr">'+sr+'</p></div><div class="col-md-2"><div class="form-group"><input class="form-control" placeholder="Item Name" required="" id="" name="item_name[]" type="text" value=""> <span class="text-danger"></span></div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Quantity" required name="quantity[]" type="number" value="" min="0" id="quantity'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"><input type="text" class="form-control unit" name="unit[]" required placeholder="Unit" id="u'+sr+'" onKeypress="return chkUnit(event,'+sr+')"> <span class="text-danger u'+sr+'"></span> </div></div><div class="col-md-1"> <div class="form-group"><input class="form-control" placeholder="Rate" name="rate[]" type="number" value="" required min="0" id="rate'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Tax" name="tax[]" type="number" value="" required min="0" id="tax'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Value" name="tax_value[]" type="number" value="" readonly min="0" id="tax_value'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" name="price_unit[]" required placeholder="Comment"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control total" placeholder="Total" name="total[]" type="number" value="" required min="0" id="total'+cls+'" readonly> <span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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
    var total =$('#quantity'+argument).val()*$('#rate'+argument).val();
    var tx = (total*$('#tax'+argument).val())/100;
    $('#tax_value'+argument).val(tx);
    $('#total'+argument).val(total+tx);
    
    var sum = 0;
    $("input[class *= 'total']").each(function(){
        sum += +$(this).val();
    });
    var discount = $('#discount').val();
    $(".net_payable").val(sum-discount);


  }

  function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }

  $(".unit").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
            var id=$(this).attr('id');
            //alert(id);
            $("."+id).html("");
 
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("."+id).html("Only Alphabets allowed.");
            }
 
            return isValid;
        });
  function chkUnit(e,argument) {
    var keyCode = e.keyCode || e.which;
            var id=argument;
            $(".u"+id).html("");
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z]+$/;
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
              $('#u'+id).val('');
                $(".u"+id).html("Only Alphabets allowed.");
            }
            return isValid;
  }
</script>
 @endsection
