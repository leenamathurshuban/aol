@extends('layouts.admin')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Bank Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('admin.bankAccounts','Bank Account',[],[])}}
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
            <h3 class="card-title">Update Bank Account</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['admin.updateBankAccount',$data->slug],'files'=>true])}}

              <div class="row">
                <div class="col-md-4">
                     <div class="form-group">
                        {{ Form::label('Apex','Apex') }}
                        {{ Form::select('apex',$apexes,\App\Apex::where('id',$data->apexe_id)->first()->slug ?? '',['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                        <span class="text-danger">{{ $errors->first('apex')}}</span>
                      </div>
                    </div>

                  <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('Bank Name','Bank Name') }}
                    {{ Form::text('bank_name',$data->bank_name,['class'=>'form-control','placeholder'=>'Bank name']) }}
                    <span class="text-danger">{{ $errors->first('bank_name')}}</span>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('Bank Account Number','Bank Account Number') }}
                    {{ Form::text('bank_account_number',$data->bank_account_number,['class'=>'form-control','placeholder'=>'Bank Account Number']) }}
                    <span class="text-danger">{{ $errors->first('bank_account_number')}}</span>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('Branch Address','Branch Address') }}
                    {{ Form::text('branch_address',$data->branch_address,['class'=>'form-control','placeholder'=>'Branch Address']) }}
                    <span class="text-danger">{{ $errors->first('branch_address')}}</span>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('Branch Code','Branch Code') }}
                    {{ Form::text('branch_code',$data->branch_code,['class'=>'form-control','placeholder'=>'Branch Code']) }}
                    <span class="text-danger">{{ $errors->first('branch_code')}}</span>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('Account Holder Name','Account Holder Name') }}
                    {{ Form::text('bank_account_holder',$data->bank_account_holder,['class'=>'form-control','placeholder'=>'Account Holder Name']) }}
                    <span class="text-danger">{{ $errors->first('bank_account_holder')}}</span>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('Bank IFSC','Bank IFSC Code') }}
                    {{ Form::text('ifsc',$data->ifsc,['class'=>'form-control','placeholder'=>'Bank IFSC']) }}
                    <span class="text-danger">{{ $errors->first('ifsc')}}</span>
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