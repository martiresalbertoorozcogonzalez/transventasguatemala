@extends('layouts.app')

@section('title', 'Crear Alerta')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-primary text-white" style="border-radius: 16px 16px 0 0;">
                    <h4 class="mb-0"><i class="fas fa-bell"></i> Crear Nueva Alerta</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        <i class="fas fa-info-circle"></i> 
                        Recibirás notificaciones cuando aparezcan vehículos que coincidan con tus criterios.
                    </p>

                    <form action="{{ route('alerts.store') }}" method="POST">
                        @csrf

                        <!-- Nombre de la alerta -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">
                                Nombre de la Alerta <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Ej: Camiones Mercedes"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Un nombre descriptivo para identificar tu alerta</small>
                        </div>

                        <hr>

                        <!-- Criterios de búsqueda -->
                        <h6 class="fw-bold mb-3"><i class="fas fa-filter"></i> Criterios de búsqueda</h6>

                        <div class="row">
                            <!-- Tipo -->
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Tipo de Vehículo</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Marca -->
                            <div class="col-md-6 mb-3">
                                <label for="brand" class="form-label">Marca</label>
                                <select name="brand" id="brand" class="form-select">
                                    <option value="">Todas</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand }}" {{ old('brand') == $brand ? 'selected' : '' }}>
                                            {{ $brand }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Precio mínimo -->
                            <div class="col-md-6 mb-3">
                                <label for="min_price" class="form-label">Precio Mínimo (Q)</label>
                                <input type="number" 
                                       name="min_price" 
                                       id="min_price"
                                       class="form-control @error('min_price') is-invalid @enderror" 
                                       value="{{ old('min_price') }}"
                                       step="1000"
                                       placeholder="Ej: 50000">
                                @error('min_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Precio máximo -->
                            <div class="col-md-6 mb-3">
                                <label for="max_price" class="form-label">Precio Máximo (Q)</label>
                                <input type="number" 
                                       name="max_price" 
                                       id="max_price"
                                       class="form-control @error('max_price') is-invalid @enderror" 
                                       value="{{ old('max_price') }}"
                                       step="1000"
                                       placeholder="Ej: 200000">
                                @error('max_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Año desde -->
                            <div class="col-md-6 mb-3">
                                <label for="year_from" class="form-label">Año Desde</label>
                                <input type="number" 
                                       name="year_from" 
                                       id="year_from"
                                       class="form-control @error('year_from') is-invalid @enderror" 
                                       value="{{ old('year_from') }}"
                                       placeholder="Ej: 2020">
                                @error('year_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Año hasta -->
                            <div class="col-md-6 mb-3">
                                <label for="year_to" class="form-label">Año Hasta</label>
                                <input type="number" 
                                       name="year_to" 
                                       id="year_to"
                                       class="form-control @error('year_to') is-invalid @enderror" 
                                       value="{{ old('year_to') }}"
                                       placeholder="Ej: 2023">
                                @error('year_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Palabra clave -->
                            <div class="col-md-12 mb-3">
                                <label for="keyword" class="form-label">Palabra Clave</label>
                                <input type="text" 
                                       name="keyword" 
                                       id="keyword"
                                       class="form-control @error('keyword') is-invalid @enderror" 
                                       value="{{ old('keyword') }}" 
                                       placeholder="Ej: Actros, Freightliner">
                                @error('keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Buscará esta palabra en el título, marca, modelo y descripción</small>
                            </div>
                        </div>

                        <hr>

                        <!-- Frecuencia -->
                        <div class="mb-3">
                            <label for="frequency" class="form-label fw-bold">
                                Frecuencia de Notificación
                            </label>
                            <select name="frequency" id="frequency" class="form-select">
                                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Diaria</option>
                                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Semanal</option>
                            </select>
                            <small class="text-muted">¿Con qué frecuencia quieres recibir notificaciones?</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>¿Cómo funciona?</strong> Recibirás un correo electrónico con los vehículos que coincidan con tus criterios.
                        </div>

                        <!-- Botones -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fas fa-save"></i> Crear Alerta
                            </button>
                            <a href="{{ route('alerts.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection