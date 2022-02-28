@extends('layouts.employee')

@section('body')
	 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $data->name ?? 'Profile' }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item active">{{ $data->name ?? '' }} Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         {{-- <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    {!! Html::image('assets/admin/dist/img/user4-128x128.jpg',$data->name ?? '',['class'=>'profile-user-img img-fluid img-circle']) !!}
                </div>

                <h3 class="profile-username text-center">{{ $data->name ?? '' }}</h3>

                <p class="text-muted text-center">{{ $data->email ?? '' }}</p>

                 <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul> 

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
           
            <!-- /.card -->
          </div>--}}
          <!-- /.col -->
          @if($errors->first('name') || $errors->first('email'))
            @php $active='active'; @endphp
          @elseif($errors->first('current_password') || $errors->first('new_password') || $errors->first('confirm_password'))
            @php $active2='active'; @endphp
          
          @else
           @php $active='active'; @endphp

          @endif
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link {{ $active ?? ''}}" href="#settings" data-toggle="tab">Settings</a></li>
                 
                  <li class="nav-item"><a class="nav-link {{$active2 ?? ''}}" href="#timeline" data-toggle="tab">Password</a></li>
                  
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                
                	<div class="{{$active ?? ''}} tab-pane" id="settings">
                		{!! Form::open(['route'=>['employee.profileSave'],'files'=>true,'class'=>'form-horizontal'])!!}
                    
                      <div class="form-group row">
                      	{{ Form::label('inputName','Name',['class'=>'col-sm-2 col-form-label'])}}
                        
                        <div class="col-sm-10">
                        	{{ Form::text('name',$data->name ?? '',['class'=>'form-control','id'=>'inputName','placeholder'=>'Name']) }}
                        	
                        	<span class="text-danger">{{ $errors->first('name')}}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                      	{{Form::label('inputEmail','Username',['class'=>'col-sm-2 col-form-label'])}}
                        
                        <div class="col-sm-10">
                        	{{ Form::text('email',$data->email ?? '',['class'=>'form-control','placeholder'=>'Username']) }}
                        	<span class="text-danger">{{ $errors->first('email')}}</span>

                        	
                        </div>
                      </div>
                     <!--  <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                        	{{ Form::submit('Save',['class'=>'btn btn-danger']) }}
                        </div>
                      </div>
                    {!! Form::close()!!}
                  </div>
                  <!-- /.tab-pane -->
                  <div class="{{$active2 ?? ''}} tab-pane" id="timeline">
                    <!-- The timeline -->
                    {!! Form::open(['route'=>['employee.passwordSave'],'files'=>true,'class'=>'form-horizontal'])!!}
                    
                      <div class="form-group row">
                        {{ Form::label('inputName','Current Password',['class'=>'col-sm-3 col-form-label'])}}
                        
                        <div class="col-sm-9">
                          {{ Form::password('current_password',['class'=>'form-control','id'=>'inputName','placeholder'=>'Current Password']) }}
                          
                          <span class="text-danger">{{ $errors->first('current_password')}}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        {{ Form::label('new_password','New Password',['class'=>'col-sm-3 col-form-label']) }}
                        
                        <div class="col-sm-9">
                          {{ Form::password('new_password',['class'=>'form-control','placeholder'=>'New Password']) }}
                          <span class="text-danger">{{ $errors->first('new_password')}}</span>

                          
                        </div>
                      </div>


                      <div class="form-group row">
                        {{ Form::label('confirm_password','Confirm Password',['class'=>'col-sm-3 col-form-label']) }}
                        
                        <div class="col-sm-9">
                          {{ Form::password('confirm_password',['class'=>'form-control','placeholder'=>'Confirm Password']) }}
                          <span class="text-danger">{{ $errors->first('confirm_password')}}</span>

                          
                        </div>
                      </div>
                    
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          {{ Form::submit('Save',['class'=>'btn btn-danger']) }}
                        </div>
                      </div>
                    {!! Form::close()!!}


                  </div>
                  <!-- /.tab-pane -->

                  
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection