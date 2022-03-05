@extends('layouts.app_plain')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-6">
            <div>
                {{-- <img src="{{asset('img/ninja.png')}}" alt="ninja"> --}}
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Login</h3>
                    <p class="text-center text-muted">Please Fill Login Form</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                           <!-- Phone -->
                        <div class="md-form">
                            <input id="text" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone') }}" required autocomplete="email" autofocus>
                            <label for="materialLoginFormEmail">Phone</label>

                            @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                         <!-- Password -->
                        <div class="md-form">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <label for="materialLoginFormPassword">Password</label>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>


                        <button type="submit" class="btn btn-theme btn-block mt-5">
                            {{ __('Login') }}
                        </button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
