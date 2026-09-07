<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema · SMDIF San Antonio la Isla</title>
    
    <!-- Fuentes Google: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Hoja de Estilos Institucional SMDIF -->
    <link rel="stylesheet" href="{{ asset('css/institutional-theme.css') }}">
    
    <style>
        .login-wrapper {
            min-height: 100vh;
            background: linear-gradient(180deg, #F1F5F9 0%, #E2E8F0 100%);
        }
        .login-card {
            border: 1px solid var(--gov-border) !important;
            border-radius: var(--gov-radius-lg) !important;
            box-shadow: 0 4px 16px rgba(15, 45, 89, 0.08) !important;
            background-color: #FFFFFF;
        }
        .login-header {
            background-color: var(--gov-primary);
            color: #FFFFFF;
            padding: 2rem 1.5rem 1.75rem;
            text-align: center;
            border-bottom: 3px solid var(--gov-secondary);
        }
    </style>
</head>

<body class="login-wrapper d-flex align-items-center py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div class="flex-grow-1">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card login-card">
                    <div class="login-header">
                        <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(255,255,255,0.12); border-radius: 6px; border: 1px solid rgba(255,255,255,0.2);">
                            <i class="bi bi-shield-lock-fill fs-3 text-white"></i>
                        </div>
                        <h5 class="mb-1 fw-bold text-white">SMDIF Patrimonio</h5>
                        <p class="mb-0 small text-white-50">San Antonio la Isla · Ejercicio 2026</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Correo Institucional</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email"
                                        class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                        value="{{ old('email') }}"
                                        placeholder="usuario@dif.gob.mx"
                                        required autofocus>
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" 
                                        class="form-control border-start-0" 
                                        placeholder="••••••••"
                                        required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Ingresar al Sistema
                            </button>
                        </form>
                    </div>
                    
                    <div class="card-footer bg-light border-top text-center py-2">
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="bi bi-info-circle me-1"></i>Sistema protegido · Acceso solo a personal autorizado
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>