<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php 
  $setting = \App\Setting::first();
@endphp
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->title ?? 'Laravel' }}</title>
  @if(isset($setting->favicon_icon))
    <link rel="shortcut icon" href="{{ url('public/'.($setting->favicon_icon ?? '')) }}">
  @endif 
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  {!! Html::style('assets/admin/plugins/fontawesome-free/css/all.min.css') !!}
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  {!! Html::style('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}
  {!! Html::style('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}
    <!-- Tempusdominus Bbootstrap 4 -->
  {!! Html::style('assets/admin/plugins/jqvmap/jqvmap.min.css') !!}

  <!-- DataTables -->
  {!! Html::style('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}
  {!! Html::style('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}

    <!-- Select2 -->
  {!! Html::style('assets/admin/plugins/select2/css/select2.min.css') !!}
  {!! Html::style('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') !!}
  
  {!! Html::style('assets/admin/dist/css/adminlte.min.css') !!}
  {!! Html::style('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') !!}
  {!! Html::style('assets/admin/plugins/daterangepicker/daterangepicker.css') !!}
  {!! Html::style('assets/admin/plugins/summernote/summernote-bs4.css') !!}

 <!-- Ionicons -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {!! Html::style('assets/admin/dist/css/style.css') !!}

    {!! Html::style('assets/admin/dist/css/shuban_style.css') !!}
    
  @yield('header')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts.adminError')
    	<section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Fill Vendor From</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Fill Vendor Account Detail</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content">
          <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
              <!-- /.card-header -->
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <div class="card-body">
                    {{ Form::open(['route'=>['saveVendorForm'],'files'=>true])}}
                      <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('Name','Name') }}
                            {{ Form::text('name','',['class'=>'form-control','placeholder'=>'Station name']) }}
                            <span class="text-danger">{{ $errors->first('name')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('email','Email') }}
                            {{ Form::text('email','',['class'=>'form-control','placeholder'=>'Email']) }}
                            <span class="text-danger">{{ $errors->first('email')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('password','Password') }}
                            {{ Form::text('password','',['class'=>'form-control','placeholder'=>'Password']) }}
                            <span class="text-danger">{{ $errors->first('password')}}</span>
                          </div>
                        </div>
                         <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('phone','Phone') }}
                            {{ Form::text('phone','',['class'=>'form-control','placeholder'=>'Phone']) }}
                            <span class="text-danger">{{ $errors->first('phone')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group" id="stateDiv">
                            {{ Form::label('State','State') }}
                            {!!Form::select('state', $states, '', ['placeholder' => 'Select State','class'=>'form-control custom-select select2','id'=>'state'])!!}
                            <span class="text-danger">{{ $errors->first('state')}}</span>
                          </div>
                        </div>
                            @php
                              $cityAry=[];
                              $cityId='';
                              if(old('state')){
                                $cityAry=\App\City::where('state_id',old('state'))->pluck('name','id');
                              }
                              if(old('city')){
                                $cityId=old('city');
                              }
                            @endphp
                          <div class="col-md-6">
                           <div class="form-group" id="cityDiv">
                              {{ Form::label('City','City') }}
                              {!!Form::select('city', $cityAry, $cityId, ['placeholder' => 'Select City','class'=>'form-control custom-select select2'])!!}
                              <span class="text-danger">{{ $errors->first('city')}}</span>
                            </div>
                          </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('bank_account_type','Bank Account Type') }}
                            {{ Form::select('bank_account_type',\App\Helpers\Helper::bankAccountType(),'',['class'=>'form-control custom-select select2','placeholder'=>'Bank account type']) }}
                            <span class="text-danger">{{ $errors->first('bank_account_type')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('bank_account_number','Bank Account Number') }}
                            {{ Form::text('bank_account_number','',['class'=>'form-control','placeholder'=>'Bank name']) }}
                            <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('ifsc','IFSC Code') }}
                            {{ Form::text('ifsc','',['class'=>'form-control','placeholder'=>'IFSC Code']) }}
                            <span class="text-danger">{{ $errors->first('ifsc')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('pan','PAN Number') }}
                            {{ Form::text('pan','',['class'=>'form-control','placeholder'=>'PAN number Code']) }}
                            <span class="text-danger">{{ $errors->first('pan')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('specified_person','Specified Person') }}
                            {{ Form::select('specified_person',['Yes'=>'Yes','No'=>'No'],'',['class'=>'form-control custom-select select2','placeholder'=>'Specified person']) }}
                            <span class="text-danger">{{ $errors->first('specified_person')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('address','Address') }}
                            {{ Form::text('address','',['class'=>'form-control','placeholder'=>'Address']) }}
                            <span class="text-danger">{{ $errors->first('address')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {{ Form::label('location','Location') }}
                            {{ Form::text('location','',['class'=>'form-control','placeholder'=>'Location']) }}
                            <span class="text-danger">{{ $errors->first('location')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {{ Form::label('zip','Zip') }}
                            {{ Form::text('zip','',['class'=>'form-control','placeholder'=>'Zip']) }}
                            <span class="text-danger">{{ $errors->first('zip')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                            {{ Form::label('constitution','Constitution') }}
                            {{ Form::select('constitution',$constitutions,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Constitutions']) }}
                            <span class="text-danger">{{ $errors->first('constitution')}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {{ Form::label('gst','GST Number') }}
                            {{ Form::text('gst','',['class'=>'form-control','placeholder'=>'GST Number']) }}
                            <span class="text-danger">{{ $errors->first('gst')}}</span>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            {{ Form::label('specify_if_other','Specify If Other') }}
                            {{ Form::textarea('specify_if_other','',['class'=>'form-control','placeholder'=>'Specify if other','rows'=>5]) }}
                            <span class="text-danger">{{ $errors->first('specify_if_other')}}</span>
                          </div>
                        </div>
                       <!--  <button class="btn btn-danger"><i class="fa fa-minus"></i></button> -->
                        <!-- /.col  -->
                      </div>
                    <!-- /.row -->
                      <div class="card-footer">
                        {!! Form::submit('Save',['class'=>'btn btn-outline-primary']) !!}
                      </div>
                   {{ Form::close() }}
                    <!-- /.row -->
                  </div>
                </div>
                <div class="col-md-1"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>

  <!-- /.content-wrapper -->
 
  {{--  <footer class="main-footer">
         <strong>Copyright &copy; 2014-2019 <a href="#">Admin</a>.</strong>
          All rights reserved.
          <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.5
          </div> 
  </footer>--}}

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
  {!! Html::script('assets/admin/plugins/jquery/jquery.min.js') !!}
  <!-- jQuery UI 1.11.4 -->
  {!! Html::script('assets/admin/plugins/jquery-ui/jquery-ui.min.js') !!}
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
  {!! Html::script('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}

  <!-- DataTables -->
  {!! Html::script('assets/admin/plugins/datatables/jquery.dataTables.min.js') !!}
  {!! Html::script('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}
  {!! Html::script('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}
  {!! Html::script('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}

    {!! Html::script('assets/admin/plugins/select2/js/select2.full.min.js') !!}

  {!! Html::script('assets/admin/plugins/chart.js/Chart.min.js') !!}
  {!! Html::script('assets/admin/plugins/sparklines/sparkline.js') !!}

<!-- JQVMap -->
{!! Html::script('assets/admin/plugins/jqvmap/jquery.vmap.min.js') !!}
{!! Html::script('assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js') !!}
{!! Html::script('assets/admin/plugins/jquery-knob/jquery.knob.min.js') !!}
{!! Html::script('assets/admin/plugins/moment/moment.min.js') !!}

{!! Html::script('assets/admin/plugins/daterangepicker/daterangepicker.js') !!}
{!! Html::script('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}
{!! Html::script('assets/admin/plugins/summernote/summernote-bs4.min.js') !!}
{!! Html::script('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}
{!! Html::script('assets/admin/dist/js/adminlte.js') !!}
{!! Html::script('assets/admin/dist/js/pages/dashboard.js') !!}
{{-- !! Html::script('assets/admin/dist/js/demo.js') !! --}}

{!! Html::script('assets/admin/dist/js/adminlte.min.js') !!}

@yield('footer')
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
</script><script type="text/javascript">
  $(document).ready(function(){
      $('#state').on('change',function(){
      var sId=$(this).val();
      if (sId!='') {
        var url="{{ route('admin.getCityByState') }}";
             
              $.ajax({
                type:"POST",
                url:url,
                data:{sId:sId , _token: '{{csrf_token()}}',type:'getCityByState'},
                beforeSend: function(){
                 //$('#preloader').show();
                },
                success:function(response){
                   $('#cityDiv').empty().append(response);
                  //$('#preloader').hide();
                }
              });
      }else{
        $('#cityDiv').empty();
      }
    });
  });


</script>
</body>
</html>
