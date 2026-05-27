<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kipkabus Technical and Vocational College - Admission Portal</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --ktvc-maroon: #7B1818; /* Derived from logo */
            --ktvc-gold: #C89D3C;   /* Derived from logo */
            --ktvc-light: #f8f9fa;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Custom Navbar */
        .navbar-ktvc {
            background-color: var(--ktvc-maroon);
        }
        .navbar-ktvc .navbar-nav .nav-link {
            color: white;
            font-weight: 500;
            margin: 0 5px;
            transition: color 0.3s ease;
        }
        .navbar-ktvc .navbar-nav .nav-link:hover {
            color: var(--ktvc-gold);
        }
        
        /* Custom Cards */
        .card-header-ktvc {
            background-color: var(--ktvc-maroon);
            color: white;
            font-weight: bold;
        }
        
        /* Custom Buttons */
        .btn-ktvc-primary {
            background-color: var(--ktvc-maroon);
            color: white;
            border: none;
        }
        .btn-ktvc-primary:hover {
            background-color: #5a1212;
            color: white;
        }
        .btn-ktvc-accent {
            background-color: var(--ktvc-gold);
            color: white;
            border: none;
        }
        .btn-ktvc-accent:hover {
            background-color: #a8812c;
            color: white;
        }
        body {
            position: relative;
            background-color: #f4f6f9; /* Standard light gray background */
            z-index: 0;
        }

        body::before {
            content: "";
            position: fixed; /* Keeps the logo centered even when scrolling down */
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            
            /* Load the image using Laravel's asset helper */
            background-image: url('{{ asset("images/ktvc-watermark.png") }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 450px; /* Adjust this value to make the logo larger or smaller */
            
            opacity: 0.06; /* 6% opacity blends it perfectly without hurting readability */
            z-index: -1; /* Pushes the logo behind all other content */
            pointer-events: none; /* Ensures the logo doesn't block you from clicking links */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-ktvc shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
    
    <div class="bg-white rounded px-2 py-1 me-3 mr-3 shadow-sm d-flex align-items-center">
        <img src="{{ asset('images/ktvc-navbar-logo.png') }}" alt="KTVC Logo" style="height: 40px; width: auto;">
    </div>
    
    <span class="fw-bold fs-4 text-white" style="letter-spacing: 0.5px;">
        Online Admissions Portal
    </span>
    
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Apply</a></li> -->
                    <a class="nav-link" href="{{ route('programmes') }}">Our Programmes</a>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('enquiry.page') }}">Enquiries</a>
                    </li>
                    <!-- <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login / Create Account</a></li> -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="py-5">
        <!-- This is where the login and register views get injected -->
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    @stack('scripts')

    @include('partials.footer')
</body>
</html>