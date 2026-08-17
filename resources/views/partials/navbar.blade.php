<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 50%, #0d1b2a 100%); padding: 12px 0; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}" style="gap: 12px;">
            <div style="background: rgba(255,255,255,0.1); padding: 5px 12px; border-radius: 12px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" 
                     alt="TransVentas Guatemala" 
                     style="height: 45px; width: auto; display: block; filter: brightness(0) invert(1);">
            </div>
            <div>
                <span style="font-weight: 700; font-size: 1.3rem; color: #ffffff; letter-spacing: 0.5px; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">
                    TransventasGuatemala
                </span>
                <span style="font-weight: 300; font-size: 0.7rem; color: #64b5f6; display: block; margin-top: -3px; letter-spacing: 2px; text-transform: uppercase;">
                    <i class="fas fa-map-marker-alt" style="font-size: 0.6rem;"></i> Guatemala
                </span>
            </div>
        </a>

        <!-- Botón toggle para móvil -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                style="border: 1px solid rgba(255,255,255,0.2); padding: 8px 12px;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}"
                       style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 8px 18px; border-radius: 8px; transition: all 0.3s;">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
                
                <!-- ✅ DROPDOWN DE VEHÍCULOS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" 
                    href="#" 
                    id="vehiclesDropdown" 
                    role="button" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false"
                    style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 8px 18px; border-radius: 8px; transition: all 0.3s;">
                        <i class="fas fa-truck"></i> Vehículos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" 
                        style="background: #1a1a3e; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('vehicles.index') }}"
                            style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 0; transition: all 0.3s;">
                                <i class="fas fa-list me-2"></i> Todos los Vehículos
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('vehicles.index') }}?type=camion"
                            style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 0; transition: all 0.3s;">
                                <i class="fas fa-truck me-2"></i> 🚛 Camiones
                            </a>
                        </li>
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('vehicles.index') }}?type=furgon"
                            style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 0; transition: all 0.3s;">
                                <i class="fas fa-truck me-2"></i> 🚐 Furgones
                            </a>
                        </li>
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('vehicles.index') }}?type=plataforma"
                            style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 0; transition: all 0.3s;">
                                <i class="fas fa-cube me-2"></i> 📦 Plataformas
                            </a>
                        </li>
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('vehicles.index') }}?type=remolque"
                            style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 0; transition: all 0.3s;">
                                <i class="fas fa-link me-2"></i> 🔗 Remolques
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Beneficios -->
                <li class="nav-item">
                    <a class="nav-link" 
                       href="/beneficios"
                       style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 8px 18px; border-radius: 8px; transition: all 0.3s;">
                        <i class="fas fa-star"></i> Beneficios
                    </a>
                </li>
                
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}"
                               style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 8px 18px; border-radius: 8px; transition: all 0.3s;">
                                <i class="fas fa-cog"></i> Admin
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Menú usuario -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" 
                           href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" 
                           style="color: #ffffff; font-weight: 500; background: rgba(255,255,255,0.1); padding: 8px 18px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <i class="fas fa-user-circle me-2" style="font-size: 1.2rem;"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="background: #1a1a3e; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 8px 0; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                           
                            <li>
                                <a class="dropdown-item" href="{{ route('alerts.index') }}" 
                                   style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 8px; transition: all 0.3s;">
                                    <i class="fas fa-regular fa-bell text-white me-2"></i> Mis Alertas
                                </a>
                            </li>

                             <li>
                                <a class="dropdown-item" href="{{ route('favorites.index') }}" 
                                   style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 8px; transition: all 0.3s;">
                                    <i class="fas fa-heart text-danger me-2"></i> Mis Favoritos
                                    @php
                                        $favoritosCount = auth()->user()->favorites()->count();
                                    @endphp
                                    @if($favoritosCount > 0)
                                        <span class="badge bg-danger float-end">{{ $favoritosCount }}</span>
                                    @endif
                                </a>
                            </li>
                            @if(auth()->user()->is_admin)
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}" 
                                       style="color: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 8px; margin: 2px 8px; transition: all 0.3s;">
                                        <i class="fas fa-cog me-2"></i> Panel Admin
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1); margin: 4px 8px;"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" 
                                            style="color: #ff6b6b; padding: 10px 20px; border-radius: 8px; margin: 2px 8px; transition: all 0.3s; width: 100%; text-align: left; background: none; border: none;">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" 
                           style="color: rgba(255,255,255,0.9); font-weight: 500; padding: 8px 18px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" 
                           style="color: #ffffff; font-weight: 500; padding: 8px 22px; border-radius: 30px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); border: none; transition: all 0.3s; margin-left: 8px;">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    /* ============================================ */
    /* ESTILOS DEL NAVBAR */
    /* ============================================ */
    
    .navbar-nav .nav-link:hover {
        color: #ffffff !important;
        background: rgba(255,255,255,0.1);
    }
    
    .navbar-nav .nav-link.active {
        color: #ffffff !important;
        background: rgba(13, 110, 253, 0.3);
    }
    
    .dropdown-item:hover {
        background: rgba(255,255,255,0.1) !important;
        color: #ffffff !important;
    }
    
    .dropdown-item i {
        width: 20px;
        text-align: center;
    }
    
    @media (max-width: 992px) {
        .navbar-nav .nav-link {
            padding: 10px 15px !important;
        }
        .navbar-nav .nav-link.active {
            background: rgba(13, 110, 253, 0.2);
        }
        .dropdown-menu {
            background: rgba(26, 26, 62, 0.95) !important;
        }
    }
</style>