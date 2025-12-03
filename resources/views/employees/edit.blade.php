@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
  <div class="card-header">Edit Employee</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
      @csrf @method('PUT')
      @include('employees.partials.form', ['mode' => 'edit', 'employee' => $employee])
      <button class="btn btn-primary">Update</button>
      <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
