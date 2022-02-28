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
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-12 text-center"><h3>{{ $data->name ?? 'Vendor' }} detail</h3>
                            <hr>
                          </div>
                         
                           <div class="col-md-4">
                          <p><strong>Name:</strong> {{ $data->name ?? '' }}</p>
                          </div>
                          
                        

                          <div class="col-md-4">
                          <p><strong>Email:</strong> {{ $data->email ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                          <p><strong>Password:</strong> {{ $data->original_password ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                          <p><strong>Contact:</strong> {{ $data->phone ?? '' }}</p>
                          </div>

                         
                          <div class="col-md-4">
                            <p><strong>State:</strong> {{ json_decode($data->state_ary)->name ?? '' }}</p>
                          </div>
                        
                          <div class="col-md-4">
                            <p><strong>City:</strong> {{ json_decode($data->city_ary)->name ?? '' }}</p>
                          </div>


                          <div class="col-md-4">
                            <p><strong>Created By Name:</strong> {{ json_decode($data->user_ary)->name ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                            <p><strong>Created By Email:</strong> {{ json_decode($data->user_ary)->email ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                            <p><strong>Created By Mobile:</strong> {{ json_decode($data->user_ary)->mobile_code ?? '' }} {{ json_decode($data->user_ary)->mobile ?? '' }}</p>
                          </div>

                       
                          <div class="col-md-4">
                            <p><strong>Bank Account Type:</strong> {{ $data->bank_account_type ?? '' }}</p>
                          </div>
                       

                          <div class="col-md-4">
                            <p><strong>Bank Account:</strong> {{ $data->bank_account_number ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                            <p><strong>Bank IFSC:</strong> {{ $data->ifsc ?? '' }}</p>
                          </div>


                          <div class="col-md-4">
                            <p><strong>Pan Number:</strong> {{ $data->pan ?? '' }}</p>
                          </div>

                        
                       
                          <div class="col-md-4">
                            <p><strong>Specified Person:</strong> {{ $data->specified_person ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                            <p><strong>Address:</strong> {{ $data->address ?? '' }}</p>
                          </div>

                       
                          <div class="col-md-4">
                            <p><strong>Location:</strong> {{ $data->location ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                            <p><strong>Zip:</strong> {{ $data->zip ?? '' }}</p>
                          </div>


                          <div class="col-md-4">
                            <p><strong>Constitution:</strong> {{ $data->constitution ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                            <p><strong>GST:</strong> {{ $data->gst ?? '' }}</p>
                          </div>

                          @if($data->constitution=='Others')
                          <div class="col-md-12">
                            <p><strong>Specify If Constitution Others:</strong> {{ $data->specify_if_other ?? '' }}</p>
                          </div>
                          @endif
                     </div>
                      </div>
                      <div class="col-md-3">
                         @if($data->pan_file)
                            <div class="col-md-12">
                              <p><strong>Pan Image</strong></p>
                                  <div class="col-md-12">
                                    <div class="zkit_gall_img">
                                      <img src="{{ url('public/'.$data->pan_file) }}" alt="user" class="img-fluit edit-product-img" />
                                    </div>
                                </div>
                            </div>
                          @endif
                          @if($data->cancel_cheque_file)
                            <div class="col-md-12">
                             <p><strong>Cancel Cheque</strong></p>
                                  <div class="col-md-12">
                                    <div class="zkit_gall_img">
                                      <img src="{{ url('public/'.$data->cancel_cheque_file) }}" alt="user" class="img-fluit edit-product-img" />
                                    </div>
                                </div>
                            </div>
                          @endif
                      </div>
                    </div>
                        

  @elseif($type=='viewVendorRequestDetail')
                        <div class="row">
                          <div class="col-md-12 text-center"><h3>{{ $data->name ?? 'Vendor' }} detail</h3>
                            <hr>
                          </div>
                         
                           <div class="col-md-4">
                          <p><strong>Name:</strong> {{ $data->name ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                          <p><strong>Email:</strong> {{ $data->email ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                          <p><strong>Password:</strong> {{ $data->original_password ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                          <p><strong>Contact:</strong> {{ $data->phone ?? '' }}</p>
                          </div>

                         
                          <div class="col-md-4">
                            <p><strong>State:</strong> {{ json_decode($data->state_ary)->name ?? '' }}</p>
                          </div>
                        
                          <div class="col-md-4">
                            <p><strong>City:</strong> {{ json_decode($data->city_ary)->name ?? '' }}</p>
                          </div>
                       
                          <div class="col-md-4">
                            <p><strong>Bank Account Type:</strong> {{ $data->bank_account_type ?? '' }}</p>
                          </div>
                       

                          <div class="col-md-4">
                            <p><strong>Bank Account:</strong> {{ $data->bank_account_number ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                            <p><strong>Bank IFSC:</strong> {{ $data->ifsc ?? '' }}</p>
                          </div>


                          <div class="col-md-4">
                            <p><strong>Pan Number:</strong> {{ $data->pan ?? '' }}</p>
                          </div>

                        
                       
                          <div class="col-md-4">
                            <p><strong>Specified Person:</strong> {{ $data->specified_person ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                            <p><strong>Address:</strong> {{ $data->address ?? '' }}</p>
                          </div>

                       
                          <div class="col-md-4">
                            <p><strong>Location:</strong> {{ $data->location ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                            <p><strong>Zip:</strong> {{ $data->zip ?? '' }}</p>
                          </div>


                          <div class="col-md-4">
                            <p><strong>Constitution:</strong> {{ $data->constitution ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                            <p><strong>GST:</strong> {{ $data->gst ?? '' }}</p>
                          </div>

                          @if($data->constitution=='Others')
                          <div class="col-md-12">
                            <p><strong>Specify If Constitution Others:</strong> {{ $data->specify_if_other ?? '' }}</p>
                          </div>
                          @endif

                        <!-- /.form-group -->
                      <!-- /.col -->
                     </div>

           

   @endif
  
