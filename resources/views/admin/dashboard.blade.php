@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            <h4><i class="fas fa-check-circle"></i> ¡Bienvenido al Panel de Administración!</h4>
            <p>Aquí puedes gestionar todos los vehículos de tu plataforma.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Vehículos</h5>
                <h2 class="mb-0">{{ \App\Models\Vehicle::count() }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Disponibles</h5>
                <h2 class="mb-0">{{ \App\Models\Vehicle::where('status', 'disponible')->count() }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Reservados</h5>
                <h2 class="mb-0">{{ \App\Models\Vehicle::where('status', 'reservado')->count() }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Vendidos</h5>
                <h2 class="mb-0">{{ \App\Models\Vehicle::where('status', 'vendido')->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-truck"></i> Últimos Vehículos Agregados</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach(\App\Models\Vehicle::latest()->limit(5)->get() as $vehicle)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $vehicle->title }}
                            <span class="badge bg-{{ $vehicle->status_badge }}">{{ ucfirst($vehicle->status) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-star"></i> Vehículos Destacados</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach(\App\Models\Vehicle::where('featured', true)->limit(5)->get() as $vehicle)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $vehicle->title }}
                            <span class="badge bg-warning">{{ $vehicle->price_formatted }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection