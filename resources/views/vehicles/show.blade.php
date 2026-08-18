@extends('layouts.app')

@section('title', $vehicle->title)

@section('meta_description', Str::limit(strip_tags($vehicle->description), 160))

@section('meta_image', $vehicle->images && count($vehicle->images) > 0 ? asset('storage/vehicles/' . $vehicle->images[0]) : '')

@section('content')
<div class="container py-4">
    
    <!-- ============================================ -->
    <!-- BREADCRUMB -->
    <!-- ============================================ -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/vehiculos" class="text-decoration-none">Vehículos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($vehicle->title, 40) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- ============================================ -->
        <!-- COLUMNA IZQUIERDA: GALERÍA DE IMÁGENES -->
        <!-- ============================================ -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-0">
                    @if($vehicle->images && count($vehicle->images) > 0)
                        <!-- Imagen principal -->
                        <div class="position-relative">
                            <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                 alt="{{ $vehicle->title }}" 
                                 class="img-fluid w-100"
                                 style="height: 450px; object-fit: contain; object-position: center; background: linear-gradient(135deg, #f8f9fa, #e9ecef);"
                                 id="mainImage">
                            
                            <div class="position-absolute top-0 start-0 p-3 d-flex gap-2 flex-wrap">
                                @if($vehicle->featured)
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                        <i class="fas fa-star me-1"></i> Destacado
                                    </span>
                                @endif
                            </div>
                            <div class="position-absolute top-0 end-0 p-3">
                                <span class="badge bg-{{ $vehicle->status_badge }} px-3 py-2 rounded-pill shadow-sm fs-6">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                            </div>
                            <div class="position-absolute bottom-0 end-0 p-3">
                                <span class="badge bg-dark bg-opacity-75 px-3 py-2 rounded-pill">
                                    <i class="fas fa-eye me-1"></i> {{ $vehicle->views }} vistas
                                </span>
                            </div>
                        </div>
                        
                        @if(count($vehicle->images) > 1)
                        <div class="p-3 bg-light">
                            <div class="row g-2">
                                @foreach($vehicle->images as $index => $image)
                                    <div class="col-3 col-md-2">
                                        <img src="{{ asset('storage/vehicles/' . $image) }}" 
                                             alt="Imagen {{ $index + 1 }}" 
                                             class="img-fluid rounded cursor-pointer"
                                             style="height: 70px; width: 100%; object-fit: contain; object-position: center; cursor: pointer; border: 2px solid {{ $index == 0 ? '#0d6efd' : 'transparent' }}; background: #ffffff; transition: all 0.3s;"
                                             onclick="changeImage('{{ asset('storage/vehicles/' . $image) }}', this)"
                                             onmouseover="this.style.borderColor='#0d6efd'"
                                             onmouseout="this.style.borderColor='{{ $index == 0 ? '#0d6efd' : 'transparent' }}'">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 450px; border-radius: 20px;">
                            <div class="text-center">
                                <i class="fas fa-truck fa-6x text-muted" style="opacity: 0.3;"></i>
                                <p class="text-muted mt-3">Sin imágenes disponibles</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Redes Sociales -->
            <div class="card border-0 shadow-sm mt-3" style="border-radius: 16px;">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span class="fw-bold text-muted"><i class="fas fa-share-alt me-2"></i>Síguenos en:</span>
                        <a href="https://www.facebook.com/TransVentasGuatemala" target="_blank" 
                           class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="fab fa-facebook-f me-1"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/TransVentasGuatemala" target="_blank" 
                           class="btn btn-outline-danger btn-sm rounded-pill px-3">
                            <i class="fab fa-instagram me-1"></i> Instagram
                        </a>
                        <a href="https://www.tiktok.com/@TransVentasGuatemala" target="_blank" 
                           class="btn btn-outline-dark btn-sm rounded-pill px-3">
                            <i class="fab fa-tiktok me-1"></i> TikTok
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- COLUMNA DERECHA: INFORMACIÓN + CHAT -->
        <!-- ============================================ -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px; border-radius: 20px; overflow: hidden;">
                <div class="card-body p-4">
                    <!-- Título -->
                    <h2 class="card-title fw-bold mb-2">{{ $vehicle->title }}</h2>
                    
                    <!-- Precio -->
                    <h3 class="text-primary fw-bold mb-3">{{ $vehicle->price_formatted }}</h3>
                    
                    <hr>
                    
                    <!-- Especificaciones -->
                    <div class="row g-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Tipo</small>
                            <strong>{{ ucfirst($vehicle->type) }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Marca</small>
                            <strong>{{ $vehicle->brand }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Modelo</small>
                            <strong>{{ $vehicle->model }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Año</small>
                            <strong>{{ $vehicle->year }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Kilometraje</small>
                            <strong>{{ $vehicle->mileage ? number_format($vehicle->mileage) . ' km' : 'N/A' }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Color</small>
                            <strong>
                                @if($vehicle->color)
                                    <span style="display: inline-block; width: 16px; height: 16px; background-color: {{ $vehicle->color }}; border-radius: 50%; border: 1px solid #ddd; vertical-align: middle;"></span>
                                    {{ $vehicle->color }}
                                @else
                                    N/A
                                @endif
                            </strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Motor</small>
                            <strong>{{ $vehicle->engine ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Transmisión</small>
                            <strong>{{ $vehicle->transmission ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Combustible</small>
                            <strong>{{ $vehicle->fuel_type ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Capacidad</small>
                            <strong>{{ $vehicle->capacity ? $vehicle->capacity . ' ton' : 'N/A' }}</strong>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Descripción -->
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="fas fa-file-alt me-2"></i>Descripción</h6>
                        <p class="text-muted small">{{ $vehicle->description }}</p>
                    </div>
                    
                    @if($vehicle->features && count($vehicle->features) > 0)
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="fas fa-list me-2"></i>Características</h6>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($vehicle->features as $feature)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> {{ $feature }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <hr>
                    
                    <!-- ============================================ -->
                    <!-- CHAT INTEGRADO CON SCROLL -->
                    <!-- ============================================ -->
                    <div class="mt-3">
                        @auth
                            <button class="btn btn-primary w-100 rounded-pill py-2 mb-3" id="toggleChatBtn" onclick="toggleChat()" style="background: linear-gradient(135deg, #0d6efd, #0dcaf0); border: none;">
                                <i class="fas fa-comments me-2"></i> 
                                <span id="chatBtnText">Ver Conversación</span>
                                <span class="badge bg-danger ms-2" id="chatBadge" style="display: none;">
                                    <span id="chatBadgeCount">0</span>
                                </span>
                            </button>
                            
                            <div id="chatContainer" style="display: none;">
                                <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                                    <div class="card-header bg-primary text-white py-2" style="border-radius: 0;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="fw-bold">
                                                <i class="fas fa-comments me-2"></i> Conversación
                                            </small>
                                            <small id="chatStatus" class="badge bg-light text-dark">Cargando...</small>
                                        </div>
                                    </div>
                                    <!-- ✅ CONTENEDOR CON SCROLL - Altura fija -->
                                    <div class="card-body p-3" id="chatMessages" style="height: 280px; overflow-y: auto; overflow-x: hidden; background: #f8f9fa; display: flex; flex-direction: column;">
                                        <div class="text-center text-muted py-3" id="chatLoading">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                            <p class="mb-0 mt-2 small">Cargando conversación...</p>
                                        </div>
                                        <div id="chatContent" style="display: none; flex: 1;"></div>
                                    </div>
                                    <div class="card-footer bg-white p-2">
                                        <form id="chatForm" class="d-flex gap-2">
                                            @csrf
                                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                            <input type="text" 
                                                   name="message" 
                                                   id="chatInput" 
                                                   class="form-control form-control-sm" 
                                                   placeholder="Escribe tu mensaje..." 
                                                   required
                                                   autocomplete="off"
                                                   style="border-radius: 20px;">
                                            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3" id="chatSendBtn">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                        <small class="text-muted d-block text-center mt-1" id="chatInfo" style="font-size: 0.65rem;"></small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card border-0 bg-light" style="border-radius: 16px;">
                                <div class="card-body text-center py-3">
                                    <i class="fas fa-lock text-muted mb-2"></i>
                                    <p class="text-muted small mb-0">
                                        <a href="{{ route('login') }}" class="text-primary fw-bold">Inicia sesión</a> 
                                        o <a href="{{ route('register') }}" class="text-primary fw-bold">regístrate</a> 
                                        para ver la conversación.
                                    </p>
                                </div>
                            </div>
                        @endauth
                    </div>
                    
                    <button class="btn btn-outline-secondary w-100 rounded-pill py-2 mt-2" onclick="window.print()" style="font-size: 0.9rem;">
                        <i class="fas fa-print me-2"></i> Imprimir Ficha
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($related->count() > 0)
    <div class="mt-5">
        <h4 class="mb-3 fw-bold">
            <i class="fas fa-truck me-2"></i>Vehículos Relacionados
        </h4>
        <div class="row g-3">
            @foreach($related as $rel)
            <div class="col-md-3 col-6">
                <a href="/vehiculos/{{ $rel->slug }}" class="text-decoration-none d-block">
                    <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius: 16px; overflow: hidden; transition: all 0.3s;">
                        <div style="width: 100%; height: 140px; background: #ffffff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 8px;">
                            @if($rel->images && count($rel->images) > 0)
                                <img src="{{ asset('storage/vehicles/' . $rel->images[0]) }}" 
                                     alt="{{ $rel->title }}"
                                     style="max-height: 100%; max-width: 100%; object-fit: contain; object-position: center; background: #ffffff;">
                            @else
                                <i class="fas fa-truck fa-2x text-muted"></i>
                            @endif
                        </div>
                        <div class="card-body p-2">
                            <h6 class="card-title text-dark fw-semibold mb-1" style="font-size: 0.8rem;">
                                {{ Str::limit($rel->title, 30) }}
                            </h6>
                            <p class="text-primary fw-bold mb-0" style="font-size: 0.85rem;">
                                {{ $rel->price_formatted }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function changeImage(url, element) {
    var mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = url;
    }
    
    document.querySelectorAll('.cursor-pointer').forEach(function(el) {
        el.style.borderColor = 'transparent';
        el.style.borderWidth = '2px';
    });
    
    if (element) {
        element.style.borderColor = '#0d6efd';
        element.style.borderWidth = '2px';
    }
}

// ============================================
// CHAT - VARIABLES
// ============================================
if (typeof chatVisible === 'undefined') {
    var chatVisible = false;
}
var vehicleId = {{ $vehicle->id }};
var chatInterval = null;

// ============================================
// CHAT - TOGGLE
// ============================================
function toggleChat() {
    chatVisible = !chatVisible;
    var container = document.getElementById('chatContainer');
    var btnText = document.getElementById('chatBtnText');
    
    if (chatVisible) {
        container.style.display = 'block';
        btnText.textContent = 'Ocultar Conversación';
        loadConversation();
        document.getElementById('chatBadge').style.display = 'none';
        
        if (chatInterval) {
            clearInterval(chatInterval);
        }
        chatInterval = setInterval(loadConversation, 10000);
    } else {
        container.style.display = 'none';
        btnText.textContent = 'Ver Conversación';
        if (chatInterval) {
            clearInterval(chatInterval);
            chatInterval = null;
        }
    }
}

// ============================================
// CHAT - CARGAR CONVERSACIÓN
// ============================================
function loadConversation() {
    var loading = document.getElementById('chatLoading');
    var content = document.getElementById('chatContent');
    var status = document.getElementById('chatStatus');
    var messagesContainer = document.getElementById('chatMessages');
    
    if (!loading || !content) return;
    
    loading.style.display = 'block';
    content.style.display = 'none';
    
    fetch(`/vehiculos/${vehicleId}/conversacion`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Error al cargar la conversación');
        }
        return response.json();
    })
    .then(function(data) {
        loading.style.display = 'none';
        
        if (data.success && data.has_conversation) {
            content.style.display = 'block';
            renderConversation(data.conversation);
            status.textContent = data.status === 'respondido' ? '✅ Respondido' : (data.status === 'leido' ? '📖 Leído' : '⏳ Pendiente');
            status.className = data.status === 'respondido' ? 'badge bg-success' : (data.status === 'leido' ? 'badge bg-warning' : 'badge bg-danger');
            document.getElementById('chatInfo').textContent = 'Iniciado: ' + data.created_at;
        } else {
            content.style.display = 'block';
            content.innerHTML = `
                <div class="text-center text-muted py-3">
                    <i class="fas fa-comment fa-2x mb-2"></i>
                    <p class="small mb-0">No hay conversación aún.<br>Envía tu primer mensaje.</p>
                </div>
            `;
            status.textContent = '📝 Nuevo';
            status.className = 'badge bg-secondary';
            document.getElementById('chatInfo').textContent = 'Escribe tu primer mensaje';
        }
        
        // ✅ SCROLL AL FINAL DESPUÉS DE CARGAR (con mayor retraso y validación)
        scrollToBottom(messagesContainer);
    })
    .catch(function(error) {
        loading.style.display = 'none';
        content.style.display = 'block';
        content.innerHTML = `
            <div class="alert alert-danger small mb-0">
                <i class="fas fa-exclamation-circle me-1"></i> Error al cargar la conversación
            </div>
        `;
        console.error('Error:', error);
    });
}

// ============================================
// CHAT - RENDERIZAR CONVERSACIÓN
// ============================================
function renderConversation(messages) {
    var container = document.getElementById('chatContent');
    var messagesContainer = document.getElementById('chatMessages');
    var html = '';
    
    if (!messages || messages.length === 0) {
        html = `
            <div class="text-center text-muted py-3">
                <p class="small mb-0">No hay mensajes en esta conversación</p>
            </div>
        `;
        container.innerHTML = html;
        // Aún así, forzamos scroll (aunque no haya mensajes, no hará nada)
        scrollToBottom(messagesContainer);
        return;
    }
    
    messages.forEach(function(msg) {
        var isUser = msg.type === 'user';
        
        html += `
            <div class="d-flex ${isUser ? 'justify-content-start' : 'justify-content-end'} mb-2">
                <div class="p-2 rounded-3 ${isUser ? 'bg-white' : 'bg-primary text-white'}" 
                     style="max-width: 80%; ${isUser ? 'border: 1px solid #e9ecef;' : ''}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="${isUser ? 'text-muted' : 'text-white-50'}" style="font-size: 0.55rem;">
                            <i class="fas ${isUser ? 'fa-user' : 'fa-user-tie'} me-1"></i>
                            ${isUser ? 'Tú' : 'Vendedor'}
                            ${msg.is_original ? ' <span class="badge bg-secondary" style="font-size: 0.45rem;">Original</span>' : ''}
                        </small>
                        <small class="${isUser ? 'text-muted' : 'text-white-50'}" style="font-size: 0.5rem;">
                            ${new Date(msg.created_at).toLocaleTimeString('es-GT', { hour: '2-digit', minute: '2-digit' })}
                        </small>
                    </div>
                    <p class="mb-0 ${isUser ? 'text-dark' : 'text-white'}" style="font-size: 0.8rem; word-break: break-word;">
                        ${msg.message}
                    </p>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // ✅ SCROLL AL FINAL después de renderizar
    scrollToBottom(messagesContainer);
}

// ============================================
// FUNCIÓN UNIFICADA PARA SCROLL AL FINAL
// ============================================
function scrollToBottom(container) {
    if (!container) return;
    // Usamos setTimeout para asegurar que el DOM se haya actualizado
    setTimeout(function() {
        container.scrollTop = container.scrollHeight;
        console.log('Scroll ejecutado, altura:', container.scrollHeight); // ← puedes eliminar este log después
    }, 150); // ← aumento el tiempo a 150ms para mayor seguridad
}

// ============================================
// CHAT - ENVIAR MENSAJE
// ============================================
document.getElementById('chatForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    var input = document.getElementById('chatInput');
    var message = input.value.trim();
    var sendBtn = document.getElementById('chatSendBtn');
    var messagesContainer = document.getElementById('chatMessages');
    
    if (!message) return;
    
    sendBtn.disabled = true;
    sendBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    var formData = new FormData(this);
    
    fetch(`/vehiculos/${vehicleId}/enviar-mensaje`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            input.value = '';
            loadConversation();
            showChatAlert('success', data.message);
            
            // ✅ SCROLL DESPUÉS DE ENVIAR (ya se hace dentro de loadConversation)
        } else {
            showChatAlert('danger', data.message || 'Error al enviar el mensaje');
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        showChatAlert('danger', 'Error al enviar el mensaje');
    })
    .finally(function() {
        sendBtn.disabled = false;
        sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
    });
});

function showChatAlert(type, message) {
    var container = document.getElementById('chatContainer');
    if (!container) return;
    
    var existingAlerts = container.querySelectorAll('.alert');
    existingAlerts.forEach(function(el) {
        el.remove();
    });
    
    var alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-' + type + ' alert-dismissible fade show py-2 px-3 mb-2';
    alertDiv.style.fontSize = '0.8rem';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    `;
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(function() {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

function checkNewMessages() {
    fetch('/mis-mensajes/unread/count')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.count > 0) {
                var badge = document.getElementById('chatBadge');
                var count = document.getElementById('chatBadgeCount');
                if (badge && count) {
                    badge.style.display = 'inline';
                    count.textContent = data.count;
                }
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
}

setInterval(checkNewMessages, 30000);
checkNewMessages();

// ============================================
// OBSERVADOR PARA DETECTAR CAMBIOS EN EL CONTENIDO Y HACER SCROLL
// (Esto garantiza que incluso si se agregan mensajes dinámicamente, el scroll funcione)
// ============================================
(function setupScrollObserver() {
    var targetNode = document.getElementById('chatContent');
    if (!targetNode) return;
    
    var observer = new MutationObserver(function(mutations) {
        // Verificamos si se agregaron nodos o cambiaron el contenido
        var shouldScroll = false;
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' || mutation.type === 'characterData') {
                shouldScroll = true;
            }
        });
        if (shouldScroll) {
            var container = document.getElementById('chatMessages');
            scrollToBottom(container);
        }
    });
    
    observer.observe(targetNode, {
        childList: true,
        subtree: true,
        characterData: true
    });
    
    // También observamos el contenedor principal por si se reemplaza el contenido
    var parentContainer = document.getElementById('chatMessages');
    if (parentContainer) {
        var parentObserver = new MutationObserver(function() {
            var container = document.getElementById('chatMessages');
            scrollToBottom(container);
        });
        parentObserver.observe(parentContainer, {
            childList: true,
            subtree: true,
            characterData: true
        });
    }
})();

</script>
@endpush

<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    #chatMessages::-webkit-scrollbar {
        width: 4px;
    }
    #chatMessages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    #chatMessages::-webkit-scrollbar-thumb {
        background: #c1c7cd;
        border-radius: 10px;
    }
    #chatMessages::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
    .cursor-pointer {
        transition: all 0.3s ease;
    }
    .cursor-pointer:hover {
        transform: scale(1.05);
    }
    .sticky-top {
        z-index: 1;
    }
    @media (max-width: 992px) {
        .sticky-top {
            position: relative !important;
            top: 0 !important;
        }
    }
</style>

@endsection