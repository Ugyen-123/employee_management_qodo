@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Employees</h4>
  <a href="{{ route('admin.employees.create') }}" class="btn btn-success">Add Employee</a>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Salary</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($employees as $emp)
            <tr>
              <td>{{ $emp->id }}</td>
              <td>{{ $emp->employee_id }}</td>
              <td>{{ $emp->name }}</td>
              <td>{{ $emp->email }}</td>
              <td>{{ $emp->position }}</td>
              <td>Nu.{{ number_format($emp->salary, 2) }}</td>
              <td class="text-end">
                <a href="{{ route('admin.employees.show', $emp) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('admin.employees.edit', $emp) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.employees.destroy', $emp) }}" method="POST" class="d-inline">
                  @csrf 
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this employee?')">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center p-3">No employees found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer">
    {{ $employees->links() }}
  </div>
</div>
@endsection