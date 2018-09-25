@extends('layouts.app')

@section('content')
    <div class="container flex justify-center">
        <div class="w-2/5 mx-auto">
            <h1>Login</h1>

            <form class="mt-8" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="control">
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    <input class="input" id="email" type="email"
                           name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="control">
                    <label for="password">{{ __('Password') }}</label>

                    <input class="input" id="password" type="password"
                           name="password"
                           required>
                </div>

                <div class="control">
                    <input type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="control">
                    <button type="submit" class="button">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
