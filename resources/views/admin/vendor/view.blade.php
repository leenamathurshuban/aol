@extends('layouts.admin')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $data->name ?? 'Charging Station' }} detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('admin.home','Home',[],[])}}
              </li>
              
              <li class="breadcrumb-item">
                {{link_to_route('admin.chargingStations','Charging Stations',)}}
              </li>
              <li class="breadcrumb-item active">Charging Station detail</li>
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
                <div class="row">
                  <div class="col-sm-12 col-md-2">
                    {{ link_to_route('admin.chargingStations','Back',[],['class'=>'btn btn-block btn-outline-primary','title'=>'Back']) }}
                  </div>
                  
                </div>
              </div>
          <!-- /.card-header -->
          <div class="card-body">

              <div class="row">
                    <div class="col-sm-9">
                        <div class="row">
                          <div class="col-md-4">
                          <p><strong>Name:</strong> {{ $data->name ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                          <p><strong>Email:</strong> {{ $data->email ?? '' }}</p>
                          </div>

                          <div class="col-md-4">
                          <p><strong>Contact:</strong> {{ $data->mobile ?? '' }}</p>
                          </div>

                         
                          <div class="col-md-4">
                            <p><strong>State:</strong> {{ json_decode($data->state_ary)->name ?? '' }}</p>
                          </div>
                       
                          <div class="col-md-4">
                            <p><strong>City:</strong> {{ json_decode($data->city_ary)->name ?? '' }}</p>
                          </div>


                          <div class="col-md-4">
                            <p><strong>User:</strong> {{ json_decode($data->user_ary)->name ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                            <p><strong>Email:</strong> {{ json_decode($data->user_ary)->email ?? '' }}</p>
                          </div>

                           <div class="col-md-4">
                            <p><strong>Mobile:</strong> {{ json_decode($data->user_ary)->mobile_code ?? '' }} {{ json_decode($data->user_ary)->mobile ?? '' }}</p>
                          </div>

                       
                          <div class="col-md-4">
                            <p><strong>Timing:</strong> {{ $data->open_time ?? '' }} - {{ $data->close_time ?? '' }}</p>
                          </div>
                       

                          <div class="col-md-4">
                            <p><strong>Open day in week:</strong> {{ $data->days ?? '' }}</p>
                          </div>

                        
                          <div class="col-md-4">
                            <p><strong>Address:</strong> {{ $data->address ?? '' }}</p>
                          </div>
                        
                          <div class="col-md-4">
                            <p><strong>Geo City:</strong> {{ $data->city ?? '' }}</p>
                          </div>

                       
                          <div class="col-md-4">
                            <p><strong>Latitute:</strong> {{ $data->lat ?? '' }}</p>
                          </div>

                       
                          <div class="col-md-4">
                            <p><strong>Longitute:</strong> {{ $data->lng ?? '' }}</p>
                          </div>


                        <div class="col-md-4">
                          <p><strong>Station type:</strong> {{ \App\ChargingStation::staionType($data->station_type) ?? '' }}</p>
                        </div>
                        <div class="col-md-12">
                          <h3>Connector</h3>
                        </div>
                       
                        @forelse($data->connector as $ckey => $cval)
                          <div class="col-md-4">
                            <p><strong>{{ json_decode($cval->connector_ary)->name ?? '' }} </strong>QTY:{{ json_decode($cval->connector_ary)->qty ?? '0' }}</p>
                        </div>
                        @empty

                        @endforelse
                       
                        
                        <div class="col-md-12">
                          <p><strong>Description:</strong> {{ $data->description ?? '' }}</p>
                        </div>

                        <div class="col-md-12">
                          <p><strong>Plan:</strong> {{ $data->plan ?? 'Plan detail not available' }}</p>
                        </div>
                       
                        <!-- /.form-group -->
                      <!-- /.col -->
                     </div>
                   <!-- /.col -->
                   <!-- /.col -->
                  </div>
                  <!-- /.row -->
                    <div class="col-sm-3">
                      <h2>Gallery</h2>
                      @forelse($data->stationImage as $image)
                        @if($image->image)
                          <div class="col-md-12">
                            <div class="zkit_gall_img">
                              <img src="{{ url('public/'.$image->image) }}" alt="user" class="img-fluit edit-product-img" />
                            </div>
                        </div>
                        @endif
                        @empty
                      @endforelse
                  </div>
                  <!-- /.row -->
              </div>

             {{-- <div class="row">
                <table class="table">
                  <tr>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Type</th>
                  </tr>
                  @forelse($data->stationPlan as $plKey => $plval)
                      <tr>
                        <td>{{ env('CURRENCY_SYMBOL').$plval->price }}</td>
                        <td>{{ $plval->plan_duration }}</td>
                        <td>{{ \App\StationPlan::PlanType($plval->plan_type) }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3">Plan detail not provided</td>
                      </tr>
                    @endforelse
                 
                </table>
                
              </div>--}}
          <!-- /.card-body -->
        </div>
      </div>
    </section>

@endsection

@section('footer')

 @endsection