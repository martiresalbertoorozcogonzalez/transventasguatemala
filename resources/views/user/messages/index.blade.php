@extends('layouts.app')

@section('title', 'Mis Mensajes')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-envelope text-primary"></i> Mis Mensajes
            </h2>
            <p class="text-muted small">Conversaciones con los vendedores</p>
        </div>
        @if($unreadCount > 0)
            <span class="badge bg-danger fs-6 p-2">
                <i class="fas fa-circle"></i> {{ $unreadCount }} nuevo(s)
            </span>
        @endif
    </div>

    @if($messages->count() > 0)
        <div class="row">
            @foreach($messages as $message)
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ route('user.messages.show', $message) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card" 
                         style="border-radius: 16px; overflow: hidden; transition: all 0.3s; border-left: 4px solid {{ $message->status == 'pendiente' ? '#dc3545' : ($message->status == 'leido' ? '#ffc107' : '#28a745') }};">
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="card-title fw-bold mb-1 text-dark">
                                    {{ Str::limit($message->vehicle->title, 35) }}
                                </h6>
                                <span class="badge {{ $message->status == 'respondido' ? 'bg-success' : ($message->status == 'leido' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $message->status == 'pendiente' ? 'Pendiente' : ($message->status == 'leido' ? 'Leído' : 'Respondido') }}
                                </span>
                            </div>
                            
                            <p class="text-muted small mb-2">
                                <i class="fas fa-calendar me-1"></i> {{ $message->created_at->format('d/m/Y H:i') }}
                            </p>
                            
                            <div class="bg-light p-2 rounded-3 mb-2">
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-comment me-1"></i>
                                    {{ Str::limit($message->message, 60) }}
                                </p>
                            </div>
                            
                            @if($message->hasResponses())
                                <div class="d-flex align-items-center text-success">
                                    <i class="fas fa-reply me-1"></i>
                                    <small>{{ $message->responses->count() }} respuesta(s)</small>
                                    <small class="text-muted ms-2">
                                        ({{ $message->last_response->created_at->diffForHumans() }})
                                    </small>
                                </div>
                            @else
                                <div class="text-muted small">
                                    <i class="fas fa-clock me-1"></i> Esperando respuesta...
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-footer bg-transparent border-0">
                            <span class="btn btn-primary btn-sm w-100">
                                Ver Conversación <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $messages->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-envelope fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
            <h4>No tienes mensajes</h4>
            <p class="text-muted">Cuando contactes a un vendedor, tus mensajes aparecerán aquí.</p>
            <a href="{{ route('vehicles.index') }}" class="btn btn-primary">
                <i class="fas fa-search"></i> Explorar Vehículos
            </a>
        </div>
    @endif
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection