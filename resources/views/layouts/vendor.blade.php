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

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav nav_right">
      <li class="nav-item d-none d-sm-inline-block">
          
             {!! Html::decode(link_to_route('vendor.home','<i class="fas fa-home"></i> Home',[],['class'=>'nav-link'])) !!}
          
      </li>

       <li class="nav-item d-none d-sm-inline-block">
        {!! Html::decode(link_to_route('vendorLogout','<i class="fas fa-sign-out-alt"></i> Logout',[],['class'=>'nav-link','onclick'=>"event.preventDefault();document.getElementById('logout-form').submit();"])) !!}
        
        {!!Form::open(['route'=>['vendorLogout'],'id'=>'logout-form','style'=>'display: none;']) !!}

        {!!Form::close() !!}

        
      </li>
    </ul>

    <!-- SEARCH FORM -->


    <!-- Right navbar links -->
   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
  
        @if(isset($setting->dark_logo))
          {!! Html::decode(link_to_route('vendor.home',Html::image('public/'.$setting->dark_logo,$setting->title ?? '',['class'=>'brand-image img-circle elevation-3','style'=>'opacity: .8']).'<span class="brand-text font-weight-light">'.$setting->title ?? ''.'</span>',[],['class'=>'brand-link']) ) !!}
        @else
          {!! Html::decode(link_to_route('vendor.home',Html::image('assets/admin/dist/img/AdminLTELogo.png','AdminLTE Logo',['class'=>'brand-image img-circle elevation-3','style'=>'opacity: .8']).'<span class="brand-text font-weight-light">Home</span>',[],['class'=>'brand-link']) ) !!}
        @endif
  
    
   

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       
        <div class="info">
         
            {{ link_to_route('vendor.profile',Auth::guard('vendor')->user()->name ?? '' , [], ['class'=>'d-block']) }}
          
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            {!! Html::decode(link_to_route('vendor.home','<i class="nav-icon fas fa-tachometer-alt"></i><p>Home</p>',[],['class'=>'nav-link '.Helper::classActiveByRouteName(['vendor.home'])])) !!}
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts.adminError')

    @yield('body')

    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
  {{--  <strong>Copyright &copy; 2014-2019 <a href="#">Admin</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div> --}}
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
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
<script type="text/javascript">
       function removeData() {
           if(confirm("Are you sure you want to delete this?")){
                return true;
           }
            return false;
       }

   </script>
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
</body>
</html>
