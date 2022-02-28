@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice Item {{ $indata->invoice_number }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingInvoice','Back',[],[])}}
              </li>
              <li class="breadcrumb-item active">Item</li>
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
            <h3 class="card-title">Invoice Item {{ $indata->order_id }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.invoiceAddItemSave',$indata->order_id,$page],'files'=>true,'onsubmit'=>'return ChkSubAmount()'])}}
                
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                           <div class="form-group">
                              <p>Vendor : <strong>{{ $vendors[$indata->vendor_id] }}</strong></p>
                            </div>
                          </div>
                          @php
                          $vendor_code ='';
                          if(old('vendor')){
                            $vendor_code = \App\Vendor::where('id',old('vendor'))->first()->vendor_code;
                          }else{
                            $vendor_code = \App\Vendor::where('id',$indata->vendor_id)->first()->vendor_code;
                        }
                      @endphp
                          <div class="col-md-4">
                           <div class="form-group">
                             <p>Vendor Code : <strong>{{ $vendor_code }}</strong></p>
                            </div>
                          </div>

                          <div class="col-md-4">
                                 <p>Invoice Date : <strong>{{ \App\Helpers\Helper::onlyDate($indata->invoice_date) }}</strong></p>
                            </div>
                            <div class="col-md-4">
                              <p>Invoice Number : <strong>{{ $indata->invoice_number }}</strong></p>
                            </div>
                             <div class="col-md-4">
                                <p>Invoice Amount : <strong> {{ env('CURRENCY_SYMBOL') }}{{ $indata->invoice_amount }}</strong></p>
                            </div>
                              <div class="col-md-4">
                                  {!! Html::decode(link_to('public/'.$indata->invoice_file_path,\App\Helpers\Helper::getDocType($indata->invoice_file_path,$indata->po_file_type),['target'=>'_blank'])) !!}
                              </div>
                              <div class="col-md-4">
                                <p>Apex : <strong> {{ json_decode($indata->apexe_ary)->name }}</strong></p>
                            </div>
                    </div>
                    <div class="row">
                            <div class="col-md-1 srDiv">
                               <div class="form-group">
                                  {{ Form::label('Sr','Sr') }}
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::label('Item Name','Item Name') }}
                                </div>
                              </div>
                            <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::label('quantity','Quantity') }}
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::label('unit','Unit') }}
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::label('rate','Rate') }}
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::label('tax','Tax in %') }}
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::label('tax_value','Tax Value') }}
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::label('unit','Comment') }}
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::label('total','Total') }}
                                </div>
                              </div>
                              
                              <div class="col-md-1">
                               <div class="form-group">
                                  
                               </div>
                              </div>
                          </div>
                     @if($indata->item_detail)
                      @php $item=json_decode($indata->item_detail); $i=1;@endphp
                        @forelse($item as $itemKey => $itemVal)
                      
                            <div class="row Goods" id="SavGoods{{$itemKey}}">
                              <div class="row">
                                <div class="col-md-1 srDiv">
                               <div class="form-group">
                                  <p class="sr">{{$i++}}</p>
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::text('item_name[]',$itemVal->item_name,['class'=>'form-control','placeholder'=>'Item Name','required'=>true,'id'=>'']) }}
                                  <span class="text-danger">{{ $errors->first('item_name')}}</span>
                                </div>
                              </div>
                            <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('quantity[]',$itemVal->quantity,['class'=>'form-control','placeholder'=>'Quantity','required'=>true,'id'=>'quantity'.$itemKey,'onKeyUp'=>"countVal($itemKey)"]) }}
                                  <span class="text-danger">{{ $errors->first('quantity')}}</span>
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::text('unit[]',$itemVal->unit,['class'=>'form-control','placeholder'=>'Choose Unit','required'=>true]) }}
                                  <span class="text-danger">{{ $errors->first('unit')}}</span>
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('rate[]',$itemVal->rate,['class'=>'form-control','placeholder'=>'Rate','required'=>true,'id'=>'rate'.$itemKey,'onKeyUp'=>"countVal($itemKey)"]) }}
                                  <span class="text-danger">{{ $errors->first('rate')}}</span>
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('tax[]',$itemVal->tax,['class'=>'form-control','placeholder'=>'Tax','required'=>true,'id'=>'tax'.$itemKey,'onKeyUp'=>"countVal($itemKey)"]) }}
                                  <span class="text-danger">{{ $errors->first('tax')}}</span>
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('tax_value[]',$itemVal->tax_amt,['class'=>'form-control','placeholder'=>'Value','readonly'=>true,'id'=>'tax_value'.$itemKey,'onKeyUp'=>"countVal($itemKey)"]) }}
                                  <span class="text-danger">{{ $errors->first('tax_value')}}</span>
                                </div>
                              </div>

                              <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::text('price_unit[]',$itemVal->price_unit,['class'=>'form-control','placeholder'=>'Comment','required'=>true]) }}
                                  <span class="text-danger">{{ $errors->first('price_unit')}}</span>
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('total[]',$itemVal->total,['class'=>'form-control total','placeholder'=>'Total','required'=>true,'id'=>'total'.$itemKey,'readonly'=>true]) }}
                                  <span class="text-danger">{{ $errors->first('total')}}</span>
                                </div>
                              </div>
                              
                              <div class="col-md-1 ItemRemove">
                               <div class="form-group">
                                  {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger','onclick'=>"rawRemove($itemKey)"])) !!}
                               </div>
                              </div>
                              </div>
                          </div>
                        @empty
                        @endforelse
                      @endif

                      <div class="col-md-12">
                        <div class="row" id="Goods">
                          @if(empty($indata->item_detail) || $indata->item_detail=='')
                            <div class="row">
                              <div class="col-md-1 srDiv">
                               <div class="form-group">
                                  <p class="sr">1</p>
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-group">
                                  {{ Form::text('item_name[]','',['class'=>'form-control','placeholder'=>'Item Name','required'=>true,'id'=>'']) }}
                                  <span class="text-danger">{{ $errors->first('item_name')}}</span>
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('quantity[]','',['class'=>'form-control','placeholder'=>'Quantity','required'=>true,'id'=>'quantity0','onKeyUp'=>"countVal(0)"]) }}
                                  <span class="text-danger">{{ $errors->first('quantity')}}</span>
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  {{-- Form::select('unit[]',\App\PurchaseOrder::unit(),'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Unit','required'=>true]) --}}
                                  {{ Form::text('unit[]','',['class'=>'form-control','placeholder'=>'Unit','required'=>true]) }}
                                  <span class="text-danger">{{ $errors->first('unit')}}</span>
                                </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('rate[]','',['class'=>'form-control','placeholder'=>'Rate','required'=>true,'id'=>'rate0','onKeyUp'=>"countVal(0)"]) }}
                                  <span class="text-danger">{{ $errors->first('rate')}}</span>
                                </div>
                              </div>
                               <div class="col-md-1">
                                 <div class="form-group">
                                    {{ Form::number('tax[]','',['class'=>'form-control','placeholder'=>'Tax in %','required'=>true,'id'=>'tax0','onKeyUp'=>"countVal(0)"]) }}
                                    <span class="text-danger">{{ $errors->first('tax')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-1">
                                 <div class="form-group">
                                    {{ Form::number('tax_value[]','',['class'=>'form-control','placeholder'=>'Value','readonly'=>true,'id'=>'tax_value0','onKeyUp'=>"countVal(0)"]) }}
                                    <span class="text-danger">{{ $errors->first('tax_value')}}</span>
                                  </div>
                              </div>
                               <div class="col-md-2">
                                 <div class="form-group">
                                    {{-- Form::select('price_unit[]',\App\PurchaseOrder::unit(),'',['class'=>'form-control custom-select select2','placeholder'=>'Price unit','required'=>true]) --}}
                                    {{ Form::text('price_unit[]','',['class'=>'form-control','placeholder'=>'Comment']) }}
                                    <span class="text-danger">{{ $errors->first('price_unit')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-1">
                               <div class="form-group">
                                  {{ Form::number('total[]','',['class'=>'form-control total','placeholder'=>'Total','required'=>true,'id'=>'total0','readonly'=>true]) }}
                                  <span class="text-danger">{{ $errors->first('total')}}</span>
                                </div>
                              </div>
                            </div>
                          @endif
                        
                      </div>
                      <div class="col-md-12 text-right">
                          {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                         
                        </div>
                    
                  
                </div>
              <!-- /.row -->
                <div class="card-footer">
                  <p class="text-danger" id="amtAlrtMsg"></p>
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
  function rawRemove(a){
    $('#SavGoods'+a).remove();
    var sum = 0;
    $("input[class *= 'total']").each(function(){
        sum += +$(this).val();
    });
    var discount = $('#discount').val();
    $(".net_payable").val(sum-discount);
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }
  $('.trash').click(function(){
      var cls = $('.Goods').length;
      if (cls == 1) {
        $('.trash').hide();
      }
      $('.Goods').last().remove();
  });
  $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-1 srDiv"><p class="sr">'+sr+'</p></div><div class="col-md-1"><div class="form-group"> <input class="form-control" placeholder="Item Name" required="" id="" name="item_name[]" type="text" value=""> <span class="text-danger"></span></div></div> <div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Quantity" required name="quantity[]" type="number" value="" min="0" id="quantity'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" name="unit[]" required placeholder="Unit"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Rate" name="rate[]" type="number" value="" required min="0" id="rate'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"><input class="form-control" placeholder="Tax" name="tax[]" type="number" value="" required min="0" id="tax'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"> <input class="form-control" placeholder="Value" name="tax_value[]" type="number" value="" readonly min="0" id="tax_value'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"><input type="text" class="form-control" name="price_unit[]" required placeholder="Comment"> <span class="text-danger"></span> </div></div><div class="col-md-1"> <div class="form-group"><input class="form-control total" placeholder="Total" name="total[]" type="number" value="" required min="0" id="total'+cls+'" readonly> <span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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

  function ChkSubAmount() {
    var invoiveAmt='{{ $indata->invoice_amount }}';
    var sum = 0;
    $("input[class *= 'total']").each(function(){
        sum += +$(this).val();
    });
    if (invoiveAmt < sum) {
      $('#amtAlrtMsg').text('Item amount should be equel or less than invoice amount');
      return false;
    }else{
      return true;
    }
  }
</script>
@endsection