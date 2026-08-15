@extends('layouts.app')

@section('title', 'Mis Favoritos')

@section('content')
<div class="container py-4">
    
    <!-- ============================================ -->
    <!-- ENCABEZADO -->
    <!-- ============================================ -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-heart text-danger"></i> Mis Vehículos Favoritos
        </h2>
        <span class="text-muted">{{ $favorites->count() }} vehículo(s) en favoritos</span>
    </div>
    
    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-card" 
                     style="border-radius: 20px; overflow: hidden; transition: all 0.4s; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    
                    <div class="position-relative overflow-hidden">
                        <a href="/vehiculos/{{ $favorite->vehicle->slug }}">
                            <div style="width: 100%; height: 220px; background: #ffffff; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; padding: 10px;">
                                @if($favorite->vehicle->images && count($favorite->vehicle->images) > 0)
                                    <img src="{{ asset('storage/vehicles/' . $favorite->vehicle->images[0]) }}" 
                                         alt="{{ $favorite->vehicle->title }}"
                                         style="max-height: 100%; max-width: 100%; object-fit: contain; object-position: center; background: #ffffff;">
                                @else
                                    <i class="fas fa-truck fa-3x text-muted" style="color: #6c757d;"></i>
                                @endif
                            </div>
                        </a>
                        
                        <!-- Badge de estado -->
                        <span class="position-absolute bottom-0 start-0 badge bg-{{ $favorite->vehicle->status_badge }} m-2 p-2 rounded-pill px-3 py-2">
                            {{ ucfirst($favorite->vehicle->status) }}
                        </span>
                        @if($favorite->vehicle->featured)
                            <span class="position-absolute top-0 end-0 badge bg-warning m-2 rounded-pill px-3 py-2">
                                <i class="fas fa-star me-1"></i> Destacado
                            </span>
                        @endif
                        
                        <!-- ❤️ Botón eliminar de favoritos -->
                        <form action="{{ route('favorites.toggle', $favorite->vehicle) }}" method="POST" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            @csrf
                            <button type="submit" class="btn btn-sm rounded-circle shadow-sm favorite-btn"
                                    style="width: 36px; height: 36px; padding: 0; border: none; background: white;"
                                    title="Eliminar de favoritos">
                                <i class="fas fa-heart text-danger"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="card-body">
                        <a href="/vehiculos/{{ $favorite->vehicle->slug }}" class="text-decoration-none text-dark">
                            <h5 class="card-title fw-bold mb-2">{{ Str::limit($favorite->vehicle->title, 40) }}</h5>
                        </a>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-building me-1"></i> {{ $favorite->vehicle->brand }}
                            <i class="fas fa-calendar ms-2 me-1"></i> {{ $favorite->vehicle->year }}
                        </p>
                        <p class="text-primary fw-bold fs-4 mb-3">{{ $favorite->vehicle->price_formatted }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                {{ ucfirst($favorite->vehicle->type) }}
                            </span>
                            <a href="/vehiculos/{{ $favorite->vehicle->slug }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                Ver Detalles <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- ============================================ -->
        <!-- VACÍO -->
        <!-- ============================================ -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-heart fa-5x text-muted" style="opacity: 0.3;"></i>
            </div>
            <h4 class="fw-bold">No tienes vehículos favoritos</h4>
            <p class="text-muted">Explora y agrega tus vehículos favoritos ❤️</p>
            <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg px-5 rounded-pill">
                <i class="fas fa-search"></i> Ver Vehículos
            </a>
        </div>
    @endif
</div>

<style>
    /* ============================================ */
    /* ESTILOS IGUALES AL INDEX */
    /* ============================================ */
    
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: pointer;
    }
    
    .hover-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
    
    .hover-card .card-title {
        transition: color 0.3s ease;
    }
    
    .hover-card:hover .card-title {
        color: #0d6efd !important;
    }
    
    .favorite-btn {
        transition: all 0.3s ease;
    }
    
    .favorite-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
</style>

@endsection