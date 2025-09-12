@extends('layouts.app')

@section('content')
    <div class="auth-centered-section">
        <div class="auth-card">
            <h2 class="auth-title">Sign In</h2>
            <form action="{{ url('login') }}" method="post">
                @include('flash.messages')
                @csrf

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input
                            type="email"
                            class="form-control @error('email') error @enderror"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                    >
                    @error('email')
                    <span class="text text-danger" role="alert">
                        <strong>{{ errors('email') }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pwd">Password</label>
                    <input
                            type="password"
                            class="form-control @error('password') error @enderror"
                            id="pwd"
                            name="password"
                            placeholder="Enter your password"
                    >
                    @error('password')
                    <span class="text text-danger" role="alert">
                        <strong>{{ errors('password') }}</strong>
                    </span>
                    @enderror
                </div>

                <button class="btn btn-auth-primary" type="submit">Sign In</button>

                <div class="auth-switch-link">
                    Don't have an account? <a href="{{ url('/register') }}">Sign Up</a>
                </div>
            </form>
        </div>
    </div>

@endsection