<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KTVC Admin | Dashboard</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <style>
        /* Injecting KTVC Brand Colors into AdminLTE */
        .bg-ktvc-maroon { background-color: #7B1818 !important; color: white; }
        .text-ktvc-gold { color: #C89D3C !important; }
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #7B1818;
            color: #fff;
        }

        body {
            position: relative;
            z-index: 0;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            
            background-image: url('{{ asset("images/ktvc-watermark.png") }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 500px; /* Slightly larger for the wide admin screen */
            
            opacity: 0.05; /* 5% opacity for AdminLTE so it doesn't distract from data tables */
            z-index: -1; 
            pointer-events: none;
        }

        /* Ensure AdminLTE content wrappers are transparent so the background shows through */
        .content-wrapper {
            background-color: transparent !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" class="nav-link" target="_blank">View Live Site</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-navbar text-danger fw-bold">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #2c3e50;">
        <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center bg-white border-bottom-0 pb-3 pt-3" style="border-bottom: 3px solid var(--ktvc-maroon, #7B1818) !important;">
    <img src="{{ asset('images/ktvc-navbar-logo.png') }}" alt="KTVC Logo" style="width: 90%; height: auto; margin: 0 auto;">
</a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image">
                    <div class="img-circle bg-secondary d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    <span class="badge badge-success">{{ strtoupper(auth()->user()->role) }}</span>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <li class="nav-header">ADMISSIONS</li>
                    
                    @if(auth()->user()->hasPermission('view_analytics'))
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasPermission('review_applications'))
                    <li class="nav-item">
                        <a href="{{ route('admin.applications.pending') }}" class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>Applications</p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_enquiries'))
                    <li class="nav-item">
                        <a href="{{ route('admin.enquiries.index') }}" class="nav-link {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-inbox"></i>
                            <p>Enquiries</p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_staff'))
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Staff Management</p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->role === 'super_admin')
                    <li class="nav-header">SYSTEM ADMINISTRATION</li>
                    <li class="nav-item">
                         <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Manage Staff Roles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content pt-4">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} Kipkabus Technical and Vocational College.</strong>
        All rights reserved.
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>