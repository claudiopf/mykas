@extends('layouts.app_auth')
@section('content')
    <div class="account-pages py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card">
                        <div class="card-body p-5">
                            <div class="text-center">
                                <div class="mx-auto mb-4 text-center auth-logo">
                                    <a href="index.html" class="logo-dark">
                                        <img src="{{ asset('assets/images/logo-dark.png') }}" height="32" alt="logo dark">
                                    </a>
                                    <a href="index.html" class="logo-light">
                                        <img src="{{ asset('assets/images/logo-light.png') }}" height="32" alt="logo light">
                                    </a>
                                </div>
                                <h3 class="fw-bold text-primary mb-2">Welcome back!</h3>
                                <p class="text-muted">Sign in to your account to continue</p>
                            </div>
                            <form method="POST" action="{{ route('login') }}" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control bg-light border-light @error('email') is-invalid @enderror" id="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="password" class="form-label">Password</label>
                                        <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">Forgot password?</a>
                                    </div>
                                    <input type="password" name="password" class="form-control bg-light border-light @error('password') is-invalid @enderror" id="password" placeholder="Enter your password" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark bg-primary btn-lg" type="submit">Sign In</button>
                                </div>
                            </form>
{{--                            <p class="text-center mt-4 text-black text-opacity-50">Don't have an account?--}}
{{--                                <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-bold">Sign Up</a>--}}
{{--                            </p>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
