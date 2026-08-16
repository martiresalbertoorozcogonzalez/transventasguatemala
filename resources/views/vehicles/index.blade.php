@extends('layouts.app')

@section('title', request('type') ? ucfirst(request('type')) . ' - TransVentas Guatemala' : (request('q') ? 'Resultados para: ' . request('q') . ' - TransVentas Guatemala' : 'TransVentas Guatemala - Camiones, Furgones y Plataformas'))

@section('meta_description', request('type') ? 'Encuentra los mejores ' . request('type') . ' en Guatemala' : (request('q') ? 'Resultados de búsqueda para ' . request('q') : 'Encuentra los mejores camiones, furgones y plataformas en venta en Guatemala.'))

@section('content')

@php
    // Detectar filtros activos
    $hasFilters = request()->has('type') || 
                  request()->has('brand') || 
                  request()->has('min_price') || 
                  request()->has('max_price') || 
                  request()->has('year_from') || 
                  request()->has('year_to');
                  
    $hasSearch = request()->has('q') && request()->q != '';
    
    // Categorías
    $categorias = [
        'camion' => ['nombre' => 'Camiones', 'emoji' => '🚛', 'icon' => 'fa-truck', 'color' => '#0d6efd', 'bg' => 'linear-gradient(135deg, #0a0a1a 0%, #0d6efd 50%, #0dcaf0 100%)'],
        'furgon' => ['nombre' => 'Furgones', 'emoji' => '🚐', 'icon' => 'fa-truck-fast', 'color' => '#198754', 'bg' => 'linear-gradient(135deg, #0a0a1a 0%, #198754 50%, #20c997 100%)'],
        'plataforma' => ['nombre' => 'Plataformas', 'emoji' => '📦', 'icon' => 'fa-cube', 'color' => '#ffc107', 'bg' => 'linear-gradient(135deg, #0a0a1a 0%, #ffc107 50%, #fd7e14 100%)'],
        'remolque' => ['nombre' => 'Remolques', 'emoji' => '🔗', 'icon' => 'fa-link', 'color' => '#6f42c1', 'bg' => 'linear-gradient(135deg, #0a0a1a 0%, #6f42c1 50%, #d63384 100%)']
    ];
    
    $categoriaActual = request('type') && isset($categorias[request('type')]) ? $categorias[request('type')] : null;
@endphp

<!-- ============================================ -->
<!-- BANNER DE CATEGORÍA -->
<!-- ============================================ -->
@if($categoriaActual)
    <div class="category-banner position-relative overflow-hidden rounded-4 mb-4" 
         style="background: {{ $categoriaActual['bg'] }}; min-height: 20vh; display: flex; align-items: center; justify-content: center; padding: 25px 0;">

        <div class="position-absolute top-50 start-50 translate-middle" 
             style="width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.08), transparent 70%); border-radius: 50%;">
        </div>

        <div class="container position-relative text-center" style="z-index: 2;">
            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                <span style="font-size: 2.5rem; text-shadow: 0 0 40px rgba(255,255,255,0.3);">
                    {{ $categoriaActual['emoji'] }}
                </span>
                <h2 class="fw-bold text-white mb-0" 
                    style="text-shadow: 0 0 40px rgba(0,0,0,0.3); font-size: 2.2rem;">
                    {{ $categoriaActual['nombre'] }}
                </h2>
                <span class="badge bg-white text-dark px-3 py-2 fs-6">
                    <i class="fas fa-truck me-2"></i> {{ $vehicles->total() }} vehículos
                </span>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-times me-1"></i> Limpiar búsqueda
                </a>
            </div>
        </div>
    </div>

<!-- ============================================ -->
<!-- BANNER DE BÚSQUEDA -->
<!-- ============================================ -->
@elseif($hasSearch)
    <div class="category-banner position-relative overflow-hidden rounded-4 mb-4" 
         style="background: linear-gradient(135deg, #0a0a1a 0%, #6f42c1 50%, #d63384 100%); min-height: 20vh; display: flex; align-items: center; justify-content: center; padding: 25px 0;">

        <div class="position-absolute top-50 start-50 translate-middle" 
             style="width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.08), transparent 70%); border-radius: 50%;">
        </div>

        <div class="container position-relative text-center" style="z-index: 2;">
            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                <span style="font-size: 2.5rem; text-shadow: 0 0 40px rgba(255,255,255,0.3);">
                    🔍
                </span>
                <h2 class="fw-bold text-white mb-0" 
                    style="text-shadow: 0 0 40px rgba(0,0,0,0.3); font-size: 2.2rem;">
                    Resultados de búsqueda
                </h2>
                <span class="badge bg-white text-dark px-3 py-2 fs-6">
                    <i class="fas fa-search me-2"></i> "{{ request('q') }}"
                </span>
                <span class="badge bg-white text-dark px-3 py-2 fs-6">
                    <i class="fas fa-truck me-2"></i> {{ $vehicles->total() }} vehículos
                </span>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-times me-1"></i> Limpiar búsqueda
                </a>
            </div>
        </div>
    </div>

<!-- ============================================ -->
<!-- BANNER DE FILTROS -->
<!-- ============================================ -->
@elseif($hasFilters)
    <div class="category-banner position-relative overflow-hidden rounded-4 mb-4" 
         style="background: linear-gradient(135deg, #0a0a1a 0%, #fd7e14 50%, #ffc107 100%); min-height: 20vh; display: flex; align-items: center; justify-content: center; padding: 25px 0;">

        <div class="position-absolute top-50 start-50 translate-middle" 
             style="width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.08), transparent 70%); border-radius: 50%;">
        </div>

        <div class="container position-relative text-center" style="z-index: 2;">
            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                <span style="font-size: 2.5rem; text-shadow: 0 0 40px rgba(255,255,255,0.3);">
                    🎯
                </span>
                <h2 class="fw-bold text-white mb-0" 
                    style="text-shadow: 0 0 40px rgba(0,0,0,0.3); font-size: 2.2rem;">
                    Filtros aplicados
                </h2>
                <span class="badge bg-white text-dark px-3 py-2 fs-6">
                    <i class="fas fa-filter me-2"></i> {{ $vehicles->total() }} vehículos
                </span>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-times me-1"></i> Limpiar búsqueda
                </a>
            </div>
            <div class="mt-2 d-flex flex-wrap gap-2 justify-content-center">
                @if(request('type'))
                    <span class="badge bg-primary bg-opacity-75">Tipo: {{ ucfirst(request('type')) }}</span>
                @endif
                @if(request('brand'))
                    <span class="badge bg-primary bg-opacity-75">Marca: {{ request('brand') }}</span>
                @endif
                @if(request('min_price'))
                    <span class="badge bg-primary bg-opacity-75">Q{{ number_format(request('min_price')) }}</span>
                @endif
                @if(request('max_price'))
                    <span class="badge bg-primary bg-opacity-75">Q{{ number_format(request('max_price')) }}</span>
                @endif
                @if(request('year_from'))
                    <span class="badge bg-primary bg-opacity-75">Desde: {{ request('year_from') }}</span>
                @endif
                @if(request('year_to'))
                    <span class="badge bg-primary bg-opacity-75">Hasta: {{ request('year_to') }}</span>
                @endif
            </div>
        </div>
    </div>

<!-- ============================================ -->
<!-- HERO ORIGINAL -->
<!-- ============================================ -->
@else
    <div class="hero-section position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 40%, #0d1b2a 100%); min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 40px 0;">

        <div class="position-absolute top-50 start-50 translate-middle" 
             style="width: 400px; height: 400px; background: radial-gradient(circle, rgba(13,110,253,0.08), transparent 70%); border-radius: 50%;">
        </div>

        <div class="container position-relative text-center" style="z-index: 2; max-width: 850px; margin: 0 auto;">
            
            <div class="d-flex justify-content-center mb-3">
                <div style="display: inline-block; background: #ffffff; border-radius: 50%; padding: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); width: 160px; height: 160px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" 
                         alt="TransVentas Guatemala" 
                         style="width: 110%; height: 110%; object-fit: cover; display: block; margin: -5%;">
                </div>
            </div>

            <h1 class="display-2 fw-bold text-white mb-2" 
                style="text-shadow: 0 0 60px rgba(13,110,253,0.2); letter-spacing: 2px; line-height: 1.2;">
                Transventas</span>
                <span style="color: #64b5f6;">Guatemala</span>
            </h1>

            <p class="lead text-white-50 mb-3" style="font-size: 1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                La pagina líder para comprar y vender 
                <span class="text-white fw-semibold">camiones</span>, 
                <span class="text-white fw-semibold">furgones</span> y 
                <span class="text-white fw-semibold">plataformas</span>.
            </p>

            <div style="max-width: 550px; margin: 0 auto;">
                <form action="/buscar" method="GET" class="position-relative">
                    <div class="input-group shadow-lg" 
                         style="border-radius: 60px; overflow: hidden; background: rgba(255,255,255,0.95); border: 1px solid rgba(255,255,255,0.2);">
                        <span class="input-group-text bg-transparent border-0 ps-4" style="color: #6c757d;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="q"
                               class="form-control bg-transparent border-0 py-2" 
                               placeholder="🔍 Busca por marca, modelo o año..."
                               style="font-size: 0.95rem; color: #2d3436;">
                        <button type="submit" class="btn btn-primary px-4" 
                                style="border-radius: 0 60px 60px 0; font-weight: 500; font-size: 0.95rem; background: linear-gradient(135deg, #0d6efd, #0dcaf0); border: none;">
                            <i class="fas fa-search me-1"></i> Buscar
                        </button>
                    </div>
                </form>
                <p class="text-white-50 small mt-2 text-center" style="opacity: 0.6; font-size: 0.75rem;">
                    <i class="fas fa-lightbulb me-1"></i> Ej: "Mercedes" · "Freightliner" · "2023"
                </p>
            </div>

            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <a href="https://www.facebook.com/TransVentasGuatemala" target="_blank" 
                   class="btn btn-outline-light btn-sm px-4 rounded-pill"
                   style="font-weight: 500; border-width: 1.5px;">
                    <i class="fab fa-facebook me-1"></i> Facebook
                </a>
                <a href="https://www.instagram.com/TransVentasGuatemala" target="_blank" 
                   class="btn btn-outline-light btn-sm px-4 rounded-pill"
                   style="font-weight: 500; border-width: 1.5px;">
                    <i class="fab fa-instagram me-1"></i> Instagram
                </a>
                <a href="https://www.tiktok.com/@TransVentasGuatemala" target="_blank" 
                   class="btn btn-outline-light btn-sm px-4 rounded-pill"
                   style="font-weight: 500; border-width: 1.5px;">
                    <i class="fab fa-tiktok me-1"></i> TikTok
                </a>
            </div>
        </div>
    </div>
@endif

<!-- ============================================ -->
<!-- RESULTADOS DE BÚSQUEDA -->
<!-- ============================================ -->
@if($hasSearch)
<section id="resultados" style="padding: 20px 0 40px 0; background: #f8f9fa; min-height: 50vh;">
    <div class="container">
        @if($vehicles->count() > 0)
            <div class="row">
                @include('components.vehicle-grid', ['vehicles' => $vehicles])
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $vehicles->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h4>No se encontraron vehículos</h4>
                <p class="text-muted">No hay resultados para "<strong>{{ request('q') }}</strong>"</p>
                <a href="{{ route('vehicles.index') }}" class="btn btn-primary">
                    <i class="fas fa-undo"></i> Ver todos los vehículos
                </a>
            </div>
        @endif
    </div>
</section>

<!-- ============================================ -->
<!-- RESULTADOS DE FILTROS Y CATEGORÍAS -->
<!-- ============================================ -->
@elseif($hasFilters || $categoriaActual)
<section id="resultados-filtros" style="padding: 20px 0 40px 0; background: #f8f9fa; min-height: 50vh;">
    <div class="container">
        @if($vehicles->count() > 0)
            <div class="row">
                @include('components.vehicle-grid', ['vehicles' => $vehicles])
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $vehicles->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-filter fa-4x text-muted mb-3"></i>
                <h4>No se encontraron vehículos</h4>
                <p class="text-muted">Prueba con otros filtros</p>
                <a href="{{ route('vehicles.index') }}" class="btn btn-primary">
                    <i class="fas fa-undo"></i> Ver todos los vehículos
                </a>
            </div>
        @endif
    </div>
</section>
@endif

<!-- ============================================ -->
<!-- VEHÍCULOS RECIÉN INGRESADOS -->
<!-- ============================================ -->
@if(!$hasSearch && !$hasFilters && !$categoriaActual)
<section class="mb-5" id="recientes" style="padding-top: 20px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-clock text-success"></i> Recién Ingresados
            </h2>
            <span class="badge bg-success p-2">¡Nuevos!</span>
        </div>
        
        <div class="row">
            @foreach($recentVehicles as $vehicle)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-card" 
                     style="border-radius: 20px; overflow: hidden; transition: all 0.4s; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    
                    <div class="position-relative overflow-hidden">
                        <a href="/vehiculos/{{ $vehicle->slug }}">
                            <div style="width: 100%; height: 220px; background: #ffffff; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; padding: 10px;">
                                @if($vehicle->images && count($vehicle->images) > 0)
                                    <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                         alt="{{ $vehicle->title }}"
                                         style="max-height: 100%; max-width: 100%; object-fit: contain; object-position: center; background: #ffffff;">
                                @else
                                    <i class="fas fa-truck fa-3x text-muted" style="color: #6c757d;"></i>
                                @endif
                            </div>
                        </a>
                        <span class="position-absolute top-0 end-0 badge bg-success m-2 p-2 rounded-pill px-3 py-2" 
                              style="box-shadow: 0 4px 15px rgba(25, 135, 84, 0.4);">
                            <i class="fas fa-clock me-1"></i> Nuevo
                        </span>
                        <span class="position-absolute bottom-0 start-0 badge bg-{{ $vehicle->status_badge }} m-2 p-2 rounded-pill px-3 py-2">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </div>
                    
                    <div class="card-body">
                        <a href="/vehiculos/{{ $vehicle->slug }}" class="text-decoration-none text-dark">
                            <h5 class="card-title fw-bold mb-2">{{ Str::limit($vehicle->title, 40) }}</h5>
                        </a>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-building me-1"></i> {{ $vehicle->brand }}
                            <i class="fas fa-calendar ms-2 me-1"></i> {{ $vehicle->year }}
                            <i class="fas fa-clock ms-2 text-success me-1"></i> {{ $vehicle->created_at->diffForHumans() }}
                        </p>
                        <p class="text-primary fw-bold fs-4 mb-3">{{ $vehicle->price_formatted }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                {{ ucfirst($vehicle->type) }}
                            </span>
                            <a href="/vehiculos/{{ $vehicle->slug }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                Ver Detalles <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ============================================ -->
<!-- TODOS LOS VEHÍCULOS -->
<!-- ============================================ -->
@if(!$hasSearch && !$hasFilters && !$categoriaActual)
<section id="todos-los-vehiculos" style="padding: 20px 0 40px 0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-truck"></i> Todos los Vehículos
            </h2>
            <span class="text-muted">{{ $vehicles->total() }} vehículos disponibles</span>
        </div>

        <div class="row">
            <!-- FILTROS SIDEBAR -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-filter"></i> Filtros
                        </h5>
                        <hr>
                        
                        <form action="/filtrar" method="GET" id="filterForm">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo</label>
                                <select name="type" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Marca</label>
                                <select name="brand" class="form-select">
                                    <option value="">Todas</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                            {{ $brand }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rango de Precio (Q)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" 
                                               name="min_price" 
                                               class="form-control" 
                                               placeholder="Mín" 
                                               value="{{ request('min_price') }}"
                                               step="1000">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" 
                                               name="max_price" 
                                               class="form-control" 
                                               placeholder="Máx" 
                                               value="{{ request('max_price') }}"
                                               step="1000">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Año</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" 
                                               name="year_from" 
                                               class="form-control" 
                                               placeholder="Desde" 
                                               value="{{ request('year_from') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" 
                                               name="year_to" 
                                               class="form-control" 
                                               placeholder="Hasta" 
                                               value="{{ request('year_to') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-search"></i> Aplicar Filtros
                            </button>
                            
                            <a href="/vehiculos" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-undo"></i> Limpiar Filtros
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- LISTA DE VEHÍCULOS -->
            <div class="col-lg-9">
                <div id="vehicleGrid">
                    @include('components.vehicle-grid', ['vehicles' => $vehicles])
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $vehicles->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- ============================================ -->
<!-- SECCIÓN DE BENEFICIOS (solo en página principal) -->
<!-- ============================================ -->
@if(!$hasSearch && !$hasFilters && !$categoriaActual)
<section class="py-5 mt-5" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 20px;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">
                <i class="fas fa-star text-warning"></i>
                ¿Por qué registrarte?
            </h2>
            <p class="text-muted">Descubre todos los beneficios que tenemos para ti</p>
        </div>

        <div class="row g-4">
            
            <!-- Beneficio 1: Favoritos -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="fas fa-heart fa-2x text-danger"></i>
                    </div>
                    <h5 class="fw-bold">❤️ Favoritos</h5>
                    <p class="text-muted small">Guarda tus vehículos favoritos y accede a ellos rápidamente desde tu perfil.</p>
                </div>
            </div>

            <!-- Publicar Vehículos -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px; border: 2px solid #0d6efd;">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="fas fa-upload fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-primary">🚀 Publica tus Vehículos</h5>
                    <p class="text-muted small">¿Tienes vehículos que quieres vender? Publica tu anuncio y llega a miles de compradores.</p>
                    <span class="badge bg-danger text-white mt-2">
                        <i class="fas fa-clock me-1"></i> Próximamente
                    </span>
                </div>
            </div>

            <!-- Alertas -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="fas fa-bell fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold">🔔 Alertas</h5>
                    <p class="text-muted small">Recibe notificaciones cuando haya vehículos que coincidan con tus intereses.</p>
                </div>
            </div>

            <!-- Historial -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px;">
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="fas fa-history fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold">📊 Historial</h5>
                    <p class="text-muted small">Revisa los vehículos que has visitado y encuentra lo que buscas fácilmente.</p>
                </div>
            </div>

            <!-- LOGO Y CONTACTO DIRECTO -->
            <div class="col-12">
                <div class="row g-3 justify-content-center">
                    
                    <!-- LOGO -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm hover-card text-center p-3" style="border-radius: 14px; background: linear-gradient(135deg, #0a0a1a, #1a1a3e);">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="background: rgba(255,255,255,0.1); padding: 10px 18px; border-radius: 12px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                                    <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" 
                                         alt="TransVentas Guatemala" 
                                         style="max-height: 70px; width: auto; display: block; filter: brightness(0) invert(1);">
                                </div>
                            </div>
                            <div class="mt-2">
                                <h5 style="font-weight: 700; font-size: 1.2rem; color: #ffffff; letter-spacing: 0.5px; text-shadow: 0 2px 10px rgba(0,0,0,0.3); margin-bottom: 0;">
                                    Transventas</span>
                                    <span style="color: #64b5f6;">Guatemala</span>
                                </h5>
                            </div>
                            <p class="text-white-50 small mt-1" style="font-size: 0.75rem;">Tu pagina de confianza</p>
                            <div>
                                <span class="badge bg-primary" style="font-size: 0.65rem;">🇬🇹 Hecho en Guatemala</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto Directo -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm hover-card text-center p-3" style="border-radius: 14px; border: 2px solid #28a745; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-2" 
                                 style="width: 55px; height: 55px;">
                                <i class="fas fa-envelope fa-1x text-success"></i>
                            </div>
                            <h6 class="fw-bold text-success" style="font-size: 0.95rem;">📧 Contacto Directo</h6>
                            <p class="text-muted small mb-1" style="font-size: 0.75rem;">Envía mensajes directamente a los vendedores</p>
                            <div>
                                <span class="badge bg-success" style="font-size: 0.65rem;">
                                    <i class="fas fa-check-circle me-1"></i> Disponible
                                </span>
                            </div>
                            <div class="mt-2 p-2 bg-light rounded-3">
                                @auth
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fas fa-check-circle text-success me-1"></i> 
                                        <span class="fw-bold">¡Ya estás registrado!</span>
                                    </small>
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-success btn-sm mt-1 w-100" style="font-size: 0.75rem; padding: 4px 8px;">
                                        <i class="fas fa-search"></i> Explorar
                                    </a>
                                @else
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fas fa-info-circle text-primary me-1"></i> 
                                        <span class="fw-bold">Regístrate gratis</span>
                                    </small>
                                    <div class="d-flex gap-2 mt-1">
                                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm flex-grow-1" style="font-size: 0.7rem; padding: 4px 8px;">
                                            <i class="fas fa-user-plus"></i> Registrarse
                                        </a>
                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm flex-grow-1" style="font-size: 0.7rem; padding: 4px 8px;">
                                            <i class="fas fa-sign-in-alt"></i> Login
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- LLAMADA A LA ACCIÓN -->
            <div class="col-12 mt-4">
                <div class="text-center p-4 rounded-4" 
                     style="background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 50%, #0d1b2a 100%);">
                    <h3 class="text-white mb-3">
                        <i class="fas fa-rocket text-primary"></i>
                        ¡Únete a TransVentas <span style="color: #64b5f6;">Guatemala</span> hoy!
                    </h3>
                    <p class="text-white mb-3">Crea tu cuenta gratuita y disfruta de todos estos beneficios</p>
                    @auth
                        <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg px-5 rounded-pill">
                            <i class="fas fa-search"></i> Explorar Vehículos
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 rounded-pill">
                            <i class="fas fa-user-plus"></i> Registrarse Gratis
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill ms-2">
                            <i class="fas fa-sign-in-alt"></i> Ya tengo cuenta
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
document.getElementById('filterForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const params = new URLSearchParams(formData);
    
    document.getElementById('vehicleGrid').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando vehículos...</p>
        </div>
    `;
    
    fetch(`/filtrar?${params.toString()}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('vehicleGrid').innerHTML = html;
        history.pushState(null, '', `?${params.toString()}`);
        
        setTimeout(function() {
            const target = document.getElementById('todos-los-vehiculos');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 200);
    })
    .catch(error => {
        document.getElementById('vehicleGrid').innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Error al cargar los filtros. Intenta de nuevo.
            </div>
        `;
    });
});
</script>
@endpush

<style>
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
    .img-container {
        width: 100%;
        height: 220px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        padding: 10px;
    }
    .img-container img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        object-position: center;
        background: #ffffff;
    }
    .hero-section {
        position: relative;
        overflow: hidden;
    }
    .category-banner {
        position: relative;
        overflow: hidden;
    }
    @media (max-width: 768px) {
        .hero-section {
            min-height: 50vh !important;
        }
        .hero-section h1 {
            font-size: 2rem !important;
        }
        .category-banner h2 {
            font-size: 1.5rem !important;
        }
        .category-banner span {
            font-size: 2rem !important;
        }
    }
</style>

@endsection