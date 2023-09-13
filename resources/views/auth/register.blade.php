@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container">
		
<div class="shadow p-3 mb-5 bg-body rounded">
      <div class="row">
        <div class="col-md-6">
          <img src="images/signup-image.png" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign Up</h3>
            </div>
  
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- <div class="form-group row">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}<sup class="star">*</sup></label>

                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autocomplete="firstName" autofocus>

                                @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

            <div class="form-group first">
                <label for="username">First Name<sup class="star">*</sup></label>
                    <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autocomplete="firstName" autofocus>
                        @error('firstName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
            </div>



            <div class="form-group first">
                <label for="username">Last Name<sup class="star">*</sup></label>
                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>
                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

                        <!-- <div class="form-group row">
                            <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}<sup class="star">*</sup></label>

                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

            <div class="form-group first">
                <label for="username">Country<sup class="star">*</sup></label>                                    
                <select class="form-select" name="country" id="country">
                    <option value="Pakistan">Pakistan</option>
                    <option value="China">China</option>
                    <option value="Turkey">Turkey</option>
                </select>
            </div>


                        <!-- <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}<sup class="star">*</sup></label>

                            <div class="col-md-6">

                                
                                <select class="form-select" name="country" id="country">
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="China">China</option>
                                    <option value="Turkey">Turkey</option>
                                </select>

                            
                            </div>
                        </div> -->



            <div class="form-group first">
                <label for="username">Organization<sup class="star">*</sup></label>
                <input id="organization" type="text" class="form-control @error('organization') is-invalid @enderror" name="organization" value="{{ old('organization') }}" required autocomplete="organization" autofocus>
                    @error('organization')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

<!-- 
                        <div class="form-group row">
                            <label for="organization" class="col-md-4 col-form-label text-md-right">{{ __('Organization') }}<sup class="star">*</sup></label>

                            <div class="col-md-6">
                                <input id="organization" type="text" class="form-control @error('organization') is-invalid @enderror" name="organization" value="{{ old('organization') }}" required autocomplete="organization" autofocus>

                                @error('organization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group first">
                        <label for="none"><strong>If you don't have WEB than type NULL in organization web bar.</strong></label>

                <label for="username">Web<sup class="star">*</sup></label>

                <input id="web" type="text" class="form-control @error('web') is-invalid @enderror" name="web" value="{{ old('web') }}" required autocomplete="web" autofocus>
                    @error('web')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
<!-- 
<div class="form-group row">
                            <label for="web" class="col-md-4 col-form-label text-md-right"><strong>Note:</strong></label>

                            <div class="col-md-6">

                            </div>
                        </div> -->

                        <!-- <div class="form-group row">
                            <label for="web" class="col-md-4 col-form-label text-md-right">{{ __('Organization Web') }}</label>

                            <div class="col-md-6">
                                <input id="web" type="text" class="form-control @error('web') is-invalid @enderror" name="web" value="{{ old('web') }}" required autocomplete="web" autofocus>

                                @error('web')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->


                        <div class="form-group first">
                            <label for="none"><strong>Your Email will be used for Contacting/Notifying you. So It is Requested To check E-mail multiple times and enter CORRECT E-mail.</strong></label>
                            <label for="username">E-mail<sup class="star">*</sup></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <!-- <div class="form-group row">
                            <label for="web" class="col-md-4 col-form-label text-md-right"><strong>NOTE:</strong></label>

                            <div class="col-md-6">
                            <label for="none"><strong>Your Email will be used for Contacting/Notifying you. So It is Requested To check E-mail multiple times and enter CORRECT E-mail.</strong></label>

                            </div>
                        </div> -->
                        

                        <!-- <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}<sup class="star">*</sup></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        

                        <div class="form-group first">
                            <label for="username">Password<sup class="star">*</sup></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>


                        
                        <!-- <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}<sup class="star">*</sup></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->


                        <div class="form-group first">
                            <label for="username">Confirm Password<sup class="star">*</sup></label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            
                        </div>

<!-- 
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}<sup class="star">*</sup></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div> -->

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
