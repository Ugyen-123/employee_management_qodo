@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-header">Employee Login</div>
      <div class="card-body">
        <form method="POST" action="{{ route('login.post') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Employee ID</label>
            <input type="text" name="employee_id" class="form-control" value="{{ old('employee_id') }}" required autofocus>
            @error('employee_id') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div>
          <button class="btn btn-primary w-100">Login</button>
        </form>

        <div class="mt-3 d-flex justify-content-between">
          <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot your password?</a>
          <a href="{{ route('admin.login') }}" class="text-decoration-none">Admin Login</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
