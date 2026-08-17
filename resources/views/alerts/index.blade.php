@extends('layouts.app')

@section('title', 'Mis Alertas')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-bell text-warning"></i> Mis Alertas
        </h2>
        <a href="{{ route('alerts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear Alerta
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            @if(session('matching_count') > 0)
                <br>
                <small>Hay <strong>{{ session('matching_count') }}</strong> vehículos que coinciden con tu alerta.</small>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($alerts->count() > 0)
        <div class="row">
            @foreach($alerts as $alert)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-card" 
                     style="border-radius: 16px; overflow: hidden; transition: all 0.3s; {{ $alert->is_active ? 'border-left: 4px solid #28a745;' : 'opacity: 0.7;' }}">
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title fw-bold mb-2">{{ $alert->name }}</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-alert" 
                                       type="checkbox" 
                                       data-id="{{ $alert->id }}"
                                       {{ $alert->is_active ? 'checked' : '' }}
                                       style="width: 2.5rem; height: 1.2rem;">
                            </div>
                        </div>
                        
                        <p class="text-muted small mb-2">
                            <i class="fas fa-clock me-1"></i> 
                            Frecuencia: {{ $alert->frequency_label }}
                        </p>
                        
                        <div class="bg-light p-2 rounded-3 mb-2">
                            <small class="text-muted d-block">
                                <i class="fas fa-filter me-1"></i> Criterios:
                            </small>
                            <small class="text-dark">{{ $alert->criteria_description }}</small>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge {{ $alert->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $alert->is_active ? 'Activa' : 'Inactiva' }}
                            </span>
                            @if($alert->last_sent_at)
                                <small class="text-muted">
                                    Última notificación: {{ $alert->last_sent_at->diffForHumans() }}
                                </small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex gap-2">
                            <a href="{{ route('alerts.edit', $alert) }}" class="btn btn-warning btn-sm flex-grow-1">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('alerts.destroy', $alert) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100" 
                                        onclick="return confirm('¿Eliminar esta alerta?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-bell fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
            <h4>No tienes alertas creadas</h4>
            <p class="text-muted">Crea una alerta y te notificaremos cuando aparezcan vehículos que coincidan con tus intereses.</p>
            <a href="{{ route('alerts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear mi primera alerta
            </a>
        </div>
    @endif
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        cursor: default;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
    }
    .border-left {
        border-left: 4px solid #28a745 !important;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle alert status
    document.querySelectorAll('.toggle-alert').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            const isChecked = this.checked;
            
            fetch(`/alerts/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recargar la página para actualizar el estado
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revertir el toggle
                this.checked = !isChecked;
                alert('Error al cambiar el estado de la alerta');
            });
        });
    });
});
</script>
@endpush

@endsection