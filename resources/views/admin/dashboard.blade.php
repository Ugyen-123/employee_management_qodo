@extends('layouts.app')

@section('content')
<div class="p-4 bg-white rounded shadow-sm">
  <h2 class="mb-4">{{ env('AGENCY_NAME', 'Agency') }} – Admin Dashboard</h2>

  <div class="mb-3">
    <a href="{{ route('admin.employees.index') }}" class="btn btn-primary">Manage Employees</a>
  </div>

  <p>Welcome, Admin. Use the menu to manage employees.</p>
</div>
@endsection
