<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ env('AGENCY_NAME', 'Employee Management') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-dark: #1e40af;
            --sidebar: #1e3a8a;
            --sidebar-hover: #1e40af;
            --secondary: #f1f5f9;
            --text-light: #e2e8f0;
            --text-dark: #1e293b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: var(--text-dark);
        }
        
        .layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--sidebar);
            color: var(--text-light);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            transition: left 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar .brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: var(--primary-dark);
        }
        
        .sidebar .brand .app-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #fff;
        }
        
        .sidebar .menu {
            padding: 1rem 0;
        }
        
        .sidebar .menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-light);
            text-decoration: none;
            padding: 0.75rem 1.25rem;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        
        .sidebar .menu a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        
        .sidebar .menu a.active {
            background: var(--sidebar-hover);
            color: #fff;
            border-left: 4px solid #60a5fa;
        }
        
        .sidebar .menu a i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar .menu hr {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 1.25rem;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }
        
        /* Header Styles */
        .header {
            background: var(--primary);
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        
        /* Center header title when guest */
        .layout.guest .header {
            justify-content: center;
        }
        
        .layout.guest .header h1 {
            font-size: 1.75rem;
        }
        
        .header .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .toggle-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1.25rem;
            display: none;
        }
        
        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }
        
        .profile-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        
        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Content Area */
        .content-inner {
            padding: 2rem;
            min-height: calc(100vh - 200px);
        }
        
        /* Extra spacing for login/guest pages */
        .layout.guest .content-inner {
            padding: 3rem 2rem;
        }
        
        /* Hide sidebar when not authenticated */
        .layout.guest .sidebar {
            display: none !important;
        }
        
        .layout.guest .main-content {
            margin-left: 0 !important;
        }
        
        .layout.guest .toggle-btn {
            display: none !important;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }
        
        /* Tables */
        .table {
            background: #fff;
        }
        
        .table thead {
            background: var(--secondary);
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Login Form Styles */
        .login-container {
            max-width: 450px;
            margin: 0 auto;
        }
        
        .login-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .login-card .card-body {
            padding: 2.5rem;
        }
        
        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        /* Footer */
        footer {
            text-align: center;
            padding: 2rem;
            color: #64748b;
            font-size: 0.875rem;
            background: #fff;
            margin-top: auto;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .toggle-btn {
                display: inline-flex;
            }
            
            .header h1 {
                font-size: 1.25rem;
            }
        }
        
        @media (max-width: 768px) {
            .content-inner {
                padding: 1rem;
            }
            
            .layout.guest .content-inner {
                padding: 2rem 1rem;
            }
            
            .header {
                padding: 1rem;
            }
            
            .layout.guest .header {
                padding: 1.25rem 1rem;
            }
            
            .layout.guest .header h1 {
                font-size: 1.25rem;
            }
        }
    </style>
    @stack('styles')
    @yield('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
        
        window.logout = function(formId) {
            const f = document.getElementById(formId);
            if(f) { f.submit(); }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            const links = document.querySelectorAll('.sidebar .menu a[data-active]');
            links.forEach(a => {
                const href = a.getAttribute('href');
                if(href === window.location.pathname || window.location.href.includes(href)) {
                    a.classList.add('active');
                }
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.querySelector('.toggle-btn');
                if (window.innerWidth <= 992 && sidebar && sidebar.classList.contains('open')) {
                    if (!sidebar.contains(e.target) && e.target !== toggleBtn && !toggleBtn?.contains(e.target)) {
                        sidebar.classList.remove('open');
                    }
                }
            });
        });
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body>
    <div class="layout @guest('admin') @guest('employees') guest @endguest @endguest">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div class="brand">
                <span class="app-title">{{ env('AGENCY_NAME', 'Employee Management') }}</span>
            </div>
            <div class="menu">
                @auth('admin')
                    <a href="{{ route('admin.dashboard') }}" data-active>
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.employees.index') }}" data-active>
                        <i class="bi bi-people"></i>
                        <span>Employees</span>
                    </a>
                    {{-- <a href="{{ route('admin.departments.index') }}" data-active>
                        <i class="bi bi-building"></i>
                        <span>Departments</span>
                    </a> --}}
                    {{-- <a href="{{ route('admin.employees.bulk-upload') }}" data-active>
                        <i class="bi bi-cloud-upload"></i>
                        <span>Bulk Upload</span>
                    </a> --}}
                    <hr>
                    <a href="{{ route('admin.profile') }}" data-active>
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                    <form id="admin-logout" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
                    <a href="#" onclick="event.preventDefault(); logout('admin-logout')">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                @endauth
                
                @auth('employees')
                    <a href="{{ route('dashboard') }}" data-active>
                        <i class="bi bi-house"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('employees.profile') }}" data-active>
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                    <hr>
                    <form id="emp-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    <a href="#" onclick="event.preventDefault(); logout('emp-logout')">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                @endauth
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    @auth('admin')
                        <button class="toggle-btn" onclick="toggleSidebar()">
                            <i class="bi bi-list"></i>
                        </button>
                        <h1>@yield('page-title', 'Admin Dashboard')</h1>
                    @endauth
                    @auth('employees')
                        <button class="toggle-btn" onclick="toggleSidebar()">
                            <i class="bi bi-list"></i>
                        </button>
                        <h1>@yield('page-title', 'Employee Dashboard')</h1>
                    @endauth
                    @guest('admin')
                        @guest('employees')
                            <h1>Employee Management System</h1>
                        @endguest
                    @endguest
                </div>
                <div class="header-right">
                    @auth('admin')
                        <div class="profile-dropdown">
                            <a href="{{ route('admin.profile') }}" class="profile-btn text-decoration-none">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                            </a>
                        </div>
                    @endauth
                    @auth('employees')
                        <div class="profile-dropdown">
                            <a href="{{ route('employees.profile') }}" class="profile-btn text-decoration-none">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ Auth::guard('employees')->user()->first_name ?? 'Employee' }}</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-inner">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
            
            <!-- Footer -->
            <footer>
                <p>&copy; {{ date('Y') }} Employee Management System. All rights reserved.</p>
            </footer>
        </main>
    </div>
</body>
</html>
