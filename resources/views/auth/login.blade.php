@extends('layouts.app')

@section('content')

  

  
  <div class="content">
    <div class="container">
		
<div class="shadow p-3 mb-5 bg-body rounded">
      <div class="row">
        <div class="col-md-6">
          <img src="images/signin-image.png" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign In</h3>
            </div>
            <form method="POST" action="{{ route('login') }}">
			@csrf
              <div class="form-group first">
                <label for="username">Email<sup class="star">*</sup></label>
                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>


              <div class="form-group last mb-4">
                <label for="password">Password<sup class="star">*</sup></label>
                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
					@error('password')
                        <span class="invalid-feedback" role="alert">
                        	<strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>
              
              <div class="d-flex mb-5 align-items-center">
			  <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember {{ old('remember') ? 'checked' : '' }}">
					<label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                </label>
                <span class="ml-auto"><a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password</a></span> 
              </div>
			  <button type="submit" class="btn btn-block btn-primary">
                    {{ __('Login') }}
                </button>

            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
	</div>
  </div>

  
  
@endsection
