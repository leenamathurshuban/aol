@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Invoice {{ $data->invoice_number }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingWithoutPoInvoice','Without PO Invoice',[],[])}}
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
            <h3 class="card-title">Edit Invoice {{ $data->invoice_number }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.updatePendingWithoutPoInvoiceSave',$data->order_id,$page],'files'=>true])}}
                
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
                    </div>
                     <div class="row">
                      <div class="col-md-12">
                        
                         @forelse ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                            @empty
                        @endforelse
                      </div>
                      <div class="col-md-12">
                         
                        
                         
                       <div class="row">
                            <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Invoice Date','Invoice Date') }}
                                  {{ Form::date('invoice_date',$data->invoice_date,['class'=>'form-control','placeholder'=>'Invoice Date','required'=>true,'id'=>'','max'=>date('Y-m-d')]) }}
                                  <span class="text-danger">{{ $errors->first('invoice_date.*')}}</span>
                                </div>
                            </div>
                           {{-- <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('Advance_payment','Advance Payment') }}
                                {{ Form::select('advance_payment_mode',['Yes'=>'Yes','No'=>'No'],$data->advance_payment_mode,['class'=>'form-control custom-select select2','placeholder'=>'Advance Payment','required'=>true,'id'=>'']) }}
                                <span class="text-danger">{{ $errors->first('advance_payment_mode.*')}}</span>
                              </div>
                            </div>--}}
                            <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('Invoice Number','Invoice Number') }}
                                {{ Form::text('invoice_number',$data->invoice_number,['class'=>'form-control','placeholder'=>'Invoice Number','required'=>true,'id'=>'']) }}
                                <span class="text-danger">{{ $errors->first('invoice_number.*')}}</span>
                              </div>
                            </div>
                             <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Amount','Amount') }}
                                  {{ Form::number('amount',$data->amount,['class'=>'form-control','placeholder'=>'Amount','required'=>true,'id'=>'amount','onKeyUp'=>"countVal()"]) }}
                                  <span class="text-danger">{{ $errors->first('amount.*')}}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Tax','Tax') }}
                                  {{ Form::number('tax',$data->tax,['class'=>'form-control','placeholder'=>'tax','required'=>true,'id'=>'tax','onKeyUp'=>"countVal()"]) }}
                                  <span class="text-danger">{{ $errors->first('tax.*')}}</span>
                                </div>
                            </div>
                             <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Invoice Amount','Invoice Amount') }}
                                  {{ Form::number('invoice_amount',$data->invoice_amount,['class'=>'form-control','placeholder'=>'Invoice Amount','readonly'=>true,'id'=>'total']) }}
                                  <span class="text-danger">{{ $errors->first('invoice_amount.*')}}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('Apex','Apex') }}
                                {{ Form::select('apex',$apexes,$data->apexe_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                                <span class="text-danger">{{ $errors->first('apex')}}</span>
                              </div>
                          </div>
                             <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('file','Invoice Image') }}
                                  {{ Form::file('image',['class'=>'form-control total']) }}
                                </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                  <img src="{{ url('public/'.$data->invoice_file_path) }}" alt="user" class="img-fluit edit-product-img" style="width: 70px;height: 70px;" />
                                </div>
                              </div>
                          </div>
                       
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
  });

</script>

<script type="text/javascript">
   function countVal() {
    var amount =$('#amount').val();
    var tax =$('#tax').val();
    var charge=$('#amount').val()*$('#tax').val()/100;
    var tot=parseInt(charge)+parseInt(amount);
    $('#total').val(tot);
  }

</script>
 @endsection