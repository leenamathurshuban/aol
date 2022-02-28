@extends('layouts.employee')

@section('header')

@endsection

@section('body')

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">{{ Auth::guard('employee')->user()->role->name }}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
               {{-- <li class="breadcrumb-item">
                  {{ link_to_route('employee.home','Home',[],[]) }}
                </li>--}}
                <li class="breadcrumb-item active">{{ Auth::guard('employee')->user()->name }}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        {{--<div class="row employee_dashbaord">
          @forelse($data->EmpAssignProcess as $key => $val)
            @if(isset($val->assignProcessData->id) && $val->assignProcessData->id)
              <div class="col-sm-3">
                <div class="employee_col">
                  <h3>
                    {{ link_to_route('employee.userForm',$val->assignProcessData->name,[$val->assignProcessData->slug],[])}}
                  </h3>
                </div>
              </div>
            @endif
          @empty

          @endforelse
        </div>--}}
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

@endsection

@section('footer')

@endsection