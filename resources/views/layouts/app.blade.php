<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control Patrimonial · SMDIF San Antonio la Isla</title>
    
    <!-- Fuentes Google: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Hoja de Estilos Institucional SMDIF -->
    <link rel="stylesheet" href="{{ asset('css/institutional-theme.css') }}">
</head>

<body>

    <!-- Barra de Navegación Institucional Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark gov-navbar mb-4 sticky-top">
        <div class="container-fluid px-lg-4">
            <a class="navbar-brand py-1" href="{{ route('dashboard') }}">
                <i class="bi bi-shield-check me-2 fs-5" style="color: #60A5FA;"></i>
                <span>SMDIF Patrimonio</span>
                <span class="brand-badge d-none d-sm-inline">San Antonio la Isla</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Panel General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bienes.*') ? 'active' : '' }}" href="{{ route('bienes.index') }}">
                            <i class="bi bi-box-seam me-1"></i>Inventario General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('resguardos.*') ? 'active' : '' }}" href="{{ route('resguardos.index') }}">
                            <i class="bi bi-person-badge me-1"></i>Resguardos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('empleados.*') ? 'active' : '' }}" href="{{ route('empleados.index') }}">
                            <i class="bi bi-people me-1"></i>Personal / Resguardos
                        </a>
                    </li>
                    @if(Auth::check() && Auth::user()->rol === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bajas.*') ? 'active' : '' }}" href="{{ route('bajas.index') }}">
                            <i class="bi bi-file-earmark-x me-1"></i>Bajas
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('escaner') ? 'active' : '' }}" href="{{ route('escaner') }}">
                            <i class="bi bi-qr-code-scan me-1"></i>Escanear QR
                        </a>
                    </li>
                </ul>

                @auth
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-dropdown-btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1 text-white-50"></i>
                            <span class="fw-semibold text-white">{{ Auth::user()->name }}</span>
                            <span class="badge {{ Auth::user()->rol === 'admin' ? 'badge-gov-wine' : 'badge-gov-secondary' }} ms-1">
                                {{ strtoupper(Auth::user()->rol) }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2 border-bottom">
                                <div class="small fw-bold text-dark">{{ Auth::user()->name }}</div>
                                <div class="small text-muted font-mono-num">{{ Auth::user()->email }}</div>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container-fluid px-lg-4 mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-6"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>