@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input name="password" type="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input name="password_confirmation" type="password" class="form-control" required>
          </div>
          <button class="btn btn-primary">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
