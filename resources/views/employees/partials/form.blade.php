@php
  $emp = $employee ?? null;
@endphp

<div class="mb-3">
  <label class="form-label">Employee ID</label>
  <input name="employee_id" class="form-control" value="{{ old('employee_id', $emp->employee_id ?? '') }}" {{ isset($mode) && $mode === 'edit' ? '' : 'required' }}>
  @error('employee_id') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Name</label>
  <input name="name" class="form-control" value="{{ old('name', $emp->name ?? '') }}" required>
  @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Email</label>
  <input name="email" type="email" class="form-control" value="{{ old('email', $emp->email ?? '') }}" required>
  @error('email') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Position</label>
  <input name="position" class="form-control" value="{{ old('position', $emp->position ?? '') }}">
  @error('position') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Salary</label>
  <input name="salary" type="number" step="0.01" class="form-control" value="{{ old('salary', $emp->salary ?? 0) }}">
  @error('salary') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Password {{ isset($mode) && $mode === 'edit' ? '(leave blank to keep current)' : '' }}</label>
  <input name="password" type="password" class="form-control" {{ isset($mode) && $mode === 'edit' ? '' : 'required' }}>
  @error('password') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Confirm Password</label>
  <input name="password_confirmation" type="password" class="form-control" {{ isset($mode) && $mode === 'edit' ? '' : 'required' }}>
</div>
