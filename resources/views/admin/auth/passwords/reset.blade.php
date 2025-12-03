@extends('layouts.app')

@section('page-title', 'Admin Reset Password')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-header">Reset Password (Admin)</div>
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="mb-3">
            <label for="email" class="form-label">Admin Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Update Password</button>
        </form>

        <div class="mt-3">
          <a href="{{ route('admin.login') }}">Back to Admin Login</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
