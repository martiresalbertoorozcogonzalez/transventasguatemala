@extends('layouts.app')

@section('title', 'TransVentas Guatemala - Camiones, Furgones y Plataformas')

@section('meta_description', 'Encuentra los mejores camiones, furgones y plataformas en venta en Guatemala. Precios competitivos y amplia variedad de vehículos comerciales.')

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
    $hasResults = $hasFilters || $hasSearch;
@endphp

<!-- ============================================ -->
<!-- HERO SECTION -->
<!-- ============================================ -->
<div class="hero-section position-relative overflow-hidden" 
     style="background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 40%, #0d1b2a 100%); min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 40px 0;">

    <!-- EFECTOS DE FONDO -->
    <div class="position-absolute top-50 start-50 translate-middle" 
         style="width: 400px; height: 400px; background: radial-gradient(circle, rgba(13,110,253,0.08), transparent 70%); border-radius: 50%;">
    </div>

    <div class="container position-relative text-center" style="z-index: 2; max-width: 850px; margin: 0 auto;">
        
        <!-- LOGO -->
        <div class="d-flex justify-content-center mb-3">
            <div style="display: inline-block; background: #ffffff; border-radius: 50%; padding: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); width: 160px; height: 160px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" 
                     alt="TransVentas Guatemala" 
                     style="width: 110%; height: 110%; object-fit: cover; display: block; margin: -5%;">
            </div>
        </div>

        <!-- NOMBRE -->
        <h1 class="display-2 fw-bold text-white mb-2" 
            style="text-shadow: 0 0 60px rgba(13,110,253,0.2); letter-spacing: 2px; line-height: 1.2;">
            Transventas<span style="color: #64b5f6;">Guatemala</span>
        </h1>

        <p class="lead text-white-50 mb-3" style="font-size: 1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
            La pagina líder para comprar 
            <span class="text-white fw-semibold">camiones</span>, 
            <span class="text-white fw-semibold">furgones</span> y 
            <span class="text-white fw-semibold">plataformas</span>.
        </p>

        <!-- BÚSQUEDA -->
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
            <p class="text-white small mt-2 text-center" style="opacity: 0.6; font-size: 0.75rem;">
                <i class="fas fa-lightbulb me-1"></i> Ej: "Mercedes" · "Freightliner" · "2023"
            </p>
        </div>

        <!-- BOTONES DE REDES SOCIALES -->
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

<!-- ============================================ -->
<!-- INDICADOR DE FILTROS ACTIVOS -->
<!-- ============================================ -->
@if($hasFilters && !$hasSearch)
<section style="padding: 15px 0; background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="mb-0">
                    <i class="fas fa-filter text-primary"></i> 
                    Filtros aplicados
                </h5>
                <p class="text-muted small mb-0">{{ $vehicles->total() }} vehículo(s) encontrado(s)</p>
            </div>
            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-times"></i> Limpiar filtros
            </a>
        </div>
        <div class="mt-2 d-flex flex-wrap gap-2">
            @if(request('type'))
                <span class="badge bg-primary">Tipo: {{ ucfirst(request('type')) }}</span>
            @endif
            @if(request('brand'))
                <span class="badge bg-primary">Marca: {{ request('brand') }}</span>
            @endif
            @if(request('min_price'))
                <span class="badge bg-primary">Q{{ number_format(request('min_price')) }}</span>
            @endif
            @if(request('max_price'))
                <span class="badge bg-primary">Q{{ number_format(request('max_price')) }}</span>
            @endif
            @if(request('year_from'))
                <span class="badge bg-primary">Desde: {{ request('year_from') }}</span>
            @endif
            @if(request('year_to'))
                <span class="badge bg-primary">Hasta: {{ request('year_to') }}</span>
            @endif
        </div>
    </div>
</section>
@endif

<!-- ============================================ -->
<!-- RESULTADOS DE FILTROS -->
<!-- ============================================ -->
@if($hasFilters && !$hasSearch)
<section id="resultados-filtros" style="padding: 20px 0 40px 0; background: #f8f9fa; min-height: 50vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">
                    <i class="fas fa-filter text-primary"></i> 
                    Resultados con filtros aplicados
                </h4>
                <p class="text-muted small mt-1">{{ $vehicles->total() }} vehículo(s) encontrado(s)</p>
            </div>
            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Limpiar filtros
            </a>
        </div>
        
        <div class="mt-2 d-flex flex-wrap gap-2 mb-3">
            @if(request('type'))
                <span class="badge bg-primary">Tipo: {{ ucfirst(request('type')) }}</span>
            @endif
            @if(request('brand'))
                <span class="badge bg-primary">Marca: {{ request('brand') }}</span>
            @endif
            @if(request('min_price'))
                <span class="badge bg-primary">Q{{ number_format(request('min_price')) }}</span>
            @endif
            @if(request('max_price'))
                <span class="badge bg-primary">Q{{ number_format(request('max_price')) }}</span>
            @endif
            @if(request('year_from'))
                <span class="badge bg-primary">Desde: {{ request('year_from') }}</span>
            @endif
            @if(request('year_to'))
                <span class="badge bg-primary">Hasta: {{ request('year_to') }}</span>
            @endif
        </div>
        
        @if($vehicles->count() > 0)
            <div class="row">
                @foreach($vehicles as $vehicle)
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
                            <span class="position-absolute bottom-0 start-0 badge bg-{{ $vehicle->status_badge }} m-2 p-2 rounded-pill px-3 py-2">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                            @if($vehicle->featured)
                                <span class="position-absolute top-0 end-0 badge bg-warning m-2 rounded-pill px-3 py-2">
                                    <i class="fas fa-star me-1"></i> Destacado
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <a href="/vehiculos/{{ $vehicle->slug }}" class="text-decoration-none text-dark">
                                <h5 class="card-title fw-bold mb-2">{{ Str::limit($vehicle->title, 40) }}</h5>
                            </a>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-building me-1"></i> {{ $vehicle->brand }}
                                <i class="fas fa-calendar ms-2 me-1"></i> {{ $vehicle->year }}
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $vehicles->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-filter fa-4x text-muted mb-3"></i>
                <h4>No se encontraron vehículos con estos filtros</h4>
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
@if(!$hasResults)
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
<section id="todos-los-vehiculos" style="padding: 20px 0 40px 0; {{ $hasResults ? 'min-height: 50vh;' : '' }}">
    <div class="container">
        @if(!$hasResults)
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-truck"></i> Todos los Vehículos
            </h2>
            <span class="text-muted">{{ $vehicles->total() }} vehículos disponibles</span>
        </div>
        @endif

        <div class="row">
            <!-- FILTROS SIDEBAR -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-filter"></i> Filtros
                        </h5>
                        <hr>
                        
                        <form action="/filtrar#resultados-filtros" method="GET" id="filterForm">
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
                            
                            <a href="/vehiculos#todos-los-vehiculos" class="btn btn-outline-secondary w-100">
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

<!-- ============================================ -->
<!-- SECCIÓN DE BENEFICIOS - PÁGINA PRINCIPAL -->
<!-- ============================================ -->
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
                    <span class="badge bg-warning text-dark mt-2">
                        <i class="fas fa-clock me-1"></i> Próximamente
                    </span>
                </div>
            </div>

            <!-- Beneficio 3: Alertas -->
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

            <!-- Beneficio 4: Historial -->
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

            <!-- ============================================ -->
            <!-- LOGO Y CONTACTO DIRECTO CENTRADOS -->
            <!-- ============================================ -->
            <div class="col-12">
                <div class="row g-4 justify-content-center">
                    
                    <!-- ✅ LOGO CON NOMBRE (igual al Hero) -->
                    <div class="col-md-5">
                        <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px; background: linear-gradient(135deg, #0a0a1a, #1a1a3e);">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="background: rgba(255,255,255,0.1); padding: 15px 25px; border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                                    <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" 
                                         alt="TransVentas Guatemala" 
                                         style="max-height: 100px; width: auto; display: block; filter: brightness(0) invert(1);">
                                </div>
                            </div>
                            <div class="mt-3">
                                <h2 style="font-weight: 700; font-size: 2rem; color: #ffffff; letter-spacing: 1px; text-shadow: 0 2px 10px rgba(0,0,0,0.3); margin-bottom: 0;">
                                    Transventas
                                    <span style="color: #64b5f6;">Guatemala</span>
                                </h2>
                            </div>
                            <p class="text-white-50 small mt-2">Tu plataforma de confianza para comprar y vender vehículos comerciales en Guatemala.</p>
                            <div class="mt-2">
                                <span class="badge bg-primary">🇬🇹 Hecho en Guatemala</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto Directo -->
                    <div class="col-md-5">
                        <div class="card h-100 border-0 shadow-sm hover-card text-center p-4" style="border-radius: 16px; border: 2px solid #28a745; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-envelope fa-2x text-success"></i>
                            </div>
                            <h4 class="fw-bold text-success">📧 Contacto Directo</h4>
                            <p class="text-muted small">Envía mensajes directamente a los vendedores desde la página del vehículo.</p>
                            <div class="mt-2">
                                <span class="badge bg-success px-3 py-2" style="font-size: 0.9rem;">
                                    <i class="fas fa-check-circle me-1"></i> ¡Disponible ahora!
                                </span>
                            </div>
                            <hr class="my-3">
                            <div class="text-start">
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i> Contacta directamente al vendedor
                                </p>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i> Recibe respuesta rápida
                                </p>
                                
                            </div>
                            <div class="mt-3 p-3 bg-light rounded-3">
                                @auth
                                    <small class="text-muted">
                                        <i class="fas fa-check-circle text-success me-1"></i> 
                                        <span class="fw-bold">¡Ya estás registrado!</span> 
                                        Puedes contactar a los vendedores desde cualquier vehículo
                                    </small>
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-success btn-sm mt-2 w-100">
                                        <i class="fas fa-search"></i> Explorar Vehículos
                                    </a>
                                @else
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle text-primary me-1"></i> 
                                        <span class="fw-bold">¿Quieres contactar a los vendedores?</span> 
                                        Regístrate gratis y empieza a enviar mensajes
                                    </small>
                                    <div class="d-flex gap-2 mt-2">
                                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm flex-grow-1">
                                            <i class="fas fa-user-plus"></i> Registrarse
                                        </a>
                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
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
                        ¡Únete a TransVentas Guatemala hoy!
                    </h3>
                    <p class="text-white-50 mb-3">Crea tu cuenta gratuita y disfruta de todos estos beneficios</p>
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

<style>
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: default;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.1) !important;
    }
</style>

@push('scripts')
<script>
// ============================================
// FILTROS AJAX CON SCROLL
// ============================================

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
            const target = document.getElementById('resultados-filtros') || document.getElementById('todos-los-vehiculos');
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
    /* ============================================ */
    /* ESTILOS DE IMÁGENES CORREGIDOS */
    /* ============================================ */
    
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: pointer;
    }
    
    .img-container {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #1a1a3e, #0d1b2a);
        overflow: hidden;
        position: relative;
    }
    
    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s;
        display: block;
    }
    
    .hover-card:hover .img-container img {
        transform: scale(1.05);
    }
    
    .hero-section {
        position: relative;
        overflow: hidden;
    }
    
    /* RESPONSIVE */
    @media (max-width: 768px) {
        .hero-section {
            min-height: 50vh !important;
        }
        .hero-section h1 {
            font-size: 2rem !important;
        }
        .img-container {
            height: 150px;
        }
    }
</style>

@endsection