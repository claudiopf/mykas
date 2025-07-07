@extends('layouts.app_auth')
@section('content')
    <div class="account-pages py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           class="form-control bg-light border-light @error('name') is-invalid @enderror"
                                           placeholder="Enter your name"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           class="form-control bg-light border-light @error('email') is-invalid @enderror"
                                           placeholder="Enter your email"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           class="form-control bg-light border-light @error('password') is-invalid @enderror"
                                           placeholder="Enter your password"
                                           required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password-confirm">Confirm Password</label>
                                    <input type="password"
                                           id="password-confirm"
                                           name="password_confirmation"
                                           class="form-control bg-light border-light"
                                           placeholder="Confirm your password"
                                           required>
                                </div>
                                <div class="mb-1 text-center d-grid">
                                    <button class="btn btn-primary btn-lg fw-medium" type="submit">Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
