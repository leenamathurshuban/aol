@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase Order {{ $data->order_id }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('employee.home','Home',[],[])}}
              </li>
               <li class="breadcrumb-item">
                {{link_to_route('employee.pendingPO','Purchase Order',[],[])}}
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
            <h3 class="card-title">Edit Purchase Order {{ $data->order_id }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.updatePO',$data->order_id,$page],'files'=>true])}}
                  <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('vendor','Vendor') }}
                              {!!Form::select('vendor', $vendors, $data->vendor_id, ['placeholder' => 'Vendor','class'=>'form-control custom-select select2','id'=>'vendor'])!!}
                              <span class="text-danger">{{ $errors->first('vendor')}}</span>
                            </div>
                          </div>
                          @php
                          $vendor_code ='';
                          if(old('vendor')){
                            $vendor_code = \App\Vendor::where('id',old('vendor'))->first()->vendor_code;
                          }else{
                            $vendor_code = \App\Vendor::where('id',$data->vendor_id)->first()->vendor_code;
                        }
                      @endphp
                          <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('Vendor Code','Vendor Code') }}
                              {{ Form::text('vendor_code',$vendor_code,['class'=>'form-control','placeholder'=>'Vendor Code','readonly'=>true,'id'=>'vCode']) }}
                              <span class="text-danger">{{ $errors->first('vendor_code')}}</span>
                            </div>
                          </div>
                           <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('po_start_date','Start Date') }}
                              {{ Form::date('po_start_date',$data->po_start_date,['class'=>'form-control','placeholder'=>'Start Date','max'=>'']) }}
                              <span class="text-danger">{{ $errors->first('po_start_date')}}</span>
                            </div>
                          </div>

                          <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('po_end_date','End Date') }}
                              {{ Form::date('po_end_date',$data->po_end_date,['class'=>'form-control','placeholder'=>'End Date','max'=>'']) }}
                              <span class="text-danger">{{ $errors->first('po_end_date')}}</span>
                            </div>
                          </div>

                          <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('payment_method','Payment Method') }}
                              {{ Form::select('payment_method',\App\PurchaseOrder::paymentMethod(),$data->payment_method,['class'=>'form-control custom-select select2','placeholder'=>'Payment Method']) }}
                              <span class="text-danger">{{ $errors->first('payment_method')}}</span>
                            </div>
                          </div>
                         

                          <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('nature_of_service','Nature Of Goods') }}
                              {{ Form::select('nature_of_service',\App\PurchaseOrder::natureOfService(),$data->nature_of_service,['class'=>'form-control custom-select select2','placeholder'=>'Nature Of Goods','id'=>"chkNature"]) }}
                              <span class="text-danger">{{ $errors->first('nature_of_service')}}</span>
                            </div>
                          </div>
                          <div class="col-md-6">
                             <div class="form-group">
                                {{ Form::label('Apex','Apex') }}
                                {{ Form::select('apex',$apexes,$data->apexe_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                                <span class="text-danger">{{ $errors->first('apex')}}</span>
                              </div>
                            </div>
                          @php
                          $none = 'display:none';
                            if((old('nature_of_service')!='Goods' && old('nature_of_service') || $data->nature_of_service!='Goods')){
                              $none = '';
                            }
                          @endphp
                         
                          <div class="col-md-12" id="Services" style="{{$none}}">
                           <div class="form-group">
                              {{ Form::label('service_detail','Service Detail') }}
                              {{ Form::textarea('service_detail',$data->service_detail,['class'=>'form-control','placeholder'=>'Service Detail','rows'=>5]) }}
                              <span class="text-danger">{{ $errors->first('service_detail')}}</span>
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
                                  {{ Form::label('tax','Tax') }}
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::label('unit','Comment') }}
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  {{ Form::label('total','Total') }}
                                </div>
                              </div>
                              
                              <div class="col-md-1">
                               <div class="form-group">
                                  
                               </div>
                              </div>
                          </div>
                          @if($data->item_detail)
                              @php $item=json_decode($data->item_detail); @endphp
                                @forelse($item as $itemKey => $itemVal)
                              
                                    <div class="row" id="SavGoods{{$itemKey}}">
                                       <div class="col-md-2">
                                       <div class="form-group">
                                          {{ Form::label('Item Name','Item Name') }}
                                          {{ Form::text('item_name[]',$itemVal->item_name,['class'=>'form-control','placeholder'=>'Item Name','required'=>true,'id'=>'']) }}
                                          <span class="text-danger">{{ $errors->first('item_name')}}</span>
                                        </div>
                                      </div>
                                    <div class="col-md-1">
                                       <div class="form-group">
                                          {{ Form::label('quantity','Quantity') }}
                                          {{ Form::number('quantity[]',$itemVal->quantity,['class'=>'form-control','placeholder'=>'Quantity','required'=>true,'id'=>'quantity'.$itemKey,'onKeyUp'=>"countVal($itemKey)"]) }}
                                          <span class="text-danger">{{ $errors->first('quantity')}}</span>
                                        </div>
                                      </div>
                                      <div class="col-md-2">
                                       <div class="form-group">
                                          {{ Form::label('unit','Unit') }}
                                          {{ Form::text('unit[]',$itemVal->unit,['class'=>'form-control','placeholder'=>'Choose Unit','required'=>true]) }}
                                          <span class="text-danger">{{ $errors->first('unit')}}</span>
                                        </div>
                                      </div>
                                      <div class="col-md-2">
                                       <div class="form-group">
                                          {{ Form::label('rate','Rate') }}
                                          {{ Form::number('rate[]',$itemVal->rate,['class'=>'form-control','placeholder'=>'Rate','required'=>true,'id'=>'rate'.$itemKey,'onKeyUp'=>"countVal($itemKey)"]) }}
                                          <span class="text-danger">{{ $errors->first('rate')}}</span>
                                        </div>
                                      </div>
                                      <div class="col-md-2">
                                       <div class="form-group">
                                          {{ Form::label('unit','Comment') }}
                                          {{ Form::text('price_unit[]',$itemVal->price_unit,['class'=>'form-control','placeholder'=>'Comment','required'=>true]) }}
                                          <span class="text-danger">{{ $errors->first('price_unit')}}</span>
                                        </div>
                                      </div>
                                      <div class="col-md-2">
                                       <div class="form-group">
                                          {{ Form::label('total','Total') }}
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
                                @empty
                                @endforelse
                              @endif

                              <div class="col-md-12">
                                <div class="row" id="Goods">
                                </div>
                                <div class="col-md-12 text-right">
                                  
                                  {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                                  
                                </div>
                              </div>
                              <table class="table">
                                <tr>
                                  <td width="80%" class="text-right"> {{ Form::label('discount','Discount') }}</td>
                                  <td>{{ Form::number('discount',$data->discount,['class'=>'form-control discount','placeholder'=>'Discount','min'=>'0','onKeyUp'=>"countVal(0)"]) }}
                                    <span class="text-danger">{{ $errors->first('discount')}}</span></td>
                                </tr>
                                 <tr>
                                  <td width="80%" class="text-right">{{ Form::label('net_payable','Net Payable') }}</td>
                                  <td> {{ Form::number('net_payable',$data->net_payable,['class'=>'form-control net_payable','placeholder'=>'Net Payable','readonly'=>true]) }}
                                    <span class="text-danger">{{ $errors->first('net_payable')}}</span></td>
                                </tr>
                              </table>
                         
                          @if(Auth::guard('employee')->user()->role_id==5)
                          <div class="col-md-6">
                           <div class="form-group">
                              {{ Form::label('advance_tds','Advance TDS on purchase of Goods') }}
                              {{ Form::select('advance_tds',['Yes'=>'Yes','No'=>'No'],$data->advance_tds,['class'=>'form-control custom-select select2','placeholder'=>'Advance TDS']) }}
                              <span class="text-danger">{{ $errors->first('advance_tds')}}</span>
                            </div>
                          </div>
                          @endif
                        </div>
                        <div class="col-md-12">
                          <h3>Saved Files</h3>
                            <div class="row savedFile">
                              @forelse($data->poImage as $key => $val)
                              <div class="col-md-2">
                                <div class="savedimg_box">
                                  {!! Html::decode(link_to('public/'.$val->po_file_path,\App\Helpers\Helper::getDocType($val->po_file_path,$val->po_file_type),['target'=>'_blank','data-toggle'=>'tooltip','data-placement'=>'top','title'=>$val->po_file_description])) !!}
                                {!! Html::decode(link_to_route('employee.POPendIMG','<i class="fa fa-trash-alt" aria-hidden="true"></i>',$val->id,['class'=>'btn btn-danger'])) !!}
                                </div>
                              </div>
                            @empty
                            <p><strong>Files not found.</strong></p>
                            @endforelse
                            </div>
                        </div>
                        <div class="row imgSection">
                          <div class="col-md-3" id="IMAGESEC">
                              <div class="form-group">
                                {!!Form::label('file', 'Attachments')!!}
                                   {!!Form::file('po_file[]',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                                @if($errors->has('po_file'))
                                    <p class="text-danger">{{$errors->first('po_file')}}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                {!!Form::label('description', 'Attachments Description')!!}
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
                    </div>
                  </div>
                 <!--  <button class="btn btn-danger"><i class="fa fa-minus"></i></button> -->
                  <!-- /.col  -->
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
    var clone='<div class="col-md-3 IMGRow"><div class="form-group"> <label for="file">Attachments Description</label> <input class="dropify form-control" data-default-file="" id="input-file-now-custom-1" name="po_file[]" type="file" required> </div> <div class="form-group"> <label for="description">Description</label> <textarea class="form-control" rows="3" name="po_file_description[]" cols="50" placeholder="Description about attachment file"></textarea> </div></div>';
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
  function rawRemove(a){
    $('#SavGoods'+a).remove();
    var sum = 0;
    $("input[class *= 'total']").each(function(){
        sum += +$(this).val();
    });
    var discount = $('#discount').val();
    $(".net_payable").val(sum-discount);
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
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"> <div class="col-md-2"><div class="form-group"> <label for="Item Name">Item Name</label> <input class="form-control" placeholder="Item Name" required="" id="" name="item_name[]" type="text" value=""> <span class="text-danger"></span></div></div><div class="col-md-1"> <div class="form-group"> <label for="quantity">Quantity</label> <input class="form-control" placeholder="Quantity" required name="quantity[]" type="number" value="" min="0" id="quantity'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"> <label for="unit">Unit</label> <input type="text" class="form-control" name="unit[]" required placeholder="Unit"> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"> <label for="rate">Rate</label> <input class="form-control" placeholder="Rate" name="rate[]" type="number" value="" required min="0" id="rate'+cls+'" onKeyUp="countVal('+cls+')"> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"> <label for="unit">Comment</label> <input type="text" class="form-control" name="price_unit[]" required placeholder="Comment"> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group">  <label for="total">Total</label> <input class="form-control total" placeholder="Total" name="total[]" type="number" value="" required min="0" id="total'+cls+'" readonly> <span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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
  $('[data-toggle="tooltip"]').tooltip();
</script>
 @endsection