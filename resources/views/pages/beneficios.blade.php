@extends('layouts.app')

@section('title', 'Beneficios de Registrarse - TransVentas Guatemala')

@section('content')
<div class="container py-5">
    
    <!-- ============================================ -->
    <!-- HERO DE LA SECCIÓN -->
    <!-- ============================================ -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-star text-warning"></i>
            ¿Por qué registrarte?
        </h1>
        <p class="lead text-muted">Descubre todos los beneficios que tenemos para ti</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            @auth
                <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-search"></i> Explorar Vehículos
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-user-plus"></i> Registrarse Ahora
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
            @endauth
        </div>
    </div>

    <!-- ============================================ -->
    <!-- BENEFICIOS -->
    <!-- ============================================ -->
    <div class="row g-4">
        
        <!-- Beneficio 1: Favoritos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-heart fa-3x text-danger"></i>
                </div>
                <h4 class="fw-bold">❤️ Favoritos</h4>
                <p class="text-muted">Guarda tus vehículos favoritos y accede a ellos rápidamente desde tu perfil.</p>
                <ul class="list-unstyled text-start text-muted mt-2">
                    <li><i class="fas fa-check-circle text-success me-2"></i> Guarda vehículos que te interesan</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Accede rápido desde tu perfil</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Recibe notificaciones de cambios</li>
                </ul>
            </div>
        </div>

        <!-- Beneficio 2: Contacto Directo -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-envelope fa-3x text-success"></i>
                </div>
                <h4 class="fw-bold">📧 Contacto Directo</h4>
                <p class="text-muted">Envía mensajes directamente a los vendedores desde la página del vehículo.</p>
                <ul class="list-unstyled text-start text-muted mt-2">
                    <li><i class="fas fa-check-circle text-success me-2"></i> Mensajes directos a vendedores</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Historial de conversaciones</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Respuesta rápida</li>
                </ul>
            </div>
        </div>

        <!-- Beneficio 3: Alertas -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-bell fa-3x text-warning"></i>
                </div>
                <h4 class="fw-bold">🔔 Alertas Personalizadas</h4>
                <p class="text-muted">Recibe notificaciones cuando haya vehículos que coincidan con tus intereses.</p>
                <ul class="list-unstyled text-start text-muted mt-2">
                    <li><i class="fas fa-check-circle text-success me-2"></i> Alertas de nuevos vehículos</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Notificaciones de precios</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Personaliza tus preferencias</li>
                </ul>
            </div>
        </div>

        <!-- Beneficio 4: Historial -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-history fa-3x text-info"></i>
                </div>
                <h4 class="fw-bold">📊 Historial de Vistas</h4>
                <p class="text-muted">Revisa los vehículos que has visitado y encuentra lo que buscas fácilmente.</p>
                <ul class="list-unstyled text-start text-muted mt-2">
                    <li><i class="fas fa-check-circle text-success me-2"></i> Vehículos visitados recientemente</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Fácil acceso a tus búsquedas</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Recomendaciones personalizadas</li>
                </ul>
            </div>
        </div>

        <!-- ✅ Beneficio 5: Publicar Vehículos (Próximamente) -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px; border: 2px dashed #dee2e6; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-clock fa-3x text-primary"></i>
                </div>
                <h4 class="fw-bold">🚀 Publica tus Vehículos</h4>
                <p class="text-muted small">¿Tienes vehículos que quieres vender? Pronto podrás publicar tus anuncios.</p>
                
                <div class="mt-2">
                    <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 0.85rem;">
                        <i class="fas fa-clock me-1"></i> Próximamente
                    </span>
                    <br>
                    <span class="badge bg-danger mt-1 px-3 py-2" style="font-size: 0.75rem;">
                        <i class="fas fa-hourglass-half me-1"></i> Opción aún no disponible
                    </span>
                </div>
                
                <hr class="my-3">
                
                <div class="text-start">
                    <p class="text-muted small mb-2">
                        <i class="fas fa-upload text-primary me-2"></i> Publica tus camiones, furgones y plataformas
                    </p>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-users text-primary me-2"></i> Llega a miles de compradores potenciales
                    </p>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-chart-line text-primary me-2"></i> Estadísticas de tus publicaciones
                    </p>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-bell text-primary me-2"></i> Recibe notificaciones de interés
                    </p>
                </div>
                
               
                <!-- <div class="mt-3">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-user-plus"></i> Registrarme para aviso
                    </a>
                </div> -->
            </div>
        </div>

        <!-- Beneficio 6: Soporte Prioritario (opcional) -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-headset fa-3x text-danger"></i>
                </div>
                <h4 class="fw-bold">💬 Soporte Prioritario</h4>
                <p class="text-muted">Como usuario registrado, tienes acceso a soporte prioritario para resolver tus dudas.</p>
                <ul class="list-unstyled text-start text-muted mt-2">
                    <li><i class="fas fa-check-circle text-success me-2"></i> Atención prioritaria</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Resolución rápida</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Asesoría personalizada</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- LLAMADA A LA ACCIÓN -->
    <!-- ============================================ -->
    <div class="mt-5 p-5 text-center rounded-4" 
         style="background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 50%, #0d1b2a 100%);">
        <h2 class="text-white mb-3">
            <i class="fas fa-rocket text-primary"></i>
            ¡Únete a TransVentas Guatemala hoy!
        </h2>
        <p class="text-white-50 mb-4">Crea tu cuenta gratuita y disfruta de todos estos beneficios</p>
        @auth
            <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-search"></i> Explorar Vehículos
            </a>
        @else
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-user-plus"></i> Registrarse Gratis
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 ms-2">
                <i class="fas fa-sign-in-alt"></i> Ya tengo cuenta
            </a>
        @endauth
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: default;
    }
    .hover-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
</style>

@endsection