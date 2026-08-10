{{-- resources/views/components/vehicle-grid.blade.php --}}
{{-- VERSIÓN CON FONDO BLANCO E IMAGEN MÁS GRANDE --}}

@if($vehicles->count() > 0)
    <div class="row">
        @foreach($vehicles as $vehicle)
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card" 
                 style="border-radius: 20px; overflow: hidden; transition: all 0.4s; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                
                <div class="position-relative overflow-hidden">
                    <a href="/vehiculos/{{ $vehicle->slug }}">
                        <div style="width: 100%; height: 240px; background: #ffffff; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; padding: 5px;">
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
@else
    <div class="text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-3"></i>
        <h4>No se encontraron vehículos</h4>
        <p class="text-muted">Prueba con otros filtros o términos de búsqueda</p>
        <a href="{{ route('vehicles.index') }}" class="btn btn-primary">
            <i class="fas fa-undo"></i> Ver todos los vehículos
        </a>
    </div>
@endif

<style>
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
</style>