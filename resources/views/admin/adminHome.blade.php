@extends('layouts.admin')

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
                  {{ link_to_route('admin.home','Home',[],[]) }}
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
          <!--  -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{\App\Employee::count()}}</h3>
                <p>Employee</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-users"></i>
              </div>
              {!! Html::decode(link_to_route('admin.employees','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{\App\AssignProcess::count()}}</h3>
                <p>Assign Process</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-book"></i>
              </div>
              {!! Html::decode(link_to_route('admin.assignProcess','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{\App\Apex::count()}}</h3>
                <p>Apex</p>
              </div>
              <div class="icon">
                <i class="nav-icon fab fa-atlassian"></i>
              </div>
              {!! Html::decode(link_to_route('admin.apexs','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{\App\BankAccount::count()}}</h3>
                <p>Bank Account</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-university"></i>
              </div>
              {!! Html::decode(link_to_route('admin.bankAccounts','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{\App\Role::count()}}</h3>
                <p>Role</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-user-tag"></i>
              </div>
              {!! Html::decode(link_to_route('admin.roles','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{\App\ClaimType::count()}}</h3>
                <p>Nature Of Claim</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-tree"></i>
              </div>
              {!! Html::decode(link_to_route('admin.claimTypes','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{\App\City::count()}}</h3>
                <p>City</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-city"></i>
              </div>
              {!! Html::decode(link_to_route('admin.cities','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{\App\State::count()}}</h3>
                <p>State</p>
              </div>
              <div class="icon">
                <i class="nav-icon fa fa-globe"></i>
              </div>
              {!! Html::decode(link_to_route('admin.states','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{\App\Setting::count()}}</h3>
                <p>Setting</p>
              </div>
              <div class="icon">
                <i class="nav-icon fa fa-cog"></i>
              </div>
              {!! Html::decode(link_to_route('admin.setting','More info <i class="fas fa-arrow-circle-right"></i>','',['class'=>'small-box-footer'])) !!}
            </div>
          </div>
          <!--  -->
        </div>
      {{--  <div class="row">
          <!-- ./col -->
            <div class="col-md-12">
              <h1 class="text-danger text-center">
                <marquee behavior="alternate">Dashboard page under maintenance...</marquee>
              </h1>
            </div>
        </div>--}}
        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

@endsection

@section('footer')

@endsection