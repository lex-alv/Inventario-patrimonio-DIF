<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema · SMDIF San Antonio la Isla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: system-ui, sans-serif;
        }

        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .brand-header {
            background-color: #003366;
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 25px;
        }
    </style>
</head>

<body class="d-flex align-items-center min-vh-100 py-4">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show small mb-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card login-card">
                    <div class="brand-header text-center">
                        <i class="bi bi-shield-lock fs-1 mb-2"></i>
                        <h5 class="mb-0 fw-bold">SMDIF Patrimonio</h5>
                        <small class="text-white-50">San Antonio la Isla · Ejercicio 2026</small>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Correo Institucional</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required autofocus>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 mt-2 fw-bold"
                                style="background-color: #003366; border-color: #003366;">
                                Iniciar Sesión
                            </button>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-0 text-center pb-3">
                        <small class="text-muted">Acceso restringido a personal autorizado</small>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>