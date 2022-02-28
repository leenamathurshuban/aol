<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ env('APP_NAME') }}</title>
  <!--  Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
   {!! Html::style('assets/admin/plugins/fontawesome-free/css/all.min.css') !!}
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
 {!! Html::style('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}
  <!-- Theme style -->
  {!! Html::style('assets/admin/dist/css/adminlte.min.css') !!}

  {!! Html::style('assets/admin/dist/css/shuban_style.css') !!}
  <!-- Google Font: Source Sans Pro -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body class="hold-transition login-page">
  <div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <div class="login_head">
          <h3>Login</h3>
          <p>Sign in to start your session</p>
      </div>

      <form method="POST" action="{{ route('vendorCheckLogin') }}">
                        @csrf
                        <?php 
                        $username=$password=$key=$companyRemember='';

                           /* if(isset($_COOKIE["username"])) { $username=$_COOKIE["username"]; }
                            if(isset($_COOKIE["password"])) { $password=$_COOKIE["password"]; }
                            if(isset($_COOKIE["companyRemember"])) { $companyRemember=$_COOKIE["companyRemember"]; } */
                            

                        ?>

        <div class="input-group mb-3">
          <input id="email" type="text" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$username) }}" required autocomplete="email" autofocus>

          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="{{$password}}">

          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 lr_footer">
            {{--<div class="icheck-primary">
              <input class="form-check-input" type="checkbox" name="remember" value="remember" id="remember" {{ old('remember',$companyRemember) ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </div>--}}
            @if(Session::has('failed'))
                    <span class="text-danger">{{ Session::get('failed') }}</span>
                  @endif
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
          <!-- /.col -->
        </div>
      </form>

   
      <!-- /.social-auth-links -->

     {{-- <p class="mb-1 forgot_pass">
        @if (Route::has('password.request'))
            <a class="" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
      </p>--}}
     <!--  <p class="mb-0">
        <a href="#" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
    <div class="login-logo" style='background:url("{{ url('assets/admin/dist/img/finacila_bg.jpg') }}");'>
    @php $logo = \App\Setting::first()->dark_logo; 

    @endphp
    {{ Html::image(($logo ? 'public/'.$logo : ''),env('APP_NAME'),['class'=>'login_logo'])}}
  </div>
  <!-- /.login-logo -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
{!! Html::script('assets/admin/plugins/jquery/jquery.min.js') !!}
<!-- Bootstrap 4 -->
{!! Html::script('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}
<!-- AdminLTE App -->
{!! Html::script('assets/admin/dist/js/adminlte.min.js') !!}
</body>
</html>

{{--@extends('layouts.app')

@section('content') 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                @if(Session::has('error')) 
                    <p class="text-danger text-center">{{ Session::get('error') }}</p>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <?php 
                        $username=$password=$key=$companyRemember='';

                            if(isset($_COOKIE["username"])) { $username=$_COOKIE["username"]; }
                            if(isset($_COOKIE["password"])) { $password=$_COOKIE["password"]; }
                            if(isset($_COOKIE["companyRemember"])) { $companyRemember=$_COOKIE["companyRemember"]; } 
                            

                        ?>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$username) }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                      

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="{{$password}}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="remember" id="remember" {{ old('remember',$companyRemember) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
--}}