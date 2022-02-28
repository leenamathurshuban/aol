@extends('layouts.employee')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Form {{ $data->order_id ?? '' }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
 
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingEmpPay','Pending Request',[],[])}}
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
            <h3 class="card-title">Approve Form {{ $data->order_id ?? '' }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">
  
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
                      <strong>PO Start Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->po_start_date) ?? '' }}</p>
                    </li>

                    <li>
                      <strong>PO End Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->po_end_date) ?? '' }}</p>
                    </li>

                    <li>
                      <strong>PO Total:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable ?? '' }}</p>
                    </li>

                    @php
                      $invc=\App\Invoice::approvedPoInvoice($data->id);
                    @endphp
                    
                    {{-- <li>
                      <strong>PO Invoice Limit :</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ \App\Invoice::invoiceLimit($data->net_payable) ?? '' }}</p>
                    </li>--}}

                    <li>
                      <strong>Invoice Approved:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $invc }}</p>
                    </li>

                    <li class="w-33">
                      <strong>PO Balance:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable-$invc }}</p>
                    </li>
           
                    <li>
                      <strong>Advance TDS:</strong><p>{{ $data->advance_tds ?? '' }}</p>
                    </li>

                    <li>
                      <strong>Creater Name:</strong><p>{{ json_decode($data->user_ary)->name ?? '' }}</p>
                    </li>

                     <li>
                      <strong>Code:</strong><p>{{ json_decode($data->user_ary)->employee_code ?? '' }}</p>
                    </li>

                    <li>
                      <strong>Payment:</strong><p>{{ \App\PurchaseOrder::paymentMethod($data->payment_method) ?? '' }}</p>
                    </li>

                     <li>
                      <strong>Nature Of Service:</strong><p>{{ \App\PurchaseOrder::natureOfService($data->nature_of_service) ?? '' }}</p>
                    </li>

                    <li>
                      <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p>
                    </li>
                    
                    @if($data->level2_user_id)
                      <li>
                        <strong>Manager Name:</strong><p>{{ json_decode($data->level2_user_ary)->name ?? '' }}</p>
                      </li>

                       <li>
                        <strong>Code:</strong><p>{{ json_decode($data->level2_user_ary)->employee_code ?? '' }}</p>
                      </li>

                       <li>
                        <strong>Mobile:</strong><p>{{ json_decode($data->level2_user_ary)->mobile_code ?? '' }} {{ json_decode($data->level2_user_ary)->mobile ?? '' }}</p>
                      </li>
                      <li class="col-md-12">
                        <strong>Manager Comments:</strong><p>{{ $data->account_status_level2_comment ?? '' }}</p>
                      </li>

                    @endif
                    <li class="col-md-12">
                      <strong>Service Detail:</strong><p>{{ $data->service_detail ?? '' }}</p>
                    </li>
                  </ul>
                <div class="table-responsive">
                  @if($data->item_detail)
                    @php $item=json_decode($data->item_detail); @endphp
                    <table class="table">
                      <tr><td colspan="8"><h3>Item Detail</h3></td></tr>
                      <tr>
                        <th>Sr</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Tax</th>
                        <th>Tax value</th>
                        <th>Comment</th>
                        <th>Total</th>
                      </tr>
                      @forelse($item as $itemKey => $itemVal)
                        <tr>
                          <td>{{ ++$itemKey }}</td>
                          <td>{{ $itemVal->item_name }}</td>
                          <td>{{ $itemVal->quantity }} {{ $itemVal->unit }}</td>
                          <td>{{ env('CURRENCY_SYMBOL').''.$itemVal->rate }}</td>
                          <td>{{ $itemVal->tax }}%</td>
                          <td>{{ env('CURRENCY_SYMBOL').''.$itemVal->tax_amt }}</td>
                          <td>{{ $itemVal->price_unit }}</td>
                          <td>{{ env('CURRENCY_SYMBOL').''.$itemVal->total }}</td>
                        </tr>
                      @empty
                      @endforelse
                      @if($item)
                        <tfoot>
                          <tr>
                            <td colspan="7" class="text-right">Grand Total:</td>
                            <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->total ?? '' }}</td>
                          </tr>
                          <tr>
                            <td colspan="7" class="text-right">Discount:</td>
                            <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->discount ?? '' }}</td>
                          </tr>
                          <tr>
                            <td colspan="7" class="text-right">Net Payable:</td>
                            <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->net_payable ?? '' }}</td>
                          </tr>
                        </tfoot>
                      @endif
                    </table>
                  @endif
                </div>
                <ul>
                  <hr>
                  @if($data->approved_user_id)
                    <li>
                      <strong>Trust Office:</strong><p>{{ json_decode($data->approved_user_ary)->name ?? '' }}</p>
                    </li>

                     <li>
                      <strong>Code:</strong><p>{{ json_decode($data->approved_user_ary)->employee_code ?? '' }}</p>
                    </li>

                     <li>
                      <strong>Mobile:</strong><p>{{ json_decode($data->approved_user_ary)->mobile_code ?? '' }} {{ json_decode($data->approved_user_ary)->mobile ?? '' }}</p>
                    </li>
                  @endif

                  @if($data->account_status_level3_comment)
                    <div class="col-md-12 specify_other">
                    <strong>Financer Comments:</strong> <p>{{ $data->account_status_level3_comment ?? '' }}</p>
                  </div>
                  @endif
                </ul>
              </div>
              @forelse($data->poImage as $key => $val)
                <div class="col-md-2">
                 <div class="gallery_imgct">
                      {!! Html::decode(link_to('public/'.$val->po_file_path,\App\Helpers\Helper::getDocType($val->po_file_path,$val->po_file_type),['target'=>'_blank'])) !!}
                  <p>{{ $val->po_file_description }}</p>
                 </div>
                </div>
              @empty
              @endforelse
               @if(\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->id])->count())
                  <table class="table">
                    <tr><td colspan="9"><h3>Approved Invoice Detail</h3></td></tr>
                    <tr>
                      <th>Sr</th>
                      <th>Date</th>
                      <th>No:</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Employee</th>
                      <th>Manager</th>
                      <th>Financer</th>
                      <th>Trust Office</th>
                      <th>File</th>
                    </tr>
                    @forelse(\App\Invoice::where(['invoice_status'=>5,'po_id'=>$data->id])->get() as $itemKey => $itemVal)
                      <tr>
                        <td>{{ ++$itemKey }}</td>
                        <td>{{ \App\Helpers\Helper::onlyDate($itemVal->invoice_date) ?? '' }}</td>
                         <td>{{ $itemVal->invoice_number }}</td>
                        <td>{{ env('CURRENCY_SYMBOL').''. $itemVal->invoice_amount }} </td>
                        <td>
                            {{ \App\Invoice::invoiceStatus($itemVal->invoice_status)}}
                        </td>
                        <td>
                          @if($itemVal->employee_id)
                          {{ json_decode($itemVal->employee_ary)->name ?? '' }} {{ json_decode($itemVal->employee_ary)->employee_code ?? '' }}
                          @endif
                        </td>
                        <td>
                          @if($itemVal->approver_manager)
                          {{ json_decode($itemVal->manager_ary)->name ?? '' }} {{ json_decode($itemVal->manager_ary)->employee_code ?? '' }}<br>
                          Comment: {{$itemVal->manager_comment}}
                          @endif
                        </td>
                        <td>
                          @if($itemVal->approver_financer)
                           {{ json_decode($itemVal->financer_ary)->name ?? '' }} {{ json_decode($itemVal->financer_ary)->employee_code ?? '' }}<br>
                           Comment: {{$itemVal->financer_comment}}
                          @endif
                        </td>
                        <td>
                          @if($itemVal->approver_trust)
                            {{ json_decode($itemVal->approver_ary)->name ?? '' }} {{ json_decode($itemVal->approver_ary)->employee_code ?? '' }}<br>
                            Comment: {{$itemVal->trust_comment}}
                          @endif
                        </td>
                        <td>
                           {!! Html::decode(link_to('public/'.$itemVal->invoice_file_path,\App\Helpers\Helper::getDocType($itemVal->invoice_file_path,$itemVal->po_file_type),['target'=>'_blank'])) !!}

                        </td>
                      </tr>
                    @empty
                    @endforelse
                   
                     {{-- <tfoot>
                        <tr>
                          <td colspan="4" class="text-right">PO Total Amount:</td>
                          <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->order_amount ?? '' }}</td>
                        </tr>
                        <tr>
                          <td colspan="4" class="text-right">Approved Invoice Amount:</td>
                          <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->invoice_amount ?? '' }}</td>
                        </tr>
                        <tr>
                          <td colspan="4" class="text-right">Pending Amount:</td>
                          <td>{{ env('CURRENCY_SYMBOL') }}{{ $data->invoice_balance ?? '' }}</td>
                        </tr>
                      </tfoot>--}}
                  </table>
                @endif

                <div class="col-md-12">
                    <p> <strong>PO Desciption :</strong> {{ $data->po_description }}</p>
                </div>

            </div>
            {{ Form::open(['route'=>['employee.POApprove',$data->order_id,$page],'files'=>true])}}
              <div class="row">
                @php
                        $statusAry = \App\PurchaseOrder::orderStatus();
                      @endphp

                    <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Approval','Approve') }}
                        {{ Form::select('account_status',$statusAry,'',['class'=>'form-control custom-select select2','placeholder'=>'Give Approval','onchange'=>"chkReq()",'id'=>'status','required'=>true]) }}
                        <span class="text-danger">{{ $errors->first('account_status')}}</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Comment','Comment') }}
                        {{ Form::textarea('account_status_comment','',['class'=>'form-control','placeholder'=>'Comment here','id'=>'status_cmt','rows'=>3]) }}
                        <span class="text-danger">{{ $errors->first('account_status_comment')}}</span>
                      </div>
                    </div>
                    <!--  -->



                    <!--  -->
                 
                <!-- /.col  -->
              </div>

            {{--  <div class="row imgSection">
                  <div class="col-md-3" id="IMAGESEC">
                        <div class="form-group">
                          {!!Form::label('Attachments', 'Attachments')!!}
                             {!!Form::file('emp_req_file[]',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                          @if($errors->has('emp_req_file'))
                              <p class="text-danger">{{$errors->first('emp_req_file')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                          {!!Form::label('description', 'Attachment Description')!!}
                             {!!Form::textarea('emp_req_file_description[]','',['class'=>'form-control','rows'=>3,'placeholder'=>'Description about attachment file'])!!}
                          @if($errors->has('emp_req_file_description'))
                              <p class="text-danger">{{$errors->first('emp_req_file_description')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 text-left editIcon">
                      {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary addIMg'])) !!}
                      {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger removeIMg','style'=>'display:none'])) !!}
                    </div>
              </div>--}}
            <!-- /.row -->
              <div class="card-footer">
                {!! Form::submit('Update',['class'=>'btn btn-outline-primary']) !!}
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

 <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header noprint">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body P-0" id="modal-body">

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>

@endsection

@section('footer')

<script type="text/javascript">
  $('.radio').click(function(){
    if($(this).val()=='other'){
      $('.empDiv').show();
    }else{
      $('.empDiv').hide();
    }
  });

  $('.addIMg').click(function() {
    var cls = $('.IMGRow').length;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="col-md-3 IMGRow"> <div class="form-group"> <label for="file">Attachment</label> <input class="dropify form-control" data-default-file="" id="input-file-now-custom-1" name="emp_req_file[]" type="file" required> </div><div class="form-group"> <label for="description">Attachment Description</label> <textarea class="form-control" rows="3" name="emp_req_file_description[]" cols="50" placeholder="Description about attachment file"></textarea> </div></div>';
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
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-3"> <div class="form-group">  <input class="form-control" placeholder="Debit account" required="" id="" name="debit_account[]" type="text" value=""> <span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group"> <input class="form-control" placeholder="Amount" required="" id="" name="amount[]" type="number" value=""> <span class="text-danger"></span> </div></div><div class="col-md-3"> <div class="form-group">  <input class="form-control" placeholder="Cost Center" required="" id="" name="cost_center[]" type="text" value=""> <span class="text-danger"></span> </div></div><div class="col-md-2"> <div class="form-group"> <input class="form-control" placeholder="Category" required="" id="" name="category[]" type="text" value=""> <span class="text-danger"></span> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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
