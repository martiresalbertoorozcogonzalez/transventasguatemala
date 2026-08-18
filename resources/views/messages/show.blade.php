@extends('layouts.app')

@section('title', 'Conversación - ' . $contact->vehicle->title)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-comments text-primary"></i> Conversación
            </h2>
            <p class="text-muted">
                <i class="fas fa-truck me-1"></i> 
                <a href="{{ route('vehicles.show', $vehicle->slug) }}" target="_blank" class="text-decoration-none">
                    {{ $vehicle->title }}
                </a>
            </p>
        </div>
        <div>
            <span class="badge {{ $contact->status == 'respondido' ? 'bg-success' : ($contact->status == 'leido' ? 'bg-warning' : 'bg-danger') }} fs-6 me-2">
                {{ $contact->status == 'pendiente' ? '⏳ Pendiente' : ($contact->status == 'leido' ? '📖 Leído' : '✅ Respondido') }}
            </span>
            <a href="{{ route('user.messages.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-comments me-2"></i> 
                            <strong>Conversación con el vendedor</strong>
                        </span>
                        <small>
                            <i class="fas fa-calendar me-1"></i> 
                            {{ $contact->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
                
                <div class="card-body" style="max-height: 500px; overflow-y: auto;" id="chatMessages">
                    @if(count($conversation) > 0)
                        @foreach($conversation as $msg)
                            <div class="d-flex {{ $msg['type'] == 'user' ? 'justify-content-start' : 'justify-content-end' }} mb-3">
                                <div class="p-3 rounded-3 {{ $msg['type'] == 'user' ? 'bg-light' : 'bg-primary text-white' }}" 
                                     style="max-width: 80%; {{ $msg['type'] == 'user' ? 'border: 1px solid #e9ecef;' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="{{ $msg['type'] == 'user' ? 'text-muted' : 'text-white-50' }}">
                                            <i class="fas {{ $msg['type'] == 'user' ? 'fa-user' : 'fa-user-tie' }} me-1"></i>
                                            {{ $msg['name'] }}
                                            @if($msg['is_original'] ?? false)
                                                <span class="badge bg-secondary ms-1">Original</span>
                                            @endif
                                            @if($msg['type'] == 'admin')
                                                <span class="badge bg-info ms-1">Admin</span>
                                            @endif
                                        </small>
                                        <small class="{{ $msg['type'] == 'user' ? 'text-muted' : 'text-white-50' }} ms-2">
                                            {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
                                        </small>
                                    </div>
                                    <p class="mb-0 {{ $msg['type'] == 'user' ? 'text-dark' : 'text-white' }}" style="word-break: break-word;">
                                        {{ $msg['message'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-comment fa-3x mb-3"></i>
                            <p>No hay mensajes en esta conversación</p>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer bg-light">
                    <form id="chatForm" class="d-flex gap-2">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                        <input type="text" 
                               name="message" 
                               id="chatInput" 
                               class="form-control" 
                               placeholder="Escribe tu mensaje aquí..." 
                               required
                               autocomplete="off">
                        <button type="submit" class="btn btn-primary" id="chatSendBtn">
                            <i class="fas fa-paper-plane"></i> Enviar
                        </button>
                    </form>
                    <small class="text-muted" id="chatInfo">
                        <i class="fas fa-info-circle me-1"></i>
                        @if($contact->status == 'respondido')
                            El admin ya respondió. Puedes enviar un nuevo mensaje.
                        @elseif($contact->status == 'pendiente')
                            Mensaje enviado, esperando respuesta del admin.
                        @else
                            Conversación en curso.
                        @endif
                    </small>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        @if($vehicle->images && count($vehicle->images) > 0)
                            <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                 alt="{{ $vehicle->title }}" 
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; border-radius: 8px;">
                                <i class="fas fa-truck fa-2x text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $vehicle->title }}</h6>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-building me-1"></i> {{ $vehicle->brand }}
                                <i class="fas fa-calendar ms-2 me-1"></i> {{ $vehicle->year }}
                            </p>
                            <a href="{{ route('vehicles.show', $vehicle->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                <i class="fas fa-eye"></i> Ver vehículo
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
document.getElementById('chatForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    const sendBtn = document.getElementById('chatSendBtn');
    const contactId = this.querySelector('input[name="contact_id"]').value;
    
    if (!message) return;
    
    sendBtn.disabled = true;
    sendBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    const formData = new FormData(this);
    
    fetch(`/mis-mensajes/${contactId}/enviar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            location.reload();
        } else {
            alert('❌ ' + (data.message || 'Error al enviar el mensaje'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al enviar el mensaje');
    })
    .finally(() => {
        sendBtn.disabled = false;
        sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar';
    });
});

const chatMessages = document.getElementById('chatMessages');
if (chatMessages) {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
</script>
@endpush
@endsection