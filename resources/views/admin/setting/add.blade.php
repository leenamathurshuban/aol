@extends('layouts.admin')
@section('header') @endsection
@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Setting</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item active">Setting</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Settings</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

          	{{ Form::open(['route'=>['admin.settingSave'],'files'=>true])}}

	            <div class="row">
	              <div class="col-md-6">
	                <div class="form-group">
	                  
	                  {{ Form::label('title','Title') }}
	                  {{ Form::text('title','',['class'=>'form-control','placeholder'=>'Title']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('title')}}</span>

	                </div>
	                <!-- /.form-group -->
	                </div>
	              <!-- /.col -->
	              <div class="col-md-6">
	               <div class="form-group">
	                  {{ Form::label('email','Email') }}
	                  {{ Form::text('email','',['class'=>'form-control','placeholder'=>'Email']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('email')}}</span>
	                </div>
	                <!-- /.form-group -->
	              </div>
	              <!-- /.col -->
	              <div class="col-md-6">
	                <div class="form-group">
	                  {{ Form::label('mobile_number','Mobile') }}
	                  {{ Form::text('mobile_number','',['class'=>'form-control','placeholder'=>'Mobile']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('mobile_number')}}</span>
	                </div>
	                </div>
	              <!-- /.col -->
	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('phone_number','Phone Number') }}
	                  {{ Form::text('phone_number','',['class'=>'form-control','placeholder'=>'Phone Number']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('phone_number')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>
	              <!-- /.col -->
	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('address','Address') }}
	                  {{ Form::text('address','',['class'=>'form-control','placeholder'=>'Address']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('address')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>
	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('city','City') }}
	                  {{ Form::text('city','',['class'=>'form-control','placeholder'=>'City']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('city')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>
	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('pin_code','Pin / Zip Code') }}
	                  {{ Form::text('pin_code','',['class'=>'form-control','placeholder'=>'Pin / Zip Code']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('pin_code')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>
	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('country','Country') }}
	                  {{ Form::text('country','',['class'=>'form-control','placeholder'=>'Country']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('country')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>

	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('light_logo','Light Logo') }}
	                  {{ Form::file('light_logo',['class'=>'form-control','placeholder'=>'Light Logo']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('light_logo')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>
	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('dark_logo','Dark Logo') }}
	                  {{ Form::file('dark_logo',['class'=>'form-control','placeholder'=>'Dark Logo']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('dark_logo')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>
	              <div class="col-md-6">
	                <!-- /.form-group -->
	                <div class="form-group">
	                  
	                  {{ Form::label('favicon_icon','Favicon Icon') }}
	                  {{ Form::file('favicon_icon',['class'=>'form-control','placeholder'=>'Favicon Icon']) }}
	                  
	                  <span class="text-danger">{{ $errors->first('favicon_icon')}}</span>

	                </div>
	                <!-- /.form-group -->
	              </div>

	              @if($socialArray)

	              	@foreach($socialArray as $social)
						<div class="col-md-6">
	                <!-- /.form-group -->
			                <div class="form-group">
			                  
			                  {{ Form::label('country',$social) }}
			                  {{ Form::text('social[]','',['class'=>'form-control','placeholder'=>$social.' link']) }}
			                  
			                  <span class="text-danger">{{ $errors->first($social)}}</span>

			                </div>
			                <!-- /.form-group -->
			              </div>				
	              	@endforeach

	              @endif


	              @if($downloadArray)

	              	@foreach($downloadArray as $download)
						<div class="col-md-6">
	                <!-- /.form-group -->
			                <div class="form-group">
			                  
			                  {{ Form::label('country',$download) }}
			                  {{ Form::text('download[]','',['class'=>'form-control','placeholder'=>$download.' link']) }}
			                  
			                  <span class="text-danger">{{ $errors->first($download)}}</span>

			                </div>
			                <!-- /.form-group -->
			              </div>				
	              	@endforeach

	              @endif







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

        <!-- SELECT2 EXAMPLE -->
       
        <!-- /.card -->

        
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@endsection
@section('footer') @endsection
