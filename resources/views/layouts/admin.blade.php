<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #1a252f 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .admin-sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            margin: 2px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .admin-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .admin-sidebar .nav-link.active {
            background: #3498db;
            color: #fff;
        }
        .admin-sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .admin-sidebar .brand {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-sidebar .brand h4 {
            color: #fff;
            font-weight: 300;
        }
        .admin-sidebar .brand h4 i {
            color: #3498db;
        }
        .admin-content {
            padding: 20px;
        }
        .admin-topbar {
            background: #fff;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #3498db;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .table img {
            border-radius: 5px;
        }
        .btn-group-sm .btn {
            margin: 0 2px;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block admin-sidebar p-0">
                <div class="brand">
                    <h4><i class="fas fa-truck"></i> Admin</h4>
                    <small class="text-white-50">Panel de Control</small>
                </div>
                <ul class="nav flex-column p-3">
                    <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                         href="{{ route('admin.dashboard') }}">
                           <i class="fas fa-chart-pie"></i> Dashboard
                     </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}" 
                           href="{{ route('admin.vehicles.index') }}">
                            <i class="fas fa-truck"></i> Vehículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.vehicles.create') ? 'active' : '' }}" 
                           href="{{ route('admin.vehicles.create') }}">
                            <i class="fas fa-plus-circle"></i> Nuevo Vehículo
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <hr class="border-light">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-globe"></i> Ver Sitio
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link" style="border: none; background: none; width: 100%; text-align: left; color: #ecf0f1;">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
            
            <!-- Contenido principal -->
            <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                <!-- Top Bar -->
                <div class="admin-topbar d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">@yield('title')</h5>
                    </div>
                    <div class="user-info">
                        <span>{{ Auth::user()->name }}</span>
                        <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </div>
                </div>
                
                <!-- Mensajes de éxito -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>