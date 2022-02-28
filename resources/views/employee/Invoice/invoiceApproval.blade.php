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

            {{ Form::open(['route'=>['employee.changeInvoiceActStatus',$data->order_id,$page],'files'=>true,'onSubmit'=>'return cheackAmount()'])}}
                
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
                            <th>Tax</th>
                            <th>Tax</th>
                            <th>Total</th>
                            <th>Image</th>
                          </tr>
                          @php $itemKey=$data->id ?? 0; @endphp
                            <tr>
                              <td>{{ date('d M Y',strtotime($data->invoice_date)) }}</td>
                              <td>{{$data->invoice_number}}</td>
                              <td>{{ env('CURRENCY_SYMBOL') }}<span class="amt">{{$data->amount}}</span></td>
                              <td>{{$data->tax}}%</td>
                              <td>{{ env('CURRENCY_SYMBOL') }}<span class="tax_amount">{{$data->tax_amount}}</span></td>
                              <td>{{ env('CURRENCY_SYMBOL') }}{{$data->invoice_amount}}</td>
                               <td>
                                   {!! Html::decode(link_to('public/'.$data->invoice_file_path,\App\Helpers\Helper::getDocType($data->invoice_file_path,$data->po_file_type),['target'=>'_blank'])) !!}
                              </td>
                            </tr>
                            <tr>
                              <td colspan="7">
                                <div class="col-md-12">
                                @if(Auth::guard('employee')->user()->role_id==5 && $data->invoice_status==1)
                                  <div class="row">
                                    <div class="col-md-6">
                                      <label>Status</label>
                                      {{ Form::hidden('invoice_id',$data->id)}}
                                      {!! Form::select('invoice_status',\App\Invoice::invoiceStatusChange(),[],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'inv_status'.$data->id,'onchange'=>"chkReq($data->id)",'placeholder'=>'Invoice Status','required'=>true])!!}
                                      <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                                    </div>
                                    <div class="col-md-6">
                                      <label>Comment</label>
                                      {{ Form::textarea('invoice_status_comment','',['class'=>'form-control textareaCustom','rows'=>'2','placeholder'=>'Comment here','id'=>'status_cmt_'.$data->id])}}
                                      <span class="text-danger" id="span{{$data->id}}">{{ $errors->first('invoice_status_comment') }}</span>
                                    </div>
                                  </div>
                                @elseif(Auth::guard('employee')->user()->role_id==7 && $data->invoice_status==4)
                                  <div class="row">
                                    <div class="col-md-6">
                                      <label>Status</label>
                                      {{ Form::hidden('invoice_id',$data->id)}}
                                        {!! Form::select('invoice_status',\App\Invoice::invoiceStatusChange(),[],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'inv_status'.$data->id,'onchange'=>"chkReq($data->id)",'placeholder'=>'Invoice Status','required'=>true])!!}
                                        <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                                    </div>
                                    <div class="col-md-6">
                                      <label>Comment</label>
                                      {{ Form::textarea('invoice_status_comment','',['class'=>'form-control textareaCustom','rows'=>'2','placeholder'=>'Comment here','id'=>'status_cmt_'.$data->id])}}
                                      <span class="text-danger" id="span{{$data->id}}">{{ $errors->first('invoice_status_comment') }}</span>
                                    </div>
                                  </div>
                                @elseif(Auth::guard('employee')->user()->role_id==9 && $data->invoice_status==3)
                                  <div class="row">
                                    <div class="col-md-4">
                                      <label>Specify Person</label>
                                      {{ Form::select('specified_person',['Yes'=>'Yes','No'=>'No'],'',['class'=>'form-control custom-select select2','placeholder'=>'Choose','style'=>'width:100%']) }}
                                        <span class="text-danger">{{ $errors->first('specified_person')}}</span>
                                    </div>
                                    <div class="col-md-4">
                                      <label>Status</label>
                                      {{ Form::hidden('invoice_id[]',$data->id)}}
                                        {!! Form::select('invoice_status',\App\Invoice::invoiceStatusChange(),[],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'inv_status'.$data->id,'onchange'=>"chkReq($data->id)",'placeholder'=>'Invoice Status','required'=>true])!!}
                                        <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                                    </div>
                                    <div class="col-md-4">
                                      <label>Comment</label>
                                      {{ Form::textarea('invoice_status_comment','',['class'=>'form-control textareaCustom','rows'=>'2','placeholder'=>'Comment here','id'=>'status_cmt_'.$data->id])}}
                                      <span class="text-danger" id="span{{$data->id}}">{{ $errors->first('invoice_status_comment') }}</span>
                                    </div>
                                    @php
                                      $dataTds=$data->tds ?? '0';
                                      $tds_amount=$data->tds_amount ?? '0';
                                      $tds_month=($data->tds_month) ? $data->tds_month : '';
                                       $tds_payable=($data->invoice_amount-$tds_amount);
                                    @endphp
                                    <div class="col-md-4">
                                      <label>TDS ( % )</label>
                                      {{ Form::number('tds',$dataTds,['class'=>'form-control tds','placeholder'=>'TDS %','onkeyup'=>"chlAmt()",'required'=>true,'min'=>0]) }}
                                        <span class="text-danger">{{ $errors->first('tds')}}</span>
                                    </div>
                                    <div class="col-md-4">
                                      {{ Form::label('TDS Section:','TDS Section:') }}
                                      {{-- Form::select('tds_month',\App\Invoice::tdsMonth(),$tds_month,['class'=>'form-control custom-select select2 tds_amt'.$itemKey,'placeholder'=>'Choose Section']) --}}
                                      {{ Form::text('tds_month',$tds_month,['class'=>'form-control','placeholder'=>'TDS Section']) }}
                                      
                                    </div>
                                    <div class="col-md-4">
                                      {{ Form::label('TDS Amount:','TDS Amount:') }}
                                      {{ Form::number('tds_amt',$tds_amount,['class'=>'form-control tds_amt','readonly'=>true]) }}
                                    </div>
                                    <div class="col-md-4">
                                      {{ Form::label('Net Payable:','Net Payable:') }}
                                      {{ Form::number('tds_payable',$tds_payable,['class'=>'form-control tds_payable','readonly'=>true]) }}
                                    </div>
                                  </div>
                                @elseif(Auth::guard('employee')->user()->role_id==10 && $data->invoice_status==5)
                                  <div class="row">
                                    <div class="col-md-6">
                                       <label>Status</label>
                                        {{ Form::hidden('invoice_id',$data->id)}}
                                          {!! Form::select('invoice_status',\App\Invoice::invoiceStatusChange(),[],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'inv_status'.$data->id,'onchange'=>"chkReq($data->id)",'placeholder'=>'Invoice Status','required'=>true])!!}
                                          <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                                    </div>
                                    <div class="col-md-6">
                                       <label>Comment</label>
                                        {{ Form::textarea('invoice_status_comment','',['class'=>'form-control textareaCustom','rows'=>'2','placeholder'=>'Comment here','id'=>'status_cmt_'.$data->id])}}
                                        <span class="text-danger" id="span{{$data->id}}">{{ $errors->first('invoice_status_comment') }}</span>
                                    </div>
                                  </div>
                                  @elseif(Auth::guard('employee')->user()->role_id==11 && $data->invoice_status==6)
                                    <div class="row">
                                      <div class="col-md-6">
                                        <label>Status</label>
                                        {{ Form::hidden('invoice_id',$data->id)}}
                                          {!! Form::select('invoice_status',\App\Invoice::invoiceStatusChange(),[],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'inv_status'.$data->id,'onchange'=>"chkReq($data->id)",'placeholder'=>'Invoice Status','required'=>true])!!}
                                          <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                                      </div>
                                      <div class="col-md-6">
                                        <label>Comment</label>
                                        {{ Form::textarea('invoice_status_comment','',['class'=>'form-control textareaCustom','rows'=>'2','placeholder'=>'Comment here','id'=>'status_cmt_'.$data->id])}}
                                        <span class="text-danger" id="span{{$data->id}}">{{ $errors->first('invoice_status_comment.*') }}</span>
                                      </div>
                                    </div>
                                @else
                                    <div class="row">
                                      <div class="col-md-12">
                                        {{ \App\Invoice::invoiceStatus($data->invoice_status)}}
                                      </div>
                                    </div>
                                @endif
                                </div>
                              </td>
                            </tr>
                            @if(Auth::guard('employee')->user()->role_id==9)
                            <tr>
                              <td colspan="7">
                                @php $bnkitem=[];@endphp
                                 @if($data->form_by_account)
                                    @php $bnkitem=json_decode($data->form_by_account); @endphp
                                  @endif
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      {{ Form::label('Bank Account','Bank Account') }}
                                       {{-- Form::text('bank_account',$bnkitem->bank_account ?? '',['class'=>'form-control','placeholder'=>'Bank Account','id'=>'']) --}}
                                       {{ Form::select('bank_account',\App\BankAccount::bnkHeadOfcPluck(),$bnkitem->bank_account ?? '',['class'=>'form-control custom-select select2 bank_account_data','placeholder'=>'Bank Account','id'=>'bank_account_data'.$data->id,'data'=>$data->id]) }}
                                       
                                      <span class="text-danger">{{ $errors->first('bank_account')}}</span>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      {{ Form::label('IFSC','IFSC') }}
                                      {{ Form::text('ifsc',$bnkitem->ifsc ?? '',['class'=>'form-control','placeholder'=>'IFSC','id'=>'ifsc_data'.$data->id]) }}
                                      <span class="text-danger">{{ $errors->first('ifsc')}}</span>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      {{ Form::label('Bank Name','Bank Name') }}
                                          {{ Form::text('bank_name',$bnkitem->bank_name ?? '',['class'=>'form-control','placeholder'=>'Bank Name','id'=>'bank_name_data'.$data->id]) }}
                                          <span class="text-danger">{{ $errors->first('bank_name')}}</span>
                                    </div>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            @endif
                            <tr>
                              <td colspan="7">
                                 <!--  -->
                                 @if($itemKey==0 && Auth::guard('employee')->user()->role_id==9)
                                  <div class="col-md-12">
                                    <div class="row">
                                       <div class="col-md-3">
                                         <div class="form-group">
                                              {{ Form::label('Debit account','Debit account',['class'=>'sr']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                         <div class="form-group">
                                              {{ Form::label('Amount','Amount') }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                         <div class="form-group">
                                              {{ Form::label('Cost Center','Cost Center') }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                         <div class="form-group">
                                              {{ Form::label('Category','Category') }}
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  @endif
                                 @if(Auth::guard('employee')->user()->role_id==9)
                                      @if($data->form_by_account)
                                            @php $item=json_decode($data->form_by_account); @endphp
                                            @forelse($item->form_by_account as $acc_itemKey => $acc_itemVal)
                                          
                                              <div class="row" id="SavGoods{{$acc_itemKey.$data->id}}">
                                                 <div class="col-md-3">
                                                   <div class="form-group">
                                                        
                                                        {{-- Form::text('debit_account[]',$acc_itemVal->debit_account,['class'=>'form-control','placeholder'=>'Debit account','required'=>true,'id'=>'']) --}}
                                                        {{Helper::debitAccount($acc_itemVal->debit_account)}}
                                                        <span class="text-danger">{{ $errors->first('debit_account.*')}}</span>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                   <div class="form-group">
                                                       
                                                        {{ Form::number('amount[]',$acc_itemVal->amount,['class'=>'form-control debit_amt','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
                                                        <span class="text-danger">{{ $errors->first('amount.*')}}</span>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                   <div class="form-group">
                                                        
                                                        {{-- Form::text('cost_center[]',$acc_itemVal->cost_center,['class'=>'form-control','placeholder'=>'Cost Center','required'=>true,'id'=>'']) --}}
                                                         {{Helper::costCenter($acc_itemVal->cost_center)}}
                                                        <span class="text-danger">{{ $errors->first('cost_center.*')}}</span>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-2">
                                                   <div class="form-group">
                                                       {{-- Form::text('category[]',$acc_itemVal->category,['class'=>'form-control','placeholder'=>'Category','required'=>true,'id'=>'']) --}}
                                                       {{Helper::category($acc_itemVal->category)}}
                                                        <span class="text-danger">{{ $errors->first('category.*')}}</span>
                                                      </div>
                                                  </div>
                                                  
                                                <div class="col-md-1 ItemRemove">
                                                 <div class="form-group">
                                                    {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger','onclick'=>"rawRemove($acc_itemKey,$data->id)"])) !!}
                                                 </div>
                                                </div>
                                                  
                                              </div>
                                            @empty
                                            @endforelse
                                        @endif
                                    <div class="col-md-12">
                                      @if($data->form_by_account=='')
                                        <div class="row">
                                         <div class="col-md-3">
                                           <div class="form-group">
                                                 {{-- Form::text('debit_account[]','',['class'=>'form-control','placeholder'=>'Debit account','required'=>true,'id'=>'']) --}}
                                                 {{Helper::debitAccount('')}}
                                                <span class="text-danger">{{ $errors->first('debit_account')}}</span>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                           <div class="form-group">
                                                {{ Form::number('amount[]','',['class'=>'form-control debit_amt','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
                                                <span class="text-danger">{{ $errors->first('amount')}}</span>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                           <div class="form-group">
                                                {{-- Form::text('cost_center[]','',['class'=>'form-control','placeholder'=>'Cost Center','required'=>true,'id'=>'']) --}}
                                                {{Helper::costCenter('')}}
                                                <span class="text-danger">{{ $errors->first('cost_center')}}</span>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                           <div class="form-group">
                                                 {{-- Form::text('category[]','',['class'=>'form-control','placeholder'=>'Category','required'=>true,'id'=>'']) --}}
                                                 {{Helper::category('')}}
                                                <span class="text-danger">{{ $errors->first('category')}}</span>
                                              </div>
                                          </div>
                                          
                                      </div>
                                      @endif
                                      <div id="Goods{{$data->id}}">
                                      </div>
                                      <div class="col-md-12 text-right">
                                        {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus','data-id'=>$data->id])) !!}
                                      </div>
                                    </div>
                                 @else
                                    @if($data->form_by_account)
                                      @php $item=json_decode($data->form_by_account); @endphp
                                      <div class="col-md-12">
                                        <table width="100%" class="table">
                                          <tr>
                                            <td><strong>Bank Account</strong><p>{{$item->bank_account}}</p></td>
                                             <td><strong>IFSC</strong><p>{{$item->ifsc}}</p></td>
                                             <td><strong>Bank Name</strong><p>{{$item->bank_name}}</p></td>
                                          </tr>
                                          <tr>
                                            <td colspan="2"><strong>Transaction Id</strong><p>{{$data->transaction_id ?? ''}}</p></td>
                                             <td><strong>Transaction Date</strong><p>{{$data->transaction_date ?? ''}}</p></td>
                                          </tr>
                                        </table>
                                        <table class="table">
                                          <tr>
                                            <th>Sr.</th>
                                            <th>Debit Account</th>
                                            <th>Amount</th>
                                            <th>Cost Center</th>
                                            <th>Category</th>
                                          </tr>
                                          @forelse($item->form_by_account as $itemKey => $acc_itemVal)
                                              <tr>
                                              <td>{{++$itemKey}}</td>
                                              <td>{{$acc_itemVal->debit_account}}</td>
                                              <td>{{ env('CURRENCY_SYMBOL') }}{{$acc_itemVal->amount}}
                                              {{ Form::hidden('amount[]',$acc_itemVal->amount,['class'=>'form-control debit_amt','placeholder'=>'Amount','id'=>'']) }}
                                            </td>
                                              <td>{{$acc_itemVal->cost_center}}</td>
                                              <td>{{$acc_itemVal->category}}</td>
                                            </tr>
                                          @empty
                                          @endforelse
                                        </table>
                                      </div>
                                    @endif
                                 @endif   
                                <!--  --> 
                              </td>
                            </tr>
                        </table>
                      </div>
                    </div>
                  
                </div>
              <!-- /.row -->
                <div class="card-footer">
                  <p class="text-danger subAlert"></p>
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
@php $log_role = Auth::guard('employee')->user()->role_id; @endphp
<script type="text/javascript">
  function chlAmt() {
    var amt='{{ $data->amount }}';//$('.amt').text();
    var tds=$('.tds').val();
    var tax_amount='{{ $data->invoice_amount }}';//$('.tax_amount').text();
    var tds_amt=(amt*tds)/100;
    $('.tds_amt').val(parseInt(tds_amt));
    var final=parseFloat(tax_amount)-parseFloat(tds_amt);
    //alert(amt+'-'+tds_amt+'-'+tax_amount);
    $('.tds_payable').val(parseInt(final));
  }
  function chkReq(a) {
   var stVal = ($('#inv_status'+a).val());
   if (stVal==2) {
      $('#status_cmt_'+a).attr('required',true);
   }else{
    $('#status_cmt_'+a).attr('required',false);
   }
  }
  function rawRemove(a,b){
    $('#SavGoods'+a+b).remove();
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
  $(document).ready(function(){
    $('.plus').click(function(){
       var dataId=$(this).attr('data-id');
       var cls = $('.Goods'+dataId).length;
        var sr=cls+1;
        var cls =cls+Math.floor(1000 + Math.random() * 9000);
        //var clone='<div class="row newGD Goods'+dataId+'" id="removeItemRow'+cls+'"><div class="col-md-3"> <div class="form-group">  <input class="form-control" placeholder="Debit account" required="" id="" name="debit_account['+dataId+'][]" type="text" value=""> <span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group"> <input class="form-control" placeholder="Amount" required="" id="" name="amount['+dataId+'][]" type="number" value=""> <span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group">  <input class="form-control" placeholder="Cost Center" required="" id="" name="cost_center['+dataId+'][]" type="text" value=""> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"> <input class="form-control" placeholder="Category" required="" id="" name="category['+dataId+'][]" type="text" value=""> <span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
        var url="{{ route('employee.getInvoiceItemRow') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{dataId:dataId ,cls:cls, _token: '{{csrf_token()}}'},
          beforeSend: function(){
          // $('#preloader').show();
          },
          success:function(response){
            if (response) {
                // $('#modal-body').html(response);
                // $('#modal-default').modal('show');
                $('#Goods'+dataId).append(response);
            }
           // $('#preloader').hide();
          }
        });
        //$('#Goods'+dataId).append(clone);
        var cls = $('.Goods'+dataId).length;
        var p_sr=1;
        $("p[class *= 'sr']").each(function(){
            ($(this).text(p_sr++));
        });
        if (cls) {
          $('.trash').show();
        }
     });

  });
  function removeItemRow(argument) {
     // alert();
      $('#removeItemRow'+argument).remove();
      var p_sr=1;
      $("p[class *= 'sr']").each(function(){
          ($(this).text(p_sr++));
      });
    }
  $('.bank_account_data').change(function(){
    var dataId = $(this).attr('data');
    var accNo=$(this).val();
    if (accNo) {
      var url="{{ route('employee.getBankCommonDetail') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{accNo:accNo , _token: '{{csrf_token()}}'},
          beforeSend: function(){
          // $('#preloader').show();
          },
          success:function(response){
            if (response) {
              $('#ifsc_data'+dataId).val(response.ifsc);
              $('#bank_name_data'+dataId).val(response.bank_name);
                // $('#modal-body').html(response);
                // $('#modal-default').modal('show');
            }
           // $('#preloader').hide();
          }
        });
    }else{
      $('#ifsc_data'+dataId).val(null);
      $('#bank_name_data'+dataId).val(null);
    }
  });

function cheackAmount() {
  var role ='{{ $log_role }}';
  if (role==9) {
    var amount='{{ $data->invoice_amount }}';
    var sum = 0;
      $("input[class *= 'debit_amt']").each(function(){
          sum += +$(this).val();
      });
    if (amount==sum) {
      return true;
    }else{
      $('.subAlert').text('Invoice amount is ₹'+amount+'. So debit account must be equal according to invoice amount. Your current debit account amount is ₹'+sum);
      return false;
    }
  }
}
</script>
 @endsection