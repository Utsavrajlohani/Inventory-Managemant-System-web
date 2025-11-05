<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Simple styles (Bootstrap CDN) - avoids needing Vite build -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-" crossorigin="anonymous">
        <!-- Font Awesome for icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="" crossorigin="anonymous">
        <style>
            body { padding-top: 70px; background-color: #f8f9fa; }
            
            /* Navigation styling */
            .nav-link.active { font-weight: 600; color: #fff !important; position: relative; }
            .nav-link.active:after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 30px;
                height: 3px;
                background-color: #fff;
                border-radius: 2px;
            }
            .nav-link { transition: all 0.3s ease; }
            .nav-link:hover { transform: translateY(-2px); }

            /* Card enhancements */
            .card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                margin-bottom: 1.5rem;
            }
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            }
            .card-header {
                background: linear-gradient(45deg, #007bff, #0056b3);
                color: white;
                border-radius: 15px 15px 0 0 !important;
                padding: 1rem 1.5rem;
            }
            .card-body { padding: 1.5rem; }

            /* Table improvements */
            .table { margin-bottom: 0; }
            .table thead th {
                border-top: none;
                background-color: #f8f9fa;
                font-weight: 600;
            }
            .table-hover tbody tr { transition: all 0.2s ease; }
            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
                transform: scale(1.01);
            }

            /* Button styling */
            .btn {
                border-radius: 8px;
                padding: 0.5rem 1rem;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-primary {
                background: linear-gradient(45deg, #007bff, #0056b3);
                border: none;
                box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
            }
            .btn i { margin-right: 0.4rem; }

            /* Form controls */
            .form-control, .form-select {
                border-radius: 8px;
                border: 1px solid #dee2e6;
                padding: 0.6rem 1rem;
                transition: all 0.3s ease;
            }
            .form-control:focus, .form-select:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
            }

            /* Alert styling */
            .alert {
                border-radius: 12px;
                border: none;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }
            .alert-success {
                background: linear-gradient(45deg, #28a745, #20c997);
                color: white;
            }
            .alert-info {
                background: linear-gradient(45deg, #17a2b8, #0dcaf0);
                color: white;
            }
            .alert-warning {
                background: linear-gradient(45deg, #ffc107, #fd7e14);
                color: white;
            }
            .alert-danger {
                background: linear-gradient(45deg, #dc3545, #c82333);
                color: white;
            }

            /* Badge styling */
            .badge {
                padding: 0.5em 1em;
                border-radius: 6px;
                font-weight: 500;
            }

            /* Image thumbnails */
            .img-thumbnail {
                border-radius: 10px;
                transition: transform 0.3s ease;
            }
            .img-thumbnail:hover {
                transform: scale(1.05);
            }

            /* Dark mode styles */
            body.dark-mode {
                background-color: #121212;
                color: #ffffff !important;
            }
            body.dark-mode h1,
            body.dark-mode h2,
            body.dark-mode h3,
            body.dark-mode h4,
            body.dark-mode h5,
            body.dark-mode h6,
            body.dark-mode p,
            body.dark-mode span,
            body.dark-mode div {
                color: #ffffff !important;
            }
            /* Card styles */
            body.dark-mode .card {
                background-color: #1e1e1e;
                border-color: #2d2d2d;
            }
            body.dark-mode .card-header {
                background: linear-gradient(45deg, #1e1e1e, #2d2d2d);
                border-bottom-color: #3d3d3d;
                color: #ffffff;
            }
            body.dark-mode .card-body {
                color: #ffffff;
                background-color: #1e1e1e;
            }
            /* Stats cards */
            body.dark-mode .stat-card {
                background-color: #2d2d2d;
                color: #ffffff;
            }
            /* Links in dark mode */
            body.dark-mode a:not(.btn):not(.nav-link) {
                color: #63b3ed;
            }
            body.dark-mode a:not(.btn):not(.nav-link):hover {
                color: #90cdf4;
            }
            /* Global button text color fix (apply only in dark mode to avoid white-on-white in light theme) */
            body.dark-mode .btn {
                color: #ffffff !important;
            }

            /* Button styles in dark mode */
            body.dark-mode .btn-primary {
                background: linear-gradient(45deg, #3182ce, #4299e1);
                border-color: #3182ce;
            }
            body.dark-mode .btn-primary:hover {
                background: linear-gradient(45deg, #2c5282, #3182ce);
                border-color: #2c5282;
            }
            body.dark-mode .btn-secondary {
                background: linear-gradient(45deg, #4a5568, #718096);
                border-color: #4a5568;
            }
            body.dark-mode .btn-secondary:hover {
                background: linear-gradient(45deg, #2d3748, #4a5568);
                border-color: #2d3748;
            }
            body.dark-mode .btn-success {
                background: linear-gradient(45deg, #2f855a, #38a169);
                border-color: #2f855a;
            }
            body.dark-mode .btn-success:hover {
                background: linear-gradient(45deg, #276749, #2f855a);
                border-color: #276749;
            }
            body.dark-mode .btn-danger {
                background: linear-gradient(45deg, #c53030, #e53e3e);
                border-color: #c53030;
            }
            body.dark-mode .btn-danger:hover {
                background: linear-gradient(45deg, #9b2c2c, #c53030);
                border-color: #9b2c2c;
            }
            body.dark-mode .btn-info {
                background: linear-gradient(45deg, #319795, #38b2ac);
                border-color: #319795;
            }
            body.dark-mode .btn-info:hover {
                background: linear-gradient(45deg, #2c7a7b, #319795);
                border-color: #2c7a7b;
            }
            /* View button styles for both light and dark modes */
            .btn-view {
                background: linear-gradient(45deg, #3182ce, #4299e1);
                border-color: #3182ce;
            }
            .btn-view:hover {
                background: linear-gradient(45deg, #2c5282, #3182ce);
                border-color: #2c5282;
            }
            /* Dark mode specific view button overrides if needed */
            body.dark-mode .btn-view {
                background: linear-gradient(45deg, #3182ce, #4299e1);
                border-color: #3182ce;
            }
            /* Toggle password button (small eye) - visible in both themes */
            .btn-toggle-password {
                background: transparent;
                border: 1px solid rgba(0,0,0,0.08);
                color: #0d6efd;
                padding: 0.4rem 0.6rem;
                margin-left: 0.25rem;
                border-radius: 0.375rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .btn-toggle-password i { pointer-events: none; }
            .btn-toggle-password:hover { background: rgba(0,0,0,0.04); }

            body.dark-mode .btn-toggle-password {
                border-color: rgba(255,255,255,0.12);
                color: #ffffff;
            }
            body.dark-mode .btn-toggle-password:hover { background: rgba(255,255,255,0.04); }
            body.dark-mode .btn-view:hover {
                background: linear-gradient(45deg, #2c5282, #3182ce);
                border-color: #2c5282;
            }
            /* Table styles for dark mode */
            body.dark-mode .table {
                color: #ffffff !important;
            }
            body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
                background-color: rgba(255, 255, 255, 0.05) !important;
            }
            body.dark-mode .table-striped > tbody > tr:nth-of-type(even) {
                background-color: rgba(0, 0, 0, 0.2) !important;
            }
            body.dark-mode .table thead th {
                background-color: #2d2d2d !important;
                color: #ffffff !important;
                border-bottom: 2px solid #3d3d3d !important;
            }
            body.dark-mode .table td {
                border-color: #3d3d3d !important;
                color: #ffffff !important;
            }
            body.dark-mode .table-hover tbody tr:hover {
                background-color: rgba(255, 255, 255, 0.1) !important;
                color: #ffffff !important;
            }
            /* Table responsive wrapper */
            body.dark-mode .table-responsive {
                background-color: #1e1e1e;
                border-radius: 0.25rem;
            }
            /* Table styles */
            body.dark-mode .table {
                color: #ffffff !important;
                border-color: #2d2d2d !important;
                background-color: #1e1e1e !important;
            }
            body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) > * {
                background-color: #252525 !important;
                color: #ffffff !important;
                --bs-table-striped-bg: #252525 !important;
                --bs-table-striped-color: #ffffff !important;
            }
            body.dark-mode .table-striped > tbody > tr:nth-of-type(even) > * {
                background-color: #1e1e1e !important;
                color: #ffffff !important;
            }
            body.dark-mode .table > :not(caption) > * > * {
                background-color: #1e1e1e !important;
                color: #ffffff !important;
                border-bottom-color: #2d2d2d !important;
            }
            body.dark-mode .table td,
            body.dark-mode .table th {
                border-color: #2d2d2d !important;
                background-color: inherit !important;
            }
            body.dark-mode .table thead th {
                background-color: #2d2d2d !important;
                border-bottom-color: #3d3d3d !important;
                color: #ffffff !important;
            }
            body.dark-mode .table-hover tbody tr:hover {
                background-color: #2d2d2d !important;
                color: #ffffff !important;
            }
            /* Override Bootstrap's default table styles */
            body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
                --bs-table-accent-bg: #252525 !important;
            }
            /* Form styles */
            body.dark-mode .form-control,
            body.dark-mode .form-select {
                background-color: #2d2d2d;
                border-color: #3d3d3d;
                color: #ffffff;
            }
            body.dark-mode .form-control:focus,
            body.dark-mode .form-select:focus {
                background-color: #2d2d2d;
                border-color: #4d4d4d;
                color: #ffffff;
                box-shadow: 0 0 0 0.25rem rgba(66, 70, 73, 0.5);
            }
            body.dark-mode .input-group-text {
                background-color: #2d2d2d;
                border-color: #3d3d3d;
                color: #ffffff;
            }
            /* Button styles */
            body.dark-mode .btn-secondary {
                background-color: #4d4d4d;
                border-color: #5d5d5d;
                color: #ffffff;
            }
            body.dark-mode .btn-secondary:hover {
                background-color: #5d5d5d;
                border-color: #6d6d6d;
            }
            /* Text and link colors */
            body.dark-mode a {
                color: #63b3ed;
            }
            body.dark-mode a:hover {
                color: #7cc5ff;
            }
            body.dark-mode .text-muted {
                color: #a0aec0 !important;
            }
            /* Alert styles */
            body.dark-mode .alert {
                background-color: #2d2d2d;
                border-color: #3d3d3d;
                color: #ffffff;
            }
            /* Badge styles */
            body.dark-mode .badge {
                background-color: #2d2d2d;
                color: #ffffff;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash messages & validation errors -->
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-4 rounded-lg p-4 bg-green-50 text-green-800 border border-green-100">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-lg p-4 bg-red-50 text-red-800 border border-red-100">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-4 rounded-lg p-4 bg-yellow-50 text-yellow-800 border border-yellow-100">
                        {{ session('warning') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-4 rounded-lg p-4 bg-blue-50 text-blue-800 border border-blue-100">
                        {{ session('info') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-lg p-4 bg-red-50 text-red-800 border border-red-100">
                        <div class="font-medium">There were some problems with your input:</div>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="container">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="" crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const themeToggle = document.getElementById('themeToggle');
                const themeIcon = document.getElementById('themeIcon');
                const themeText = document.getElementById('themeText');
                
                // Check for saved theme preference
                const isDarkMode = localStorage.getItem('darkMode') === 'true';
                if (isDarkMode) {
                    document.body.classList.add('dark-mode');
                    themeIcon.classList.replace('fa-sun', 'fa-moon');
                    themeText.textContent = 'Dark Mode';
                }

                // Theme toggle handler
                themeToggle.addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');
                    const isDark = document.body.classList.contains('dark-mode');
                    
                    // Update icon and text
                    if (isDark) {
                        themeIcon.classList.replace('fa-sun', 'fa-moon');
                        themeText.textContent = 'Dark Mode';
                    } else {
                        themeIcon.classList.replace('fa-moon', 'fa-sun');
                        themeText.textContent = 'Light Mode';
                    }
                    
                    // Save preference
                    localStorage.setItem('darkMode', isDark);
                });
            });
        </script>
    </body>
</html>
