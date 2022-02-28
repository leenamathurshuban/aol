@extends('layouts.vendor')

@section('header')

@endsection

@section('body')

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  {{ link_to_route('vendor.home','Home',[],[]) }}
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- ./col -->
            <div class="col-md-12">
              <h1 class="text-danger text-center">
                <marquee behavior="alternate"> Vendor dashboard page under maintenance...</marquee>
              </h1>
            </div>


        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

@endsection

@section('footer')

@endsection