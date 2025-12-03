@extends('layouts.app')

@section('content')
<div class="p-4 bg-white rounded shadow-sm">
  <h2 class="mb-4">{{ env('AGENCY_NAME', 'Agency') }} – Employee Dashboard</h2>
  <h3 class="mb-3">Welcome, {{ $employee->name }}</h3>
  <p><strong>Employee ID:</strong> {{ $employee->employee_id }}</p>
  <p><strong>Email:</strong> {{ $employee->email }}</p>
  <p><strong>Position:</strong> {{ $employee->position ?? 'N/A' }}</p>
  <p><strong>Salary:</strong> Nu.{{ number_format($employee->salary, 2) }}</p>

  <a href="{{ route('employees.profile') }}" class="btn btn-secondary me-2">Edit My Profile</a>
  @auth('admin')
    <a href="{{ route('admin.employees.index') }}" class="btn btn-primary">Manage Employees</a>
  @endauth
</div>
@endsection
