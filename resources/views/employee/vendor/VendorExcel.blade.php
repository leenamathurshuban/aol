@extends('layouts.employee')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vendor Excel</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item active">Vendor Excel</li>
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
            <h3 class="card-title">Vendor Excel</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              
                    <div class="col-sm-12 col-md-6">
                      {!! Form::open(['route'=>['employee.importVendor'],'files'=>true])!!}
                        <div class="row">
                          <div class="col-md-7">
                            {{ Form::file('bulk_vendor_data',['class'=>'form-control','title'=>'Import excel','required'=>true]) }}
                          </div>
                          <div class="col-md-5">
                            {{ Form::submit('Upload',['class'=>'btn btn-dark w-100','title'=>'Upload data']) }}
                          </div>
                          <div class="text text-danger col-md-12">
                              @if ($failures = Session::get('sheeterror'))
                                  @foreach($failures->errors() as $failure)
                                      There was an error on row {{ $failures->row() }}. {{ $failure }}
                                  @endforeach
                              @endif
                          </div>
                        </div>
                        {!! Form::close() !!}
                        </div>
                        <div class="col-sm-12 col-md-3">
                          {{ link_to_route('employee.exportVendor','Download Excel Format',['format'],['class'=>'btn btn-block btn-dark','title'=>'Download Excel Format']) }}
                        </div>

                        <div class="col-sm-12 col-md-3">
                            {{ link_to_route('employee.exportVendor','Download All Vendor',[],['class'=>'btn btn-block btn-outline-primary','title'=>'Export Format']) }}
                        </div>

                    
            </div>
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

 @endsection