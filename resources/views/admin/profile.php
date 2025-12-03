@extends('layouts.app')

@section('page-title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card profile-card">
                <div class="card-body text-center">
                    <div class="profile-avatar mb-3">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h4 class="mb-1">{{ $admin->name }}</h4>
                    <p class="text-muted mb-3">
                        <i class="bi bi-shield-check me-1"></i>Administrator
                    </p>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-envelope me-1"></i>{{ $admin->email }}
                    </p>
                    <hr class="my-3">
                    <div class="profile-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <h5 class="mb-0 text-primary">{{ $admin->id }}</h5>
                                <small class="text-muted">Admin ID</small>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-0 text-success">Active</h5>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Account Details</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <i class="bi bi-calendar-check text-primary"></i>
                        <div>
                            <small class="text-muted d-block">Member Since</small>
                            <strong>{{ $admin->created_at->format('M d, Y') }}</strong>
                        </div>
                    </div>
                    <div class="info-item mt-3">
                        <i class="bi bi-clock-history text-success"></i>
                        <div>
                            <small class="text-muted d-block">Last Updated</small>
                            <strong>{{ $admin->updated_at->format('M d, Y h:i A') }}</strong>
                        </div>
                    </div>
                    <div class="info-item mt-3">
                        <i class="bi bi-shield-lock text-info"></i>
                        <div>
                            <small class="text-muted d-block">Account Type</small>
                            <span class="badge bg-primary">Administrator</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                        </a>
                        <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-people me-2"></i>Manage Employees
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="section-header">
                            <h5 class="text-primary mb-0">
                                <i class="bi bi-person me-2"></i>Basic Information
                            </h5>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    <i class="bi bi-person-badge me-1"></i>Full Name
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $admin->name) }}" 
                                       placeholder="Enter your full name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $admin->email) }}" 
                                       placeholder="Enter your email"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="section-header">
                            <h5 class="text-primary mb-0">
                                <i class="bi bi-shield-lock me-2"></i>Security & Password
                            </h5>
                        </div>
                        
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Leave password fields blank if you don't want to change your password</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="current_password" class="form-label">
                                    <i class="bi bi-lock me-1"></i>Current Password
                                </label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password"
                                       placeholder="Enter current password to change">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label">
                                    <i class="bi bi-key me-1"></i>New Password
                                </label>
                                <input type="password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" 
                                       name="new_password"
                                       placeholder="Enter new password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimum 8 characters required</small>
                            </div>

                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label">
                                    <i class="bi bi-key-fill me-1"></i>Confirm New Password
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation"
                                       placeholder="Confirm new password">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Profile
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                        <div class="activity-content">
                            <p class="mb-0"><strong>Logged in</strong></p>
                            <small class="text-muted">{{ $admin->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-primary">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="activity-content">
                            <p class="mb-0"><strong>Account created</strong></p>
                            <small class="text-muted">{{ $admin->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .profile-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        margin: 0 auto;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
    }
    
    .profile-stats {
        padding: 1rem 0;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 0.5rem;
    }
    
    .info-item i {
        font-size: 1.5rem;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 0.5rem;
    }
    
    .section-header {
        background: linear-gradient(90deg, #f1f5f9 0%, transparent 100%);
        padding: 1rem;
        border-left: 4px solid var(--primary);
        margin-bottom: 1.5rem;
        border-radius: 0.25rem;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: white;
        border-bottom: 2px solid #e2e8f0;
        padding: 1.25rem;
        font-weight: 600;
    }
    
    .form-label {
        font-weight: 500;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
    }
    
    .btn-primary {
        padding: 0.65rem 1.5rem;
        font-weight: 500;
    }
    
    .btn-secondary {
        padding: 0.65rem 1.5rem;
        font-weight: 500;
    }
</style>
@endpush
@endsection
