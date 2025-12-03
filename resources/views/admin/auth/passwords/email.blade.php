@extends('layouts.app')

@section('page-title', 'Admin Forgot Password')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-header">Forgot Password (Admin)</div>
      <div class="card-body">
        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Admin Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>

        <div class="mt-3">
          <a href="{{ route('admin.login') }}">Back to Admin Login</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
