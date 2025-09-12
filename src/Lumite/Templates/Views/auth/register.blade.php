@extends('layouts.app')

@section('content')
    <div class="auth-centered-section">
        <div class="auth-card">
            <h2 class="auth-title">Sign Up</h2>
            <form action="{{ url('register') }}" method="post">
                @include('flash.messages')
                @csrf

                <div class="form-group">
                    <label for="name">Full name</label>
                    <input
                            type="text"
                            class="form-control @error('name') error @enderror"
                            id="name"
                            name="name"
                            placeholder="Enter your full name"
                            value="{{ old('name') }}"
                    >
                    @error('name')
                    <span class="text text-danger" role="alert">
                        <strong>{{ errors('name') }}</strong>
                    </span>
                    @enderror
                </div>

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
                            placeholder="Create a password"
                    >
                    @error('password')
                    <span class="text text-danger" role="alert">
                        <strong>{{ errors('password') }}</strong>
                    </span>
                    @enderror
                </div>

                <button class="btn btn-auth-primary" type="submit">Sign Up</button>

                <div class="auth-switch-link">
                    Already have an account? <a href="{{ url('/login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>

@endsection