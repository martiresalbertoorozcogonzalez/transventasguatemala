@extends('admin.layouts.admin')

@section('title', 'Detalle del Mensaje')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Mensaje original -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-envelope"></i> Mensaje de {{ $contact->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>📧 Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                        <p><strong>📱 Teléfono:</strong> {{ $contact->phone ?? 'No especificado' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>🚗 Vehículo:</strong> 
                            <a href="{{ route('vehicles.show', $contact->vehicle->slug) }}" target="_blank">
                                {{ $contact->vehicle->title }}
                            </a>
                        </p>
                        <p><strong>📅 Fecha:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>📌 Estado:</strong> 
                            @if($contact->status == 'pendiente')
                                <span class="badge bg-danger">Pendiente</span>
                            @elseif($contact->status == 'leido')
                                <span class="badge bg-warning">Leído</span>
                            @else
                                <span class="badge bg-success">Respondido</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <hr>
                
                <h6><i class="fas fa-comment"></i> Mensaje:</h6>
                <div class="p-3 bg-light rounded-3">
                    <p class="mb-0">{{ $contact->message }}</p>
                </div>
                
                @if($contact->status == 'pendiente')
                    <div class="mt-3">
                        <form action="{{ route('admin.contacts.responded', $contact) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Marcar como Respondido
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Respuestas -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-reply"></i> Historial de Respuestas ({{ $responses->count() }})</h5>
            </div>
            <div class="card-body">
                @if($responses->count() > 0)
                    @foreach($responses as $response)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>
                                    <i class="fas fa-user-circle"></i> {{ $response->user->name }}
                                    <span class="badge bg-primary">Admin</span>
                                </strong>
                                <small class="text-muted">{{ $response->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-0 mt-2">{{ $response->message }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay respuestas aún</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Responder -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-reply"></i> Responder Mensaje</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contacts.send-response', $contact) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Tu respuesta</label>
                        <textarea name="message" class="form-control" rows="6" 
                                  placeholder="Escribe tu respuesta aquí..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-paper-plane"></i> Enviar Respuesta
                    </button>
                </form>
                
                <hr>
                
                <div class="alert alert-info small">
                    <i class="fas fa-info-circle"></i>
                    <strong>Nota:</strong> La respuesta se enviará por correo electrónico al usuario y quedará guardada en el historial.
                </div>
            </div>
        </div>
        
        <!-- Acciones rápidas -->
        <div class="card mt-3">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-tools"></i> Acciones</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="fas fa-arrow-left"></i> Volver a la lista
                </a>
                
                <a href="{{ route('vehicles.show', $contact->vehicle->slug) }}" target="_blank" class="btn btn-info w-100 mb-2">
                    <i class="fas fa-eye"></i> Ver vehículo
                </a>
                
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('¿Eliminar este mensaje?')">
                        <i class="fas fa-trash"></i> Eliminar mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection