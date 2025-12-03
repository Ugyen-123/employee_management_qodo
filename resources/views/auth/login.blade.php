@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="card login-card">
        <div class="card-body">
            <div class="text-center mb-4">
                <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Employee Login</h3>
                <p class="text-muted">Sign in to access your account</p>
            </div>
            
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="login" class="form-label">
                        <i class="bi bi-person-badge me-1"></i>Employee ID or Email
                    </label>
                    <input type="text" 
                           class="form-control @error('login') is-invalid @enderror" 
                           id="login"
                           name="login" 
                           value="{{ old('login') }}" 
                           placeholder="Enter your employee ID or email"
                           required 
                           autofocus>
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">You can use either your 12-digit Employee ID or email address</small>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-1"></i>Password
                    </label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password"
                           name="password" 
                           placeholder="Enter your password"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>

                <div class="text-center">
                    <p class="text-muted mb-0">
                        Administrator? 
                        <a href="{{ route('admin.login') }}" class="forgot-password ms-1">
                            <i class="bi bi-shield-lock"></i> Login here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
