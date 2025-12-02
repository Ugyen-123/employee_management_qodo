@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
  <div class="card-header">Employee Details</div>
  <div class="card-body">
    <p><strong>Employee ID:</strong> {{ $employee->employee_id }}</p>
    <p><strong>Name:</strong> {{ $employee->name }}</p>
    <p><strong>Email:</strong> {{ $employee->email }}</p>
    <p><strong>Position:</strong> {{ $employee->position }}</p>
    <p><strong>Salary:</strong> ${{ number_format($employee->salary, 2) }}</p>
    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">Edit</a>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
  </div>
</div>
@endsection
