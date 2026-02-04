<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'QR Code Generator & Reader')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --dark-bg: #0a0a0a;
            --purple-dark: #6b46c1;
            --purple-medium: #7c3aed;
            --purple-light: #8b5cf6;
            --purple-accent: #5b21b6;
        }
        
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a0a2e 50%, #0a0a0a 100%);
            background-attachment: fixed;
            color: #ffffff;
            min-height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(107, 70, 193, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(124, 58, 237, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 90%, rgba(91, 33, 182, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .navbar {
            background: rgba(10, 10, 10, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(107, 70, 193, 0.3);
            box-shadow: 0 4px 30px rgba(107, 70, 193, 0.1);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: #e5e7eb !important;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            color: var(--purple-light) !important;
        }
        
        .nav-link {
            color: #d1d5db !important;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--purple-light) !important;
            transform: translateY(-2px);
        }
        
        .card {
            background: rgba(17, 17, 27, 0.8) !important;
            border: 2px solid rgba(139, 92, 246, 0.6);
            backdrop-filter: blur(10px);
            box-shadow: 
                0 8px 32px 0 rgba(107, 70, 193, 0.3),
                0 0 40px rgba(139, 92, 246, 0.4),
                inset 0 0 20px rgba(139, 92, 246, 0.1);
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            color: #ffffff !important;
        }
        
        .card .card-title,
        .card .card-text {
            color: #ffffff !important;
        }
        
        .card:hover {
            border-color: rgba(139, 92, 246, 0.9);
            box-shadow: 
                0 12px 40px 0 rgba(107, 70, 193, 0.5),
                0 0 60px rgba(139, 92, 246, 0.6),
                inset 0 0 30px rgba(139, 92, 246, 0.2);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple-accent) 100%) !important;
            border-bottom: 1px solid rgba(107, 70, 193, 0.3);
            color: white !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple-medium) 100%);
            border: 1px solid var(--purple-light);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--purple-medium) 0%, var(--purple-light) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: 1px solid #34d399;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }
        
        .btn-secondary {
            background: rgba(55, 65, 81, 0.8);
            border: 1px solid rgba(107, 114, 128, 0.5);
        }
        
        .btn-secondary:hover {
            background: rgba(75, 85, 99, 1);
            transform: translateY(-2px);
        }
        
        .form-control, .form-select {
            background: rgba(17, 17, 27, 0.9) !important;
            border: 1px solid rgba(107, 70, 193, 0.3);
            color: #e5e7eb !important;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(17, 17, 27, 1) !important;
            border-color: var(--purple-light);
            box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.25);
            color: #e5e7eb !important;
        }
        
        .form-control::placeholder {
            color: #9ca3af;
        }
        
        .form-label {
            color: #ffffff;
            font-weight: 500;
        }
        
        .form-text {
            color: #d1d5db;
        }
        
        .alert-success {
            background: rgba(5, 150, 105, 0.2) !important;
            border: 1px solid rgba(16, 185, 129, 0.5);
            color: #ffffff;
        }
        
        .alert-danger {
            background: rgba(220, 38, 38, 0.2) !important;
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #ffffff;
        }
        
        .qr-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .qr-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(107, 70, 193, 0.3);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple-accent) 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        
        @media (min-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
        }
        
        @media (min-width: 992px) {
            .hero-section {
                padding: 80px 0;
            }
        }
        
        /* Responsive font sizes */
        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 2rem !important;
            }
            
            .hero-section .lead {
                font-size: 1.1rem !important;
            }
            
            .qr-card .card-body {
                padding: 1.5rem !important;
            }
            
            .qr-card i {
                font-size: 3rem !important;
            }
        }
        
        @media (min-width: 577px) and (max-width: 767px) {
            .hero-section h1 {
                font-size: 2.5rem !important;
            }
        }
        
        .feature-card {
            background: rgba(17, 17, 27, 0.6);
            border: 2px solid rgba(139, 92, 246, 0.4);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(139, 92, 246, 0.8);
            box-shadow: 
                0 12px 30px rgba(107, 70, 193, 0.4),
                0 0 50px rgba(139, 92, 246, 0.5);
        }
        
        .feature-icon {
            font-size: 3rem;
            background: linear-gradient(135deg, var(--purple-dark), var(--purple-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        footer {
            background: rgba(10, 10, 10, 0.95) !important;
            border-top: 1px solid rgba(107, 70, 193, 0.3);
            position: relative;
            z-index: 1;
            margin-top: auto;
        }
        
        .bg-success {
            background: linear-gradient(135deg, #059669, #10b981) !important;
        }
        
        .border {
            border-color: rgba(107, 70, 193, 0.3) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-qr-code-scan"></i> QR System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door"></i> Inici
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('qr/create') ? 'active' : '' }}" href="{{ route('qr.create') }}">
                            <i class="bi bi-plus-circle"></i> Crear QR
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('qr/read') ? 'active' : '' }}" href="{{ route('qr.read') }}">
                            <i class="bi bi-search"></i> Llegir QR
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <p class="mb-0">
                <i class="bi bi-qr-code"></i> QR Code System &copy; {{ date('Y') }}
            </p>
            <small class="text-muted">Generat amb Laravel & Bootstrap</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
