@extends('layouts.admin')

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
              	{{link_to_route('admin.home','Home',[],[])}}
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
                		{!! Form::open(['route'=>['admin.profileSave'],'files'=>true,'class'=>'form-horizontal'])!!}
                    
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
                    {!! Form::open(['route'=>['admin.passwordSave'],'files'=>true,'class'=>'form-horizontal'])!!}
                    
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