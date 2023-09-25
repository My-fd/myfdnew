@extends('web.base')

@section('title', 'Login')

@section('content')
    <div class="sections">
        <div class="container">
            <div class="form__block">
                <h1 class="card-header">{{ __('Login') }}</h1>
                
                <div class="form-body">
                
                    @if ($errors->has('auth'))
                        <span class="text-danger">{{ $errors->first('auth') }}</span>
                    @endif
                    <form method="POST" action="{{ route('web.auth') }}">
                        @csrf

                        <div class="form-group">
                            <!-- <label for="login">{{ __('Email or Nickname') }}</label>  -->
                            <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus placeholder="{{ __('Email or Nickname') }}">

                            @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <!-- <label for="password">{{ __('Password') }}</label> -->
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-chekbox">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-btn">
                            <button type="submit" class="btn btn-login">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>

                <a href="{{ route('web.register') }}" class="help__link">{{ __('Register') }}</a> 
                <a href="#" class="help__link">{{ __('Forgot your password') }}</a>

                <!-- <div class="help-link">

                </div> -->
            </div>
        </div>
    </div>
@endsection
