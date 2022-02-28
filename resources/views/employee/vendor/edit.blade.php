@extends('layouts.employee')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Vendor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.vendors','Vendors',[],[])}}
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
            <h3 class="card-title">Edit Vendor</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['employee.updateVendor',$data->vendor_code,$page],'files'=>true])}}
              <div class="row">

             
                 <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Name','Name') }}
                    {{ Form::text('name',$data->name,['class'=>'form-control','placeholder'=>'Vendor name']) }}
                    <span class="text-danger">{{ $errors->first('name')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('email','Email') }}
                    {{ Form::text('email',$data->email,['class'=>'form-control','placeholder'=>'Email']) }}
                    <span class="text-danger">{{ $errors->first('email')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('password','Password') }}
                    {{ Form::text('password',$data->original_password,['class'=>'form-control','placeholder'=>'Password']) }}
                    <span class="text-danger">{{ $errors->first('password')}}</span>
                  </div>
                </div>
                 <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('phone','Phone') }}
                    {{ Form::text('phone',$data->phone,['class'=>'form-control','placeholder'=>'Phone']) }}
                    <span class="text-danger">{{ $errors->first('phone')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('bank_account_type','Bank Account Type') }}
                    {{ Form::select('bank_account_type',\App\Helpers\Helper::bankAccountType(),$data->bank_account_type,['class'=>'form-control custom-select select2','placeholder'=>'Bank account type']) }}
                    <span class="text-danger">{{ $errors->first('bank_account_type')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('bank_account_number','Bank Account Number') }}
                    {{ Form::text('bank_account_number',$data->bank_account_number,['class'=>'form-control','placeholder'=>'Bank name']) }}
                    <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('ifsc','IFSC Code') }}
                    {{ Form::text('ifsc',$data->ifsc,['class'=>'form-control','placeholder'=>'IFSC Code']) }}
                    <span class="text-danger">{{ $errors->first('ifsc')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('pan','PAN Number') }}
                    {{ Form::text('pan',$data->pan,['class'=>'form-control','placeholder'=>'PAN number Code','required'=>true]) }}
                    <span class="text-danger">{{ $errors->first('pan')}}</span>
                  </div>
                </div>
                @if(Auth::guard('employee')->user()->role_id==8)
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('specified_person','Specified Person') }}
                    {{ Form::select('specified_person',['Yes'=>'Yes','No'=>'No'],$data->specified_person,['class'=>'form-control custom-select select2','placeholder'=>'Specified person']) }}
                    <span class="text-danger">{{ $errors->first('approver_manager')}}</span>
                  </div>
                </div>
                @endif
                <div class="col-md-6">
                 <div class="form-group" id="stateDiv">
                    {{ Form::label('State','State') }}
                    {!!Form::select('state', $states, $data->state_id, ['placeholder' => 'Select State','class'=>'form-control custom-select select2','id'=>'state'])!!}
                    <span class="text-danger">{{ $errors->first('state')}}</span>
                  </div>
                </div>
                    
                  <div class="col-md-6">
                   <div class="form-group" id="cityDiv">
                      {{ Form::label('City','City') }}
                      {!!Form::select('city', $cities, $data->city_id, ['placeholder' => 'Select City','class'=>'form-control custom-select select2'])!!}
                      <span class="text-danger">{{ $errors->first('city')}}</span>
                    </div>
                  </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('address','Address') }}
                    {{ Form::text('address',$data->address,['class'=>'form-control','placeholder'=>'Address']) }}
                    <span class="text-danger">{{ $errors->first('address')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('area','Area') }}
                    {{ Form::text('location',$data->location,['class'=>'form-control','placeholder'=>'Area']) }}
                    <span class="text-danger">{{ $errors->first('location')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('zip','Zip') }}
                    {{ Form::text('zip',$data->zip,['class'=>'form-control','placeholder'=>'Zip']) }}
                    <span class="text-danger">{{ $errors->first('zip')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('constitution','Constitution') }}
                    {{ Form::select('constitution',$constitutions,$data->constitution,['class'=>'form-control custom-select select2','placeholder'=>'Choose Constitutions']) }}
                    <span class="text-danger">{{ $errors->first('constitution')}}</span>
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('gst','GST Number') }}
                    {{ Form::text('gst',$data->gst,['class'=>'form-control','placeholder'=>'GST Number']) }}
                    <span class="text-danger">{{ $errors->first('gst')}}</span>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('specify_if_other','Specify If Other') }}
                    {{ Form::textarea('specify_if_other',$data->specify_if_other,['class'=>'form-control','placeholder'=>'Specify if other','rows'=>5]) }}
                    <span class="text-danger">{{ $errors->first('specify_if_other')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                      <div class="form-group">
                        {!!Form::label('Pan Image', 'Pan Image')!!}

                           {!!Form::file('pan_file',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                           @if($data->pan_file)
                            <img src="{{ url('public/'.$data->pan_file) }}" alt="user" class="img-fluit edit-product-img" style="max-width: 100px;max-height: 100px;" />
                          @endif
                          @if($errors->has('pan_file'))
                            <p class="text-danger">{{$errors->first('pan_file')}}</p>
                          @endif
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                        {!!Form::label('Cancel Cheque', 'Cancel Cheque')!!}

                           {!!Form::file('cancel_cheque_file',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-2'])!!}
                           @if($data->cancel_cheque_file)
                            <img src="{{ url('public/'.$data->cancel_cheque_file) }}" alt="user" class="img-fluit edit-product-img" style="max-width: 100px;max-height: 100px;" />
                          @endif
                          @if($errors->has('cancel_cheque_file'))
                            <p class="text-danger">{{$errors->first('cancel_cheque_file')}}</p>
                          @endif
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
<script type="text/javascript">
  $(document).ready(function(){
      $('#state').on('change',function(){
      var sId=$(this).val();
      if (sId!='') {
        var url="{{ route('employee.getVendorCityByState') }}";
             
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