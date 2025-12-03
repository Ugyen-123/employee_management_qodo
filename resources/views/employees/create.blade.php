@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
  <div class="card-header">Add Employee</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.employees.store') }}">
      @csrf
      @include('employees.partials.form', ['mode' => 'create'])
      <button class="btn btn-success">Create</button>
      <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
