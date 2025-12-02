<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ env('AGENCY_NAME', 'Employee Management') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-black mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/government-logo.png') }}" alt="Gov" style="height:32px;width:auto;">
            <strong>{{ env('AGENCY_NAME', 'EmployeeMgmt') }}</strong>
            <img src="{{ asset('images/agency-logo.png') }}" alt="Agency" style="height:32px;width:auto;">
        </a>

        @auth('employees')
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(auth('admin')->check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.employees.index') }}">Manage Employees</a></li>
                @else
                    {{-- Employees no longer have an index; show profile link only --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('employees.profile') }}">My Profile</a></li>
                @endif
            </ul>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
        @endauth
    </div>
</nav>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
