@extends('admin.layouts.admin')

@section('title', 'Detalles del Vehículo')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-eye"></i> Detalles del Vehículo</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Galería de imágenes -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($vehicle->images && count($vehicle->images) > 0)
                            <!-- Imagen principal -->
                            <div class="mb-3">
                                <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                     alt="{{ $vehicle->title }}" 
                                     class="img-fluid rounded"
                                     style="max-height: 300px; width: 100%; object-fit: cover;"
                                     id="mainImage">
                            </div>
                            
                            <!-- Miniaturas -->
                            @if(count($vehicle->images) > 1)
                            <div class="row g-1">
                                @foreach($vehicle->images as $index => $image)
                                    <div class="col-3">
                                        <img src="{{ asset('storage/vehicles/' . $image) }}" 
                                             alt="Imagen {{ $index + 1 }}" 
                                             class="img-fluid rounded cursor-pointer"
                                             style="height: 60px; width: 100%; object-fit: cover; cursor: pointer;"
                                             onclick="changeImage('{{ asset('storage/vehicles/' . $image) }}')"
                                             onmouseover="this.style.border='2px solid #0d6efd'"
                                             onmouseout="this.style.border='none'">
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 300px; border-radius: 8px;">
                                <div class="text-center">
                                    <i class="fas fa-truck fa-5x text-muted"></i>
                                    <p class="text-muted mt-2">Sin imágenes</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Información del vehículo -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{ $vehicle->title }}</h3>
                        
                        <div class="mb-3">
                            <span class="badge bg-{{ $vehicle->status_badge }} fs-6 p-2">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                            @if($vehicle->featured)
                                <span class="badge bg-warning fs-6 p-2">
                                    <i class="fas fa-star"></i> Destacado
                                </span>
                            @endif
                        </div>
                        
                        <h4 class="text-primary mb-3">{{ $vehicle->price_formatted }}</h4>
                        
                        <hr>
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <small class="text-muted">Tipo</small>
                                <p><strong>{{ ucfirst($vehicle->type) }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Marca</small>
                                <p><strong>{{ $vehicle->brand }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Modelo</small>
                                <p><strong>{{ $vehicle->model }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Año</small>
                                <p><strong>{{ $vehicle->year }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Kilometraje</small>
                                <p><strong>{{ $vehicle->mileage ? number_format($vehicle->mileage) . ' km' : 'N/A' }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Color</small>
                                <p>
                                    <strong>
                                        @if($vehicle->color)
                                            <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $vehicle->color }}; border-radius: 50%; border: 1px solid #ddd; vertical-align: middle;"></span>
                                            {{ $vehicle->color }}
                                        @else
                                            N/A
                                        @endif
                                    </strong>
                                </p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Motor</small>
                                <p><strong>{{ $vehicle->engine ?? 'N/A' }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Transmisión</small>
                                <p><strong>{{ $vehicle->transmission ?? 'N/A' }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Combustible</small>
                                <p><strong>{{ $vehicle->fuel_type ?? 'N/A' }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Capacidad</small>
                                <p><strong>{{ $vehicle->capacity ? $vehicle->capacity . ' ton' : 'N/A' }}</strong></p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Descripción -->
                        <div class="mb-3">
                            <h6><i class="fas fa-file-alt"></i> Descripción</h6>
                            <p class="text-justify">{{ $vehicle->description }}</p>
                        </div>
                        
                        <!-- Características -->
                        @if($vehicle->features && count($vehicle->features) > 0)
                        <div class="mb-3">
                            <h6><i class="fas fa-list"></i> Características</h6>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($vehicle->features as $feature)
                                    <span class="badge bg-info p-2">
                                        <i class="fas fa-check-circle"></i> {{ $feature }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <hr>
                        
                        <!-- Botones de acción -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <a href="{{ route('admin.vehicles.show', $vehicle) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Cambiar imagen principal al hacer clic en miniatura
    function changeImage(imageUrl) {
        document.getElementById('mainImage').src = imageUrl;
    }
</script>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .cursor-pointer:hover {
        opacity: 0.8;
    }
    .text-justify {
        text-align: justify;
    }
</style>
@endpush
@endsection