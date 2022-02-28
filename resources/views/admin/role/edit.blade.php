@extends('layouts.admin')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('admin.roles','Role',[],[])}}
              </li>
              <li class="breadcrumb-item active">Update</li>
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
            <h3 class="card-title">Update Role</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['admin.updateRole',$data->slug],'files'=>true])}}

              <div class="row">
                <div class="col-md-4">
                  <!-- /.form-group -->
                 <div class="form-group">
                    
                    {{ Form::label('Role','Role') }}
                    {{ Form::text('name',$data->name,['class'=>'form-control','placeholder'=>'Role name']) }}
                    
                    <span class="text-danger">{{ $errors->first('name')}}</span>

                  </div>
                  <!-- /.form-group -->
                </div>
               
                <!-- /.col -->
               

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