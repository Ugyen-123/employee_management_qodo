@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header">Forgot Password</div>
      <div class="card-body">
        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <button class="btn btn-primary">Send Reset Link</button>
          <a href="{{ route('login') }}" class="btn btn-secondary ms-2">Back to Login</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
