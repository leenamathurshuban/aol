@if($type=='getBankByState')
<div class="form-group">
  {{ Form::label('Bank Account','Bank Account') }}
  {{ Form::select('state_bank_id',$bankAccount,'',['class'=>'form-control srchBank','placeholder'=>'Choose Bank Account','id'=>'state_bankAccount']) }}
  <span class="text-danger">{{ $errors->first('state_bank_id')}}</span>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $('.srchBank').on('change',function(){
      var bnkId=$(this).val();
      var id=$(this).attr('id');
      //alert(bnkId);
      if (bnkId!='') {
        var url="{{ route('employee.getInternalTransBankAccountArray') }}";
        $.ajax({
          type:"POST",
          url:url,
          data:{bnkId:bnkId , _token: '{{csrf_token()}}',type:'getBankAccountArray'},
          beforeSend: function(){
           //$('#preloader').show();
          },
          success:function(response){
            if(id=='state_bankAccount'){
              //alert(response.ifsc);
                $('#ifsc').val(response.ifsc);
            }
            if (id=='transfer_from') {
              $('#transfer_from_ifsc').val(response.ifsc);
              $('#transfer_from_account').val(response.bank_account_number);
            }
            if (id=='transfer_to') {
              $('#transfer_to_ifsc').val(response.ifsc);
              $('#transfer_to_account').val(response.bank_account_number);
            }
             
            // $('#employee_address').val(response.address);
            // $('#employee_bank_account').val(response.bank_account_number);
            // $('#employee_ifsc').val(response.ifsc);
            // $('#employee_pan').val(response.pan);
            //$('#preloader').hide();
          }
        });
      }else{
        if(id=='state_bankAccount'){
            $('#ifsc').val(null);
        }
        if (id=='transfer_from') {
              $('#transfer_from_ifsc').val(null);
              $('#transfer_from_account').val(null);
            }
            if (id=='transfer_to') {
              $('#transfer_to_ifsc').val(null);
              $('#transfer_to_account').val(null);
            }
      }
    });
  });
</script>
@elseif($type=='getInternalTrnsDetail')
  <div class="row">
    <div class="col-md-12 model_title"><h3>Request No: {{ $data->order_id ?? '' }}</h3>
    </div>

  <div class="col-md-12 vander_dataview">
    <ul>
      <li>
        <strong>Pay For:</strong><p>{{ $data->nature_of_request ?? ''}}</p>
      </li>

      
      <li>
        <strong>Request Status:</strong><p>{{ \App\InternalTransfer::requestStatus($data->status)}}</p>
      </li>

      <li>
        <strong>Requested Employee:</strong><p>{{json_decode($data->employee_ary)->name ?? ''}}</p>
      </li>

      <li>
        <strong>Requested Employee Code:</strong><p>{{json_decode($data->employee_ary)->employee_code ?? ''}}</p>
      </li>

      <li>
        <strong>Requested Date:</strong><p>{{ \App\Helpers\Helper::onlyDate($data->employee_date) ?? ''}}</p>
      </li>

      <li>
        <strong>Amount:</strong><p>{{ env('CURRENCY_SYMBOL') }}{{ $data->amount ?? '0' }}</p>
      </li>
      <li>
        <strong>Apex:</strong><p>{{ json_decode($data->apexe_ary)->name ?? '' }}</p>
      </li>
      @if(Auth::guard('employee')->user()->role_id!=4)
      <li>
        <strong>Transaction Id:</strong><p>{{ $data->transaction_id }}</p>
      </li>
      <li>
        <strong>Transaction Date:</strong><p>{{ ( $data->transaction_date) ? \App\Helpers\Helper::onlyDate( $data->transaction_date) : '' }}</p>
      </li>

      <li>
        <strong>Date of Payment:</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p>
      </li>
      @endif

      @if($data->nature_of_request=='State requesting funds')
        <li>
        <strong>State:</strong><p>{{json_decode($data->apex_ary)->name ?? ''}}</p>
      </li>
       <li>
        <strong>Bank Name:</strong><p>{{ json_decode($data->state_bank_ary)->bank_name ?? '' }}</p>
      </li>
       <li>
        <strong>Bank Account Number:</strong><p>{{ json_decode($data->state_bank_ary)->bank_account_number ?? '' }}</p>
      </li>
      <li>
        <strong>Bank IFSC:</strong><p>{{ json_decode($data->state_bank_ary)->ifsc ?? '' }}</p>
      </li>
      <li>
        <strong>Bank Branch Address:</strong><p>{{ json_decode($data->state_bank_ary)->branch_address ?? '' }}</p>
      </li>
      <li>
        <strong>Bank Account Holder:</strong><p>{{ json_decode($data->state_bank_ary)->bank_account_holder ?? '' }}</p>
      </li>
       <li>
        <strong>Project Name:</strong><p>{{ $data->project_name ?? '' }}</p>
      </li>

      <li>
        <strong>Reason:</strong><p>{{ $data->reason ?? '' }}</p>
      </li>
       <li>
        <strong>Project Id:</strong><p>{{ $data->project_id ?? '' }}</p>
      </li>

      <li>
        <strong>Cost Center:</strong><p>{{ $data->cost_center ?? '' }}</p>
      </li>

      @elseif($data->nature_of_request=='Inter bank transfer')

      <li>
        <strong>Transfer From Bank:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_name ?? '' }}</p>
      </li>
       <li>
        <strong>From Account Number:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_account_number ?? '' }}</p>
      </li>
      <li>
        <strong>From Bank IFSC:</strong><p>{{ json_decode($data->transfer_from_ary)->ifsc ?? '' }}</p>
      </li>
      <li>
        <strong>From Bank Branch Address:</strong><p>{{ json_decode($data->transfer_from_ary)->branch_address ?? '' }}</p>
      </li>
      <li>
        <strong>From Bank Account Holder:</strong><p>{{ json_decode($data->transfer_from_ary)->bank_account_holder ?? '' }}</p>
      </li>

      <li>
        <strong>Transfer To Bank:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_name ?? '' }}</p>
      </li>
       <li>
        <strong>To Account Number:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_account_number ?? '' }}</p>
      </li>
      <li>
        <strong>To Bank IFSC:</strong><p>{{ json_decode($data->transfer_to_ary)->ifsc ?? '' }}</p>
      </li>
      <li>
        <strong>To Bank Branch Address:</strong><p>{{ json_decode($data->transfer_to_ary)->branch_address ?? '' }}</p>
      </li>
      <li>
        <strong>To Bank Account Holder:</strong><p>{{ json_decode($data->transfer_to_ary)->bank_account_holder ?? '' }}</p>
      </li>
        
   
      @else

      @endif

      @if($data->form_by_account)
            @php $item=json_decode($data->form_by_account); @endphp
            <li class="col-md-12">
            {{--  <table class="table" width="100%">
                <tr>
                  <td><strong>Bank Account</strong><p>{{$item->bank_account ?? ''}}</p></td>
                  <td><strong>IFSC</strong><p>{{$item->ifsc ?? ''}}</p></td>
                  <td><strong>Bank Name</strong><p>{{$item->bank_name ?? ''}}</p></td>
                </tr>
              </table>--}}
            </li>
            <li class="col-md-12">
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
                    <td>{{ env('CURRENCY_SYMBOL') }}{{$itemVal->amount}}</td>
                    <td>{{$itemVal->cost_center}}</td>
                    <td>{{$itemVal->category}}</td>
                  </tr>
                @empty
                @endforelse
              </table>
              </li>
          @endif
     
    
    <!--  class="w-33" -->
    </ul>
   

    @if($data->account_dept_id && $data->account_dept_ary)
     <ul>
      <li class="col-md-6">
        <strong>Account Office:</strong><p>{{json_decode($data->account_dept_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Account Code:</strong><p>{{json_decode($data->account_dept_ary)->employee_code ?? ''}}</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->accountant_date) ? \App\Helpers\Helper::onlyDate($data->accountant_date) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Account Comment:</strong><p>{{$data->account_dept_comment}}</p>
      </li>
     </ul>
    @endif

    @if($data->trust_ofc_id && $data->trust_ofc_ary)
     <ul>
      <li class="col-md-6">
        <strong>Trust Office:</strong><p>{{json_decode($data->trust_ofc_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Trust Code:</strong><p>{{json_decode($data->trust_ofc_ary)->employee_code ?? ''}}</p>
      </li>
      <li>
        <strong>Approval Date:</strong><p>{{ ($data->trust_date) ? \App\Helpers\Helper::onlyDate($data->trust_date) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Trust Comment:</strong><p>{{$data->trust_ofc_comment}}</p>
      </li>
     </ul>
    @endif

    @if($data->payment_ofc_id && $data->payment_ofc_ary)
     <ul>
      <li class="col-md-6">
        <strong>Payment Office:</strong><p>{{json_decode($data->payment_ofc_ary)->name ?? ''}}</p>
      </li>
      <li class="col-md-6">
        <strong>Payment Code:</strong><p>{{json_decode($data->payment_ofc_ary)->employee_code ?? ''}}</p>
      </li>
       <li>
        <strong>Approval Date:</strong><p>{{ ($data->date_of_payment) ? \App\Helpers\Helper::onlyDate($data->date_of_payment) : '' }}</p>
      </li>
      <li class="col-md-12">
        <strong>Payment Comment:</strong><p>{{$data->payment_ofc_comment}}</p>
      </li>
     </ul>
    @endif
  </div>


  @forelse($data->internalTransferImage as $key => $val)
      <div class="col-md-2">
       <div class="gallery_imgct">
            {!! Html::decode(link_to('public/'.$val->internal_transfer_file_path,\App\Helpers\Helper::getDocType($val->internal_transfer_file_path,$val->internal_transfer_file_type),['target'=>'_blank'])) !!}
        <p>{{ $val->internal_transfer_file_description }}</p>
       </div>
      </div>
    @empty
    @endforelse
</div>
@elseif($type=='getItemRowByClaim')
  @if($data->id==1)
    @if($headRow==0)
        <div class="row headRow">
          <div class="col-md-1 srDiv">
         <div class="form-group">
            {{ Form::label('Sr','Sr.') }}
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            {{ Form::label('Date','Date') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('location','Location') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('expenditure_category','Expenditure Category') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('qty','Quantity') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('rate','Rate') }}
          </div>
        </div>

        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('bill_number','Bill Number') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('amount','Amount') }}
          </div>
        </div>
      </div>
    @endif
    <div class="row newGD Goods" id="removeItemRow{{$cls}}">
      <div class="col-md-1 srDiv">
        <p class="sr">{{$cls}}</p>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="" max="{{date('Y-m-d')}}">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Location" id="" name="location[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <select name="category[]" class="form-control custom-select select2" id="">
            <option value="">Choose</option>
            @if($data->category)
              @forelse(json_decode($data->category) as $ckey => $cval)
                <option value="{{$cval}}">{{$cval}}</option>
              @empty
              @endforelse
            @endif
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Quantity" id="quantity{{$cls}}" name="quantity[]" type="number" value="" onKeyUp="countVal({{$cls}})" min="0">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Rate" id="rate{{$cls}}" name="rate[]" type="number" value="" onKeyUp="countVal({{$cls}})" min="0">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control amount" placeholder="Amount" id="amount{{$cls}}" name="amount[]" type="number" value="" readonly>
        </div>
      </div>
      <div class="col-md-1 ItemRemove">
        <div class="remRow_box">
          <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
  @elseif($data->id==2)
    @if($headRow==0)

        <div class="row headRow">
          <div class="col-md-1 srDiv">
         <div class="form-group">
            {{ Form::label('Sr','Sr.') }}
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            {{ Form::label('Date','Date') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('from_location','From') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('to_location','To') }}
          </div>
        </div>
         <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('distance','Distance') }}
          </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('mode_of_travel','Mode of travel') }}
          </div>
        </div>
        
        <div class="col-md-2">
         <div class="form-group">
            {{ Form::label('bill_number','Bill Number') }}
          </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
            {{ Form::label('amount','Amount') }}
          </div>
        </div>
      </div>
    
    @endif
    <div class="row newGDtrv Goods" id="removeItemRow{{$cls}}">
      <div class="col-md-1 srDiv">
        <p class="sr">{{$cls}}</p>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="" max="{{date('Y-m-d')}}">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Location" id="from_location" name="from_location[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Location" id="to_location" name="to_location[]" type="text" value="">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Distance" id="distance0" name="distance[]" type="number" value="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <select name="category[]" class="form-control custom-select select2" id="">
            <option value="">Choose</option>
            @if($data->category)
              @forelse(json_decode($data->category) as $ckey => $cval)
                <option value="{{$cval}}">{{$cval}}</option>
              @empty
              @endforelse
            @endif
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="">
          <span class="text-danger"></span>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <input class="form-control amount_trv" placeholder="Amount" id="" name="amount[]" type="number" value="" onKeyUp="countVal()" min="0">
          <span class="text-danger"></span>
        </div>
      </div>
      <div class="col-md-1 ItemRemove">
        <div class="remRow_box">
          <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>
  @elseif($data->id==3)
        @if($headRow==0)
         <div class="row headRow">
            <div class="col-md-1 srDiv">
           <div class="form-group">
              {{ Form::label('Sr','Sr.') }}
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              {{ Form::label('Date','Date') }}
            </div>
          </div>
          <div class="col-md-3">
           <div class="form-group">
              {{ Form::label('category','Category') }}
            </div>
          </div>
          
          <div class="col-md-3">
           <div class="form-group">
              {{ Form::label('bill_number','Bill Number') }}
            </div>
          </div>
          <div class="col-md-2">
           <div class="form-group">
              {{ Form::label('amount','Amount') }}
            </div>
          </div>
          <div class="col-md-1"></div>
         </div>
      @endif
    <div class="row newGDtrv Goods" id="removeItemRow{{$cls}}">
      <div class="col-md-1 srDiv">
        <p class="sr">{{$cls}}</p>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control" placeholder="Date" id="" name="date[]" type="date" value="" max="{{date('Y-m-d')}}">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <select name="category[]" class="form-control custom-select select2" id="">
            <option value="">Choose</option>
            @if($data->category)
              @forelse(json_decode($data->category) as $ckey => $cval)
                <option value="{{$cval}}">{{$cval}}</option>
              @empty
              @endforelse
            @endif
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <input class="form-control" placeholder="Bill Number" id="" name="bill_number[]" type="text" value="">
          <span class="text-danger"></span>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <input class="form-control amount_trv" placeholder="Amount" id="" name="amount[]" type="number" value="" onKeyUp="countVal()" min="0">
          <span class="text-danger"></span>
        </div>
      </div>
      <div class="col-md-1 ItemRemove">
        <div class="remRow_box">
          <button type="button" class="btn btn-danger" onClick="removeItemRow({{$cls}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>
  @endif
<script type="text/javascript">
  function removeItemRow(argument) {
     // alert();
      $('#removeItemRow'+argument).remove();
      var p_sr=1;
      $("p[class *= 'sr']").each(function(){
          ($(this).text(p_sr++));
      });
      var sum = 0;
      $("input[class *= 'amount']").each(function(){
          sum += +$(this).val();
      });
      $("#amount_requested").val(sum);
    }
</script>

@endif
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  });

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false;

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template");
  previewNode.id = "";
  var previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  });

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
  });

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
  });

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1";
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
  });

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0";
  });

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
  };
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true);
  };
  
  
</script>