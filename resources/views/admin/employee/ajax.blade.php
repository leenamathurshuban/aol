@if($type=='getCityByState')

  {{ Form::label('City',$states->name."'s city") }}
  {!!Form::select('city', $cities, '', ['placeholder' => 'Select City','class'=>'form-control custom-select select2','id'=>''])!!}

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

  @elseif($type=='viewDetail')
      <div class="row">
        <div class="col-md-12 model_title"><h3>{{ $data->name ?? 'Employee' }} detail</h3>
        </div>
        <div class="col-md-12 vander_dataview">
        <ul>
        <li>
          <strong>Role:</strong><p>{{ json_decode($data->role_ary)->name ?? '' }}</p>
        </li>
         <li>
        <strong>Name:</strong><p>{{ $data->name ?? '' }}</p>
        </li>
        
        <li>
        <strong>Employee Code:</strong><p>{{ $data->employee_code ?? '' }}</p>
        </li>

        <li>
        <strong>Email:</strong><p>{{ $data->email ?? '' }}</p>
        </li>

        {{-- <li>
        <strong>Password:</strong><p>{{ $data->original_password ?? '' }}</p>
        </li>--}}

        <li>
        <strong>Contact:</strong><p>{{ $data->phone ?? '' }}</p>
        </li>

        <li>
          <strong>Tag:</strong><p>{{ $data->tag ?? '' }} </p>
        </li>

       
        <li>
          <strong>State:</strong><p>{{ json_decode($data->state_ary)->name ?? '' }}</p>
        </li>
      
        <li>
          <strong>City:</strong><p>{{ json_decode($data->city_ary)->name ?? '' }}</p>
        </li>


        <li>
          <strong>Created By Name:</strong><p>{{ json_decode($data->user_ary)->name ?? '' }}</p>
        </li>

         <li>
          <strong>Created By Email:</strong><p>{{ json_decode($data->user_ary)->email ?? '' }}</p>
        </li>

         <li>
          <strong>Created By Mobile:</strong><p>{{ json_decode($data->user_ary)->mobile_code ?? '' }} {{ json_decode($data->user_ary)->mobile ?? '' }}</p>
        </li>

     
        <li>
          <strong>Bank Account Type:</strong><p>{{ $data->bank_account_type ?? '' }}</p>
        </li>
     

        <li>
          <strong>Bank Account:</strong><p>{{ $data->bank_account_number ?? '' }}</p>
        </li>

        <li>
          <strong>Bank IFSC:</strong><p>{{ $data->ifsc ?? '' }}</p>
        </li>


        <li>
          <strong>Pan Number:</strong><p>{{ $data->pan ?? '' }}</p>
        </li>
        @if($data->approver_manager)
        <li>
          <strong>Approver Manager:</strong><p>{{ \App\Employee::manager($data->approver_manager)->name }} ( {{ \App\Employee::manager($data->approver_manager)->employee_code }} )</p>
        </li>
        @endif

     
        <li>
          <strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p>
        </li>

         <li>
          <strong>Address:</strong><p>{{ $data->address ?? '' }}</p>
        </li>

     
        <li>
          <strong>Location:</strong><p>{{ $data->location ?? '' }}</p>
        </li>

        <li>
          <strong>Zip:</strong><p>{{ $data->zip ?? '' }}</p>
        </li>

        <li>
          <strong>Medical Welfare category access:</strong><p>{{ $data->medical_welfare ?? 'No' }}</p>
        </li>
     
      <li class="col-md-12">
        <h5 class="m-0">Assign Process</h5>
      </li>
 
      @forelse($data->EmpAssignProcess as $ckey => $cval)
        <li>
          <strong>{{ $cval->assignProcessData->name ?? '' }}</strong><p></p>
      </li>
      @empty

      @endforelse
      </ul>
      <div class="col-md-12">
        <table class="table">
          <tr>
            <th>Sr</th>
            <th>Account Number</th>
            <th>IFSC</th>
            <th>Bank Name</th>
            <th>Branch Code</th>
          </tr>
          @forelse($data->bankAccount as $key => $val)
            <tr>
              <td>{{++$key}}</td>
              <td>{{$val->bank_account_number}}</td>
              <td>{{$val->ifsc}}</td>
              <td>{{$val->bank_name}}</td>
              <td>{{$val->branch_code}}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5">Not Found</td>
            </tr>
          @endforelse
        </table>
      </div>
      </div>
   </div>
   @endif
  
