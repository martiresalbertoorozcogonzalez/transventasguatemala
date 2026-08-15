<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrarse - TransVentas Guatemala</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 40%, #0d1b2a 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
            max-width: 460px;
            width: 100%;
            padding: 40px;
        }
        
        .register-card .logo {
            max-height: 80px;
            width: auto;
            margin-bottom: 15px;
        }
        
        .register-card .brand-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a1a3e;
            letter-spacing: 0.5px;
        }
        
        .register-card .brand-name span {
            color: #0d6efd;
        }
        
        .register-card .brand-sub {
            font-size: 0.85rem;
            color: #64b5f6;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .register-card .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .register-card .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        
        .register-card .btn-register {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            background: linear-gradient(135deg, #198754, #20c997);
            border: none;
            transition: all 0.3s ease;
        }
        
        .register-card .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(25, 135, 84, 0.3);
        }
        
        .register-card .login-link {
            color: #0d6efd;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .register-card .login-link:hover {
            color: #0a58ca;
            text-decoration: underline;
        }
        
        .password-requirements {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 4px;
        }
        
        .password-requirements .valid {
            color: #198754;
        }
        
        .password-requirements .invalid {
            color: #dc3545;
        }
        
        @media (max-width: 576px) {
            .register-card {
                padding: 30px 20px;
            }
            .register-card .brand-name {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    
    <div class="register-card">
        <!-- ============================================ -->
        <!-- LOGO Y MARCA -->
        <!-- ============================================ -->
        <div class="text-center mb-4">
            <a href="/">
                <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" 
                     alt="TransVentas Guatemala" 
                     class="logo">
            </a>
            <h1 class="brand-name">
                Transventas
                <span>Guatemala</span>
            </h1>
            <p class="brand-sub">
                <i class="fas fa-user-plus"></i> Crea tu cuenta gratis
            </p>
        </div>
        
        <!-- ============================================ -->
        <!-- MENSAJES DE ERROR -->
        <!-- ============================================ -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- ============================================ -->
        <!-- FORMULARIO DE REGISTRO -->
        <!-- ============================================ -->
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- Redirect (si viene de alguna página) -->
            @if(request()->has('redirect'))
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            @endif
            
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">
                    <i class="fas fa-user me-1"></i> Nombre Completo
                </label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Tu nombre"
                       required 
                       autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                    <i class="fas fa-envelope me-1"></i> Correo Electrónico
                </label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="tu@email.com"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    <i class="fas fa-lock me-1"></i> Contraseña
                </label>
                <div class="position-relative">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Mínimo 8 caracteres"
                           required>
                    <button type="button" 
                            class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent"
                            style="right: 10px;"
                            onclick="togglePassword('password', this)">
                        <i class="fas fa-eye text-muted"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="password-requirements">
                    <small>La contraseña debe tener al menos 8 caracteres</small>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">
                    <i class="fas fa-check-circle me-1"></i> Confirmar Contraseña
                </label>
                <div class="position-relative">
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Repite tu contraseña"
                           required>
                    <button type="button" 
                            class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent"
                            style="right: 10px;"
                            onclick="togglePassword('password_confirmation', this)">
                        <i class="fas fa-eye text-muted"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="btn btn-success btn-register w-100">
                <i class="fas fa-user-plus me-2"></i> Crear Cuenta
            </button>
        </form>
        
        <!-- ============================================ -->
        <!-- ENLACE A LOGIN -->
        <!-- ============================================ -->
        <div class="text-center mt-4">
            <p class="text-muted small">
                ¿Ya tienes cuenta? 
                <a href="{{ route('login') }}" class="login-link">
                    Inicia Sesión <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </p>
        </div>
        
        <!-- ============================================ -->
        <!-- BENEFICIOS DE REGISTRARSE -->
        <!-- ============================================ -->
        <div class="mt-4 p-3 bg-light rounded-3" style="border: 1px solid #e9ecef;">
            <small class="text-muted d-block text-center fw-semibold mb-2">✨ Beneficios al registrarte</small>
            <div class="row text-center small">
                <div class="col-4">
                    <i class="fas fa-heart text-danger"></i>
                    <br>
                    <span class="text-muted">Favoritos</span>
                </div>
                <div class="col-4">
                    <i class="fas fa-envelope text-success"></i>
                    <br>
                    <span class="text-muted">Contacto</span>
                </div>
                <div class="col-4">
                    <i class="fas fa-bell text-warning"></i>
                    <br>
                    <span class="text-muted">Alertas</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ============================================ -->
    <!-- SCRIPTS -->
    <!-- ============================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash text-muted';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye text-muted';
            }
        }
    </script>
</body>
</html>