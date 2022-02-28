@extends('layouts.admin')

@section('header') @endsection

@section('body')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
                {{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('admin.employees','Employees',[],[])}}
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
            <h3 class="card-title">Edit Employee</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['admin.updateEmployees',$data->employee_code,$page],'files'=>true])}}
              <div class="row">

                <div class="col-md-4">
                 <div class="form-group" id="stateDiv">
                    {{ Form::label('role','Role') }}
                    {!!Form::select('role', $roles, $data->role_id, ['placeholder' => 'Select role','class'=>'form-control custom-select select2','id'=>'role'])!!}
                    <span class="text-danger">{{ $errors->first('role')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group" id="stateDiv">
                    {{ Form::label('assign_process','Assign Process') }}
                    {!!Form::select('assign_process[]', $AssignProcess, $empAsAry, ['class'=>'form-control custom-select select2','id'=>'assign_process','multiple'=>true,'required'=>true])!!}
                    <span class="text-danger">{{ $errors->first('assign_process')}}</span>
                  </div>
                </div>

                 <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('Name','Name') }}
                    {{ Form::text('name',$data->name,['class'=>'form-control','placeholder'=>'Station name']) }}
                    <span class="text-danger">{{ $errors->first('name')}}</span>
                  </div>
                </div>

                 <div class="col-md-4">
                   <div class="form-group">
                      {{ Form::label('employee_code','Employee Code') }}
                      {{ Form::text('employee_code',$data->employee_code,['class'=>'form-control','placeholder'=>'Employee code']) }}
                      <span class="text-danger">{{ $errors->first('employee_code')}}</span>
                    </div>
                  </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('email','Email') }}
                    {{ Form::text('email',$data->email,['class'=>'form-control','placeholder'=>'Email']) }}
                    <span class="text-danger">{{ $errors->first('email')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('password','New Password') }}
                    {{ Form::text('password','',['class'=>'form-control','placeholder'=>'Password']) }}
                    <span class="text-danger">{{ $errors->first('password')}}</span>
                  </div>
                </div>
                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('confirm_password','Confirm Password') }}
                    {{ Form::text('confirm_password','',['class'=>'form-control','placeholder'=>'Confirm Password']) }}
                    <span class="text-danger">{{ $errors->first('confirm_password')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('tag','Tag (Employee / Contingent)') }}
                    {{ Form::text('tag',$data->tag,['class'=>'form-control','placeholder'=>'Tag (Employee / Contingent)']) }}
                    <span class="text-danger">{{ $errors->first('tag')}}</span>
                  </div>
                </div>

                

                 <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('phone','Phone') }}
                    {{ Form::text('phone',$data->phone,['class'=>'form-control','placeholder'=>'Phone']) }}
                    <span class="text-danger">{{ $errors->first('phone')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group" id="stateDiv">
                    {{ Form::label('State','State') }}
                    {!!Form::select('state', $states, $data->state_id, ['placeholder' => 'Select State','class'=>'form-control custom-select select2','id'=>'state'])!!}
                    <span class="text-danger">{{ $errors->first('state')}}</span>
                  </div>
                </div>
                    
                  <div class="col-md-4">
                   <div class="form-group" id="cityDiv">
                      {{ Form::label('City','City') }}
                      {!!Form::select('city', $cities, $data->city_id, ['placeholder' => 'Select City','class'=>'form-control custom-select select2'])!!}
                      <span class="text-danger">{{ $errors->first('city')}}</span>
                    </div>
                  </div>
                

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('bank_account_type','Bank Account Type') }}
                    {{ Form::select('bank_account_type',\App\Helpers\Helper::bankAccountType(),$data->bank_account_type,['class'=>'form-control custom-select select2','placeholder'=>'Bank account type']) }}
                    <span class="text-danger">{{ $errors->first('bank_account_type')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('bank_account_number','Bank Account Number') }}
                    {{ Form::text('bank_account_number',$data->bank_account_number,['class'=>'form-control','placeholder'=>'Bank name']) }}
                    <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('ifsc','IFSC Code') }}
                    {{ Form::text('ifsc',$data->ifsc,['class'=>'form-control','placeholder'=>'IFSC Code']) }}
                    <span class="text-danger">{{ $errors->first('ifsc')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('pan','PAN Number') }}
                    {{ Form::text('pan',$data->pan,['class'=>'form-control','placeholder'=>'PAN number Code']) }}
                    <span class="text-danger">{{ $errors->first('pan')}}</span>
                  </div>
                </div>

                 <div class="col-md-4">
                   <div class="form-group">
                      {{ Form::label('approver_manager','Approver Manager') }}
                      {!!Form::select('approver_manager', $managers, $data->approver_manager, ['placeholder' => 'Approver manager','class'=>'form-control custom-select select2','id'=>'approver_manager'])!!}
                      <span class="text-danger">{{ $errors->first('approver_manager')}}</span>
                    </div>
                  </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('specified_person','Specified Person') }}
                    {{ Form::select('specified_person',['Yes'=>'Yes','No'=>'No'],$data->specified_person,['class'=>'form-control custom-select select2','placeholder'=>'Specified person']) }}
                    <span class="text-danger">{{ $errors->first('approver_manager')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                 <div class="form-group">
                    {{ Form::label('address','Address') }}
                    {{ Form::text('address',$data->address,['class'=>'form-control','placeholder'=>'Address']) }}
                    <span class="text-danger">{{ $errors->first('address')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('Address 2','Address 2') }}
                    {{ Form::text('location',$data->location,['class'=>'form-control','placeholder'=>'Address 2']) }}
                    <span class="text-danger">{{ $errors->first('location')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('zip','Zip') }}
                    {{ Form::text('zip',$data->zip,['class'=>'form-control','placeholder'=>'Zip']) }}
                    <span class="text-danger">{{ $errors->first('zip')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                  {{ Form::label('medical_welfare','Medical Welfare category access') }}
                  <div class="form-group">
                    <div class="icheck-primary d-inline">
                      {{ Form::checkbox('medical_welfare','Yes',$data->medical_welfare,['class'=>'form-control','placeholder'=>'Medical Welfare category access','id'=>'medical_welfare']) }}
                      {{ Form::label('medical_welfare','Medical Welfare category access') }}
                    </div>
                  </div>
                  <span class="text-danger">{{ $errors->first('medical_welfare')}}</span>
                </div>
              
               <!--  <button class="btn btn-danger"><i class="fa fa-minus"></i></button> -->
                <!-- /.col  -->
              </div>

              <!-- bank account -->
              <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-3">
                       <div class="form-group">
                            {{ Form::label('Account Number','Account Number',['class'=>'sr']) }}
                          </div>
                      </div>
                      <div class="col-md-3">
                       <div class="form-group">
                            {{ Form::label('IFSC','IFSC') }}
                          </div>
                      </div>
                      <div class="col-md-3">
                       <div class="form-group">
                            {{ Form::label('Bank Name','Bank Name') }}
                          </div>
                      </div>
                      <div class="col-md-3">
                       <div class="form-group">
                            {{ Form::label('Branch Code','Branch Code') }}
                          </div>
                      </div>
                      
                  </div>
              </div>
              <div class="col-md-12">
                  @forelse($data->bankAccount as $key => $val)
                    @php $key = rand(1111,9999).$key;@endphp
                  <div class="row" id="removeItemRow{{$key}}">
                     <div class="col-md-3">
                       <div class="form-group">
                             {{ Form::text('bank_account_number[]',$val->bank_account_number,['class'=>'form-control','placeholder'=>'Account Number','required'=>true,'id'=>'']) }}
                            <span class="text-danger">{{ $errors->first('bank_account_number.*')}}</span>
                          </div>
                      </div>
                      <div class="col-md-3">
                       <div class="form-group">
                            {{ Form::text('ifsc[]',$val->ifsc,['class'=>'form-control','placeholder'=>'IFSC','required'=>true,'id'=>'']) }}
                            <span class="text-danger">{{ $errors->first('ifsc.*')}}</span>
                          </div>
                      </div>
                      <div class="col-md-3">
                       <div class="form-group">
                            {{ Form::text('bank_name[]',$val->bank_name,['class'=>'form-control','placeholder'=>'Bank Name','required'=>true,'id'=>'']) }}
                            
                            <span class="text-danger">{{ $errors->first('cost_center.*')}}</span>
                          </div>
                      </div>
                      <div class="col-md-2">
                       <div class="form-group">
                             {{ Form::text('branch_code[]',$val->branch_code,['class'=>'form-control','placeholder'=>'Branch Code','required'=>true,'id'=>'']) }}
                            <span class="text-danger">{{ $errors->first('branch_code.*')}}</span>
                          </div>
                      </div>
                      <div class="col-md-1 ItemRemove">
                          <div class="remRow_box">
                            <button type="button" class="btn btn-danger" onClick="removeItemRow({{$key}})"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>
                        </div>
                      </div>
                  </div>
                  @empty
                    <div class="row">
                       <div class="col-md-3">
                         <div class="form-group">
                               {{ Form::text('bank_account_number[]','',['class'=>'form-control','placeholder'=>'Account Number','required'=>true,'id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('bank_account_number.*')}}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                         <div class="form-group">
                              {{ Form::text('ifsc[]','',['class'=>'form-control','placeholder'=>'IFSC','required'=>true,'id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('ifsc.*')}}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                         <div class="form-group">
                              {{ Form::text('bank_name[]','',['class'=>'form-control','placeholder'=>'Bank Name','required'=>true,'id'=>'']) }}
                              
                              <span class="text-danger">{{ $errors->first('cost_center.*')}}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                         <div class="form-group">
                               {{ Form::text('branch_code[]','',['class'=>'form-control','placeholder'=>'Branch Code','required'=>true,'id'=>'']) }}
                              <span class="text-danger">{{ $errors->first('branch_code.*')}}</span>
                            </div>
                        </div>
                    </div>
                  @endforelse
                  <div id="Goods">
                  </div>
                  <div class="col-md-12 text-right">
                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                  </div>
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
  $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-3"><div class="form-group"><input class="form-control" placeholder="Account Number" required="" id="" name="bank_account_number[]" type="text" value=""></div></div><div class="col-md-3"> <div class="form-group"><input class="form-control" placeholder="IFSC" required="" id="" name="ifsc[]" type="text" value=""></div></div><div class="col-md-3"> <div class="form-group"><input class="form-control" placeholder="Bank Name" required="" id="" name="bank_name[]" type="text" value=""></div></div><div class="col-md-2"> <div class="form-group"><input class="form-control" placeholder="Branch Code" required="" id="" name="branch_code[]" type="text" value=""></div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div></div>';
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