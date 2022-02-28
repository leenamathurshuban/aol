@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Invoice {{ $po->order_id }}</h1>
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
            <h3 class="card-title">Edit Invoice {{ $po->order_id }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
           
            {{ Form::open(['route'=>['employee.updatePendingInvoiceSave',$indata->order_id,$page],'files'=>true])}}
                
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
                        <div class="col-md-3">
                          <p>PO Start Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($po->po_start_date) ?? '' }}</strong></p>
                      </div>
                      <div class="col-md-3">
                           <p>PO End Date: <br><strong>{{ \App\Helpers\Helper::onlyDate($po->po_end_date) ?? '' }}</strong></p>
                      </div>
                        <div class="col-md-3">
                          <p>PO Amount: <br><strong>{{ env('CURRENCY_SYMBOL').''.$poNetAmt ?? '0' }}</strong></p>
                        </div>
                       {{-- <div class="col-md-3">
                          <p>PO Maximum Invoice Limit: <br><strong>{{ env('CURRENCY_SYMBOL')}}{{ \App\Invoice::invoiceLimit($po->net_payable) ?? '' }}</strong></p>
                        </div>--}}

                        <div class="col-md-3">
                          <p>Approved Invoice: <br><strong>{{ env('CURRENCY_SYMBOL').''.$invc }}</strong></p>
                        </div>
                        <div class="col-md-3">
                          <p>Invoice in Process: <br><strong>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::proccessPoInvoice($po->id) }}</strong></p>
                        </div>
                        <div class="col-md-3">
                          <p>PO Balance: <br><strong>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::poBalance($po->id) }}</strong></p>
                        </div>
                    </div>
                      <div class="col-md-12">
                         <div class="row">
                            <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Invoice Date','Invoice Date') }}
                                  {{ Form::date('invoice_date',$indata->invoice_date,['class'=>'form-control invoice_date','placeholder'=>'Invoice Date','required'=>true,'min'=>$po->po_start_date,'max'=>$po->po_end_date]) }}
                                  <span class="text-danger">{{ $errors->first('invoice_date.*')}}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('Invoice Number','Invoice Number') }}
                                {{ Form::text('invoice_number',$indata->invoice_number,['class'=>'form-control','placeholder'=>'Invoice Number','required'=>true,'id'=>'']) }}
                                <span class="text-danger">{{ $errors->first('invoice_number')}}</span>
                              </div>
                            </div>
                             <div class="col-md-4">
                             <div class="form-group">
                                {{ Form::label('Advance_payment','Advance Payment') }}
                                {{ Form::select('advance_payment_mode',['Yes'=>'Yes','No'=>'No'],$indata->advance_payment_mode,['class'=>'form-control custom-select select2','placeholder'=>'Advance Payment','required'=>true,'id'=>'']) }}
                                <span class="text-danger">{{ $errors->first('advance_payment_mode')}}</span>
                              </div>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Amount','Amount') }}
                                  {{ Form::number('amount',$indata->amount,['class'=>'form-control','placeholder'=>'Amount','required'=>true,'id'=>'amount','onKeyUp'=>"countVal()"]) }}
                                  <span class="text-danger">{{ $errors->first('amount.*')}}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Tax','Tax') }}
                                  {{ Form::number('tax',$indata->tax,['class'=>'form-control','placeholder'=>'tax','required'=>true,'id'=>'tax','onKeyUp'=>"countVal()"]) }}
                                  <span class="text-danger">{{ $errors->first('tax')}}</span>
                                </div>
                            </div>
                             <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('Invoice Amount','Invoice Amount') }}
                                  {{ Form::number('invoice_amount',$indata->invoice_amount,['class'=>'form-control','placeholder'=>'Invoice Amount','readonly'=>true,'id'=>'total']) }}
                                  <span class="text-danger">{{ $errors->first('invoice_amount')}}</span>
                                </div>
                            </div>
                             <div class="col-md-4">
                               <div class="form-group">
                                  {{ Form::label('file','Invoice Image') }}
                                  {{ Form::file('image',['class'=>'form-control total']) }}
                                </div>
                              </div>
                             
                              <div class="col-md-4">
                                 <div class="form-group">
                                    {{ Form::label('Apex','Apex') }}
                                    {{ Form::select('apex',$apexes,$indata->apexe_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                                    <span class="text-danger">{{ $errors->first('apex')}}</span>
                                  </div>
                                </div>
                                 <div class="col-md-4">
                                   <div class="form-group">
                                      {!! Html::decode(link_to('public/'.$indata->invoice_file_path,\App\Helpers\Helper::getDocType($indata->invoice_file_path,$indata->po_file_type),['target'=>'_blank'])) !!}
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
   function countVal() {
    var amount =$('#amount').val();
    var tax =$('#tax').val();
    var charge=$('#amount').val()*$('#tax').val()/100;
    var tot=parseInt(charge)+parseInt(amount);
    $('#total').val(tot);
  }
</script>
@endsection