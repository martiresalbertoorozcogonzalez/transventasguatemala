{{-- resources/views/components/vehicle-grid.blade.php --}}
{{-- VERSIÓN COMPLETA Y FUNCIONAL CON IMÁGENES Y ENLACES --}}

@if($vehicles->count() > 0)
    <div class="row">
        @foreach($vehicles as $vehicle)
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100 shadow-sm vehicle-card">
                <div class="position-relative">

                    {{-- ✅ IMAGEN CON ENLACE AL DETALLE --}}
                    
                    <a href="/vehiculos/{{ $vehicle->slug }}">

                        <div class="img-container">
                            @if($vehicle->images && count($vehicle->images) > 0)
                                <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                    alt="{{ $vehicle->title }}"
                                    class="img-full">
                            @else
                                <i class="fas fa-truck fa-3x text-muted"></i>
                            @endif
                        </div>
                    
                    </a>
                    
                    {{-- BADGES --}}
                    <span class="position-absolute bottom-0 start-0 badge bg-{{ $vehicle->status_badge }} m-2 p-2">
                        {{ ucfirst($vehicle->status) }}
                    </span>
                    @if($vehicle->featured)
                        <span class="position-absolute top-0 end-0 badge bg-warning m-2">
                            <i class="fas fa-star"></i> Destacado
                        </span>
                    @endif
                </div>
                
                <div class="card-body">
                    {{-- TÍTULO CON ENLACE --}}
                    <h6 class="card-title">
                        <a href="{{ route('vehicles.show', $vehicle) }}" 
                           class="text-decoration-none text-dark">
                            {{ Str::limit($vehicle->title, 40) }}
                        </a>
                    </h6>
                    
                    {{-- INFORMACIÓN BÁSICA --}}
                    <p class="text-muted small mb-1">
                        <i class="fas fa-building"></i> {{ $vehicle->brand }}
                        <i class="fas fa-calendar ms-2"></i> {{ $vehicle->year }}
                    </p>
                    
                    {{-- PRECIO --}}
                    <p class="text-primary fw-bold fs-5 mb-2">{{ $vehicle->price_formatted }}</p>
                    
                    {{-- DETALLES ADICIONALES --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-info">{{ ucfirst($vehicle->type) }}</span>
                        <span class="text-muted small">
                            <i class="fas fa-road"></i> {{ $vehicle->mileage ? number_format($vehicle->mileage) . ' km' : 'N/A' }}
                        </span>
                    </div>
                    
                    <hr class="my-2">
                    
                    {{-- BOTÓN DE DETALLE --}}
                    <a href="/vehiculos/{{ $vehicle->slug }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-eye"></i> Ver Detalles
                    </a>
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
        <a href="/vehiculos" class="btn btn-primary">
            <i class="fas fa-undo"></i> Ver todos los vehículos
        </a>
    </div>
@endif

<style>
.vehicle-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}
.vehicle-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
.vehicle-card .card-img-top {
    transition: transform 0.3s ease;
}
.vehicle-card:hover .card-img-top {
    transform: scale(1.03);
}
.vehicle-card .card-title a:hover {
    color: #0d6efd !important;
}
</style>