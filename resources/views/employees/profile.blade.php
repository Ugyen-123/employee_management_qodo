@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
  <div class="card-header">My Profile</div>
  <div class="card-body">
    <form method="POST" action="{{ route('employees.profile.update') }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Position</label>
        <input name="position" class="form-control" value="{{ old('position', $employee->position) }}">
        @error('position') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      @if($employee->profile_photo)
      <div class="mb-3 text-center">
        <img src="{{ asset('storage/'.$employee->profile_photo) }}" alt="Profile" class="rounded-circle" style="height:100px;width:100px;object-fit:cover;">
      </div>
      @endif

      <div class="mb-3">
        <label class="form-label">Profile Photo</label>
        <input name="profile_photo" type="file" class="form-control" accept="image/*">
        @error('profile_photo') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Salary</label>
        <input name="salary" type="number" step="0.01" class="form-control" value="{{ old('salary', $employee->salary) }}">
        @error('salary') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">New Password (optional)</label>
        <input name="password" type="password" class="form-control">
        <small class="text-muted">Leave blank to keep current password.</small>
        @error('password') <small class="text-danger d-block">{{ $message }}</small> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input name="password_confirmation" type="password" class="form-control">
      </div>
      <button class="btn btn-primary">Update Profile</button>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
