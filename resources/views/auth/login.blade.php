@extends('layouts.center-mini')

@section('content')

    <a class="btn-round-back">
        <
    </a>

    <a class="navbar-brand    " href="/" style="text-align: center; display: block;     padding-top: 1px;">
        <img src="/img/Logo.png" height="28" loading="lazy">
    </a>

    <BR>
    <BR>


    <form method="POST" action="{{ route('login') }}">
        @csrf


        <!-- Email input -->
        <div class="form-outline mb-4">
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror" name="email"
                   value="{{ old('email') }}" required autocomplete="email" autofocus>

            <label class="form-label" for="email">Email address</label>


            @error('email')
            <div id="email" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

        </div>


        <!-- Password input -->
        <div class="form-outline mb-4">
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password">
            <label class="form-label" for="password">Password</label>

            @error('password')
            <div id="validationServer03Feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

        </div>


        <div class="row mb-3">


            <div class="col-md-6 ">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>


        </div>

        <button type="submit" class="btn  btn-outline-dark">
            {{ __('Login') }}
        </button>
        <div class="col-md-6  offset-6">

        </div>
    </form>

@endsection
