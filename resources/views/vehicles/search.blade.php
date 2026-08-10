@extends('layouts.app')

@section('title', 'Resultados para: ' . request('q'))

@section('content')

<!-- ============================================ -->
<!-- RESULTADOS DE BÚSQUEDA (SOLO BÚSQUEDA) -->
<!-- ============================================ -->
<section id="resultados" style="padding: 40px 0; background: #f8f9fa; min-height: 70vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">
                    <i class="fas fa-search text-primary"></i> 
                    Resultados para: <strong>"{{ request('q') }}"</strong>
                </h2>
                <p class="text-muted small mt-1">{{ $vehicles->total() }} vehículo(s) encontrado(s)</p>
            </div>
            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Nueva búsqueda
            </a>
        </div>
        
        @if($vehicles->count() > 0)
            <div class="row">
                @foreach($vehicles as $vehicle)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-card" 
                         style="border-radius: 20px; overflow: hidden; transition: all 0.4s; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        
                        <div class="position-relative overflow-hidden">
                            <a href="/vehiculos/{{ $vehicle->slug }}">
                                <div class="img-container">
                                    @if($vehicle->images && count($vehicle->images) > 0)
                                        <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                             class="img-full" alt="{{ $vehicle->title }}"
                                             style="transition: transform 0.5s;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px; width: 100%;">
                                            <i class="fas fa-truck fa-3x text-muted"></i>
                                        </div>
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

<style>
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
        transition: transform 0.5s;
    }
    
    .hover-card:hover .img-container img {
        transform: scale(1.05);
    }
</style>

@endsection