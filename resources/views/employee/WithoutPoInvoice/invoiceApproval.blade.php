@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Invoice {{ $data->invoice_number }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingWithoutPoInvoice','Without PO Invoice',[],[])}}
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
            <h3 class="card-title">Approve Invoice {{ $data->invoice_number }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.changeWithoutPoInvoiceActStatus',$data->order_id,$page],'files'=>true,'onSubmit'=>'return cheackAmount()'])}}
                
                <div class="row">
                   <div class="col-md-12 model_title"><h3>Invoice No: {{ $data->invoice_number }}</h3>
                    </div>

                  <div class="col-md-12 vander_dataview">
                    <ul>
                      <li>
                        <strong>Vendor:</strong><p>{{ json_decode($data->vendor_ary)->name ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Code:</strong><p>{{ json_decode($data->vendor_ary)->vendor_code ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Email:</strong><p>{{ json_decode($data->vendor_ary)->email ?? '' }}</p>
                      </li>

                      <li>
                        <strong>PO Total:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable ?? '' }}</p>
                      </li>

                      @php
                        
                        $invc=\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->order_id])->sum('invoice_amount');
                      @endphp

                      <li>
                        <strong>Invoice Approved:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $invc }}</p>
                      </li>

                      <li class="w-33">
                        <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable-$invc }}</p>
                      </li>

                      <li>
                        <strong>Invoice Date:</strong><p>{{ date('d M Y',strtotime($data->invoice_date)) ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Invoice Number:</strong><p>{{$data->invoice_number ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{$data->amount ?? '' }}</p>
                      </li>
                      <li>
                        <strong>Tax:</strong><p>{{$data->tax ?? 0 }}%</p>
                      </li>
                      <li>
                        <strong>Tax Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{$data->tax_amount ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Invoice Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{$data->invoice_amount ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Status:</strong><p>{{ \App\Invoice::invoiceStatus($data->invoice_status) }}</p>
                      </li>

                      <li>
                        <strong>Specified Person:</strong><p>{{$data->specified_person ?? '' }}</p>
                      </li>
                       <li>
                        <strong>Transaction Id:</strong><p>{{$data->transaction_id ?? '' }}</p>
                      </li>
                       <li>
                        <strong>Transaction Date:</strong><p>{{$data->transaction_date ?? '' }}</p>
                      </li>

                      <li>
                        <strong>Image:</strong><p><a href="{{url('public/'.$data->invoice_file_path)}}" target="_blank"><img src="{{ url('public/'.$data->invoice_file_path) }}" alt="user" class="img-fluit edit-product-img" style="width: 70px;height: 70px;" /></a></p>
                      </li>

                    </ul> 
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      @php
                        $dataTds=$data->tds ?? '0';
                        $tds_amount=$data->tds_amount ?? '0';
                        $tds_month=($data->tds_month) ? $data->tds_month : '';
                        $tds_payable=($data->invoice_amount-$tds_amount);
                      @endphp

                        @if(Auth::guard('employee')->user()->role_id==9)
                          <div class="col-md-6">
                             <div class="form-group">
                                {{ Form::label('specified_person','Specified Person') }}
                                {{ Form::select('specified_person',['Yes'=>'Yes','No'=>'No'],$data->specified_person,['class'=>'form-control custom-select select2','placeholder'=>'Specified person']) }}
                                <span class="text-danger">{{ $errors->first('specified_person')}}</span>
                              </div>
                            </div>
                            <div class="col-md-6 tds_fld">
                               <div class="form-group">
                                  {{ Form::label('tds','TDS') }}
                                  {{ Form::number('tds',$dataTds,['class'=>'form-control tds','placeholder'=>'TDS','required'=>true,'onkeyup'=>"chlAmt()"]) }}
                                  <span class="text-danger">{{ $errors->first('tds')}}</span>
                                </div>
                              </div>
                              <div class="col-md-6 tds_fld">
                               <div class="form-group">
                                  {{ Form::label('tds_amount','TDS Amount') }}
                                  {{ Form::number('tds_amount',$tds_amount,['class'=>'form-control tds_amt','placeholder'=>'TDS','required'=>true,'readonly'=>true]) }}
                                  <span class="text-danger">{{ $errors->first('tds_amount')}}</span>
                                </div>
                              </div>
                              <div class="col-md-6 tds_fld">
                               <div class="form-group">
                                  {{ Form::label('tds_month','TDS Section') }}
                                  {{-- Form::select('tds_month',\App\Invoice::tdsMonth(),$tds_month,['class'=>'form-control custom-select select2','placeholder'=>'Select TDS Month','required'=>true]) --}}
                                  {{ Form::text('tds_month',$tds_month,['class'=>'form-control','placeholder'=>'TDS Section']) }}
                                  <span class="text-danger">{{ $errors->first('tds_month')}}</span>
                                </div>
                              </div>
                              <div class="col-md-4">
                                    {{ Form::label('Payable Amount:','Payable Amount:') }}
                                    {{ Form::number('tds_payable',$tds_payable,['class'=>'form-control tds_payable','readonly'=>true]) }}
                                  </div>

                          @endif
                          <div class="col-md-6">
                             <div class="form-group">
                              {{ Form::label('Approval','Approval') }}
                                
                                {{ Form::hidden('invoice_id[]',$data->order_id)}}
                                {!! Form::select('invoice_status',\App\Invoice::invoiceStatusChange(),[],['class'=>'form-control custom-select select2','style'=>'width:100%','id'=>'inv_status'.$data->order_id,'onchange'=>"chkReq($data->order_id)",'placeholder'=>'Invoice Status','required'=>true])!!}
                                <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                             </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              {{ Form::label('Comment','Comment') }}
                               {{ Form::textarea('invoice_status_comment','',['class'=>'form-control textareaCustom','rows'=>'2','placeholder'=>'Comment here','id'=>'status_cmt_'.$data->order_id])}}
                                <span class="text-danger" id="span{{$data->order_id}}">{{ $errors->first('invoice_status_comment') }}</span>
                            </div>
                          </div>
                    </div>
                </div>
                    @php $bnkitem=[];@endphp
                     @if($data->form_by_account)
                        @php $bnkitem=json_decode($data->form_by_account); @endphp
                      @endif
                    @if(Auth::guard('employee')->user()->role_id==9)
                      <div class="col-md-4">
                        <div class="form-group">
                          {{ Form::label('Bank Account','Bank Account') }}
                           {{-- Form::text('bank_account['.$data->id.']',$bnkitem->bank_account ?? '',['class'=>'form-control','placeholder'=>'Bank Account','id'=>'']) --}}

                           {{ Form::select('bank_account['.$data->id.']',\App\BankAccount::bnkHeadOfcPluck(),$bnkitem->bank_account ?? '',['class'=>'form-control custom-select select2','placeholder'=>'Bank Account','id'=>'bank_account_data']) }}

                          <span class="text-danger">{{ $errors->first('bank_account.*')}}</span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          {{ Form::label('IFSC','IFSC') }}
                          {{ Form::text('ifsc['.$data->id.']',$bnkitem->ifsc ?? '',['class'=>'form-control','placeholder'=>'IFSC','id'=>'ifsc_data']) }}
                          <span class="text-danger">{{ $errors->first('ifsc.*')}}</span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          {{ Form::label('Bank Name','Bank Name') }}
                              {{ Form::text('bank_name['.$data->id.']',$bnkitem->bank_name ?? '',['class'=>'form-control','placeholder'=>'Bank Name','id'=>'bank_name_data']) }}
                              <span class="text-danger">{{ $errors->first('bank_name.*')}}</span>
                        </div>
                      </div>
                    @endif          
                <!--  -->
                @if(Auth::guard('employee')->user()->role_id==9)
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
                      @if($data->form_by_account)
                        @php $item=json_decode($data->form_by_account); @endphp
                        @forelse($item->form_by_account as $itemKey => $itemVal)
                          <div class="row w-100" id="SavGoods{{$itemKey}}">
                             <div class="col-md-3">
                               <div class="form-group">
                                    
                                    {{-- Form::text('debit_account[]',$itemVal->debit_account,['class'=>'form-control','placeholder'=>'Debit account','required'=>true,'id'=>'']) --}}
                                   {{ Helper::debitAccount($itemVal->debit_account)}}
                                    <span class="text-danger">{{ $errors->first('debit_account.*')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-3">
                               <div class="form-group">
                                   
                                    {{ Form::number('amount[]',$itemVal->amount,['class'=>'form-control debit_amt','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
                                    <span class="text-danger">{{ $errors->first('amount.*')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-3">
                               <div class="form-group">
                                    
                                    {{-- Form::text('cost_center[]',$itemVal->cost_center,['class'=>'form-control','placeholder'=>'Cost Center','required'=>true,'id'=>'']) --}}
                                    {{Helper::costCenter($itemVal->cost_center)}}
                                    <span class="text-danger">{{ $errors->first('cost_center.*')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-2">
                               <div class="form-group">
                                   {{-- Form::text('category[]',$itemVal->category,['class'=>'form-control','placeholder'=>'Category','required'=>true,'id'=>'']) --}}
                                   {{Helper::category($itemVal->category)}}
                                    <span class="text-danger">{{ $errors->first('category.*')}}</span>
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
                          @if($data->form_by_account=='')
                            <div class="row">
                             <div class="col-md-3">
                               <div class="form-group">
                                     {{-- Form::text('debit_account[]','',['class'=>'form-control','placeholder'=>'Debit account','required'=>true,'id'=>'']) --}}
                                     {{Helper::debitAccount()}}
                                    <span class="text-danger">{{ $errors->first('debit_account.*')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-3">
                               <div class="form-group">
                                    {{ Form::number('amount[]','',['class'=>'form-control debit_amt','placeholder'=>'Amount','required'=>true,'id'=>'']) }}
                                    <span class="text-danger">{{ $errors->first('amount.*')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-3">
                               <div class="form-group">
                                    {{-- Form::text('cost_center[]','',['class'=>'form-control','placeholder'=>'Cost Center','required'=>true,'id'=>'']) --}}
                                    {{Helper::costCenter()}}
                                    <span class="text-danger">{{ $errors->first('cost_center.*')}}</span>
                                  </div>
                              </div>
                              <div class="col-md-3">
                               <div class="form-group">
                                     {{-- Form::text('category[]','',['class'=>'form-control','placeholder'=>'Category','required'=>true,'id'=>'']) --}}
                                     {{Helper::category()}}
                                    <span class="text-danger">{{ $errors->first('category.*')}}</span>
                                  </div>
                              </div>
                          </div>
                          @endif
                          <div id="Goods">
                          </div>
                          <div class="col-md-12 text-right">
                            {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                          </div>
                        </div>
                     @else
                        @if($data->form_by_account)
                          @php $item=json_decode($data->form_by_account); @endphp
                          <table width="100%" class="table">
                            <tr>
                              <td><strong>Bank Account</strong><p>{{$item->bank_account}}</p></td>
                               <td><strong>IFSC</strong><p>{{$item->ifsc}}</p></td>
                               <td><strong>Bank Name</strong><p>{{$item->bank_name}}</p></td>
                            </tr>
                          </table>
                          <div class="col-md-12">
                            <table class="table">
                              <tr>
                                <th>Sr.</th>
                                <th>Debit Account</th>
                                <th>Amount</th>
                                <th>Cost Center</th>
                                <th>Category</th>
                              </tr>
                              @forelse($item->form_by_account as $itemKey => $itemVal)
                                  <tr>
                                  <td>{{++$itemKey}}</td>
                                  <td>{{$itemVal->debit_account}}</td>
                                  <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->amount}}
                                  {{ Form::hidden('amount[]',$itemVal->amount,['class'=>'form-control debit_amt','placeholder'=>'Amount','id'=>'']) }}
                                </td>
                                  <td>{{$itemVal->cost_center}}</td>
                                  <td>{{$itemVal->category}}</td>
                                </tr>
                              @empty
                              @endforelse
                              
                            </table>
                          </div>
                        @endif
                     @endif   
                    
                    <!--  -->
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
@php 
$log_role = Auth::guard('employee')->user()->role_id;
$debitAccount=Helper::debitAccount();
$costCenter=Helper::costCenter();
$category=Helper::category();
@endphp

<script type="text/javascript">
  function chkReq(a) {
   var stVal = ($('#inv_status'+a).val());
   if (stVal==2) {
      $('#status_cmt_'+a).attr('required',true);
   }else{
    $('#status_cmt_'+a).attr('required',false);
   }
  }
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
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-3"> <div class="form-group">{{$debitAccount}}<span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group"> <input class="form-control debit_amt" placeholder="Amount" required="" id="" name="amount[]" type="number" value=""> <span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group">{{$costCenter}}<span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group">{{$category}}<span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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

  function chlAmt() {
    var amt='{{$data->amount}}';
    var tds=$('.tds').val();
    var tax_amount='{{$data->invoice_amount}}';
    var tds_amt=(amt*tds)/100;
    $('.tds_amt').val(parseInt(tds_amt));
    var final=parseFloat(tax_amount)-parseFloat(tds_amt);
    //alert(amt+'-'+tds_amt+'-'+tax_amount);
    $('.tds_payable').val(parseInt(final));
  }
 
  $('#bank_account_data').change(function(){
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
              $('#ifsc_data').val(response.ifsc);
              $('#bank_name_data').val(response.bank_name);
                // $('#modal-body').html(response);
                // $('#modal-default').modal('show');
            }
           // $('#preloader').hide();
          }
        });
    }else{
      $('#ifsc_data').val(null);
      $('#bank_name_data').val(null);
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
