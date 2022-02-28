@extends('layouts.admin')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Share Vendor Form link</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item active">Share Vendor Form link</li>
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
            <h3 class="card-title">Share Vendor Form link</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['admin.VendorFormMail'],'files'=>true])}}
              <div class="row">
	              	<div class="col-md-6">
	                 <div class="form-group">
	                    {{ Form::label('Email','Vendor Email Address') }}
	                    {{ Form::email('email','',['class'=>'form-control','placeholder'=>'Email Address','required'=>true]) }}
	                    <span class="text-danger">{{ $errors->first('email')}}</span>
	                  </div>
	              </div>
	              <div class="col-md-6">
	                 <div class="form-group">
	                    {{ Form::label('Subject','Email Subject') }}
	                    {{ Form::text('subject','',['class'=>'form-control','placeholder'=>'Email Subject','required'=>true]) }}
	                    <span class="text-danger">{{ $errors->first('subject')}}</span>
	                  </div>
	              </div>
	              <div class="col-md-12">
	               <div class="form-group">
	                  {{ Form::label('message','Email Message') }}
	                  {{ Form::textarea('message','',['class'=>'form-control','placeholder'=>'Email Message','required'=>true,'rows'=>5]) }}
	                  <span class="text-danger">{{ $errors->first('message')}}</span>
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
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@endsection

@section('footer')

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyB0tRTKcT7H4wgVwgpEzGs9IlhvE8bZufY&libraries=places"></script>

<script type="text/javascript">
    function initializeAutocomplete(){
    var a='';
    var c='';
    var l='';
    var ln='';
    var input = document.getElementById('locality');
    // var options = {
    //   types: ['(regions)'],
    //   componentRestrictions: {country: "IN"}
    // };
    var options = {}

    var autocomplete = new google.maps.places.Autocomplete(input, options);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();
      var lat = place.geometry.location.lat();
      var lng = place.geometry.location.lng();
      var placeId = place.place_id;
      // to set city name, using the locality param
      var componentForm = {
        locality: 'short_name',
      };
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById("city").value = val;
        }
      }
      document.getElementById("latitude").value = lat;
      document.getElementById("longitude").value = lng;
      document.getElementById("location_id").value = placeId;

        var a=$('#locality').val();
        var c=val;
        var l=lat;
        var ln=lng;

    });

    document.getElementById("city").value = c;
    document.getElementById("latitude").value = l;
      document.getElementById("longitude").value = ln;



  }
</script>
 @endsection