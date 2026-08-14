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
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/vehiculos">Vehículos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($vehicle->title, 40) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- ============================================ -->
        <!-- COLUMNA IZQUIERDA: GALERÍA DE IMÁGENES -->
        <!-- ============================================ -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    @if($vehicle->images && count($vehicle->images) > 0)
                        <!-- Imagen principal -->
                        <div class="position-relative">
                            <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                 alt="{{ $vehicle->title }}" 
                                 class="img-fluid w-100"
                                 style="height: 450px; object-fit: contain; object-position: center; background: #ffffff; border-radius: 12px 12px 0 0;"
                                 id="mainImage">
                            
                            <!-- Badges flotantes -->
                            <span class="position-absolute top-0 end-0 badge bg-{{ $vehicle->status_badge }} m-3 fs-6 p-2">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                            
                            @if($vehicle->featured)
                                <span class="position-absolute top-0 start-0 badge bg-warning m-3 fs-6 p-2">
                                    <i class="fas fa-star"></i> Destacado
                                </span>
                            @endif
                            
                            <!-- Contador de vistas -->
                            <span class="position-absolute bottom-0 end-0 badge bg-dark bg-opacity-75 m-3 p-2">
                                <i class="fas fa-eye"></i> {{ $vehicle->views }} vistas
                            </span>
                        </div>
                        
                        <!-- Miniaturas -->
                        @if(count($vehicle->images) > 1)
                        <div class="p-3">
                            <div class="row g-2">
                                @foreach($vehicle->images as $index => $image)
                                    <div class="col-3 col-md-2">
                                        <img src="{{ asset('storage/vehicles/' . $image) }}" 
                                             alt="Imagen {{ $index + 1 }}" 
                                             class="img-fluid rounded cursor-pointer"
                                             style="height: 80px; width: 100%; object-fit: contain; object-position: center; cursor: pointer; border: 2px solid {{ $index == 0 ? '#0d6efd' : 'transparent' }}; background: #ffffff;"
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
                             style="height: 450px; border-radius: 12px;">
                            <div class="text-center">
                                <i class="fas fa-truck fa-6x text-muted"></i>
                                <p class="text-muted mt-3">Sin imágenes disponibles</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- REDES SOCIALES -->
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span class="fw-bold"><i class="fas fa-share-alt"></i> Síguenos en:</span>
                        <a href="https://www.facebook.com/TransVentasGuatemala" target="_blank" 
                           class="btn btn-outline-primary btn-sm rounded-pill px-3"
                           style="font-weight: 500; border-width: 2px;">
                            <i class="fab fa-facebook-f me-1"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/TransVentasGuatemala" target="_blank" 
                           class="btn btn-outline-danger btn-sm rounded-pill px-3"
                           style="font-weight: 500; border-width: 2px;">
                            <i class="fab fa-instagram me-1"></i> Instagram
                        </a>
                        <a href="https://www.tiktok.com/@TransVentasGuatemala" target="_blank" 
                           class="btn btn-outline-dark btn-sm rounded-pill px-3"
                           style="font-weight: 500; border-width: 2px;">
                            <i class="fab fa-tiktok me-1"></i> TikTok
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- COLUMNA DERECHA: INFORMACIÓN DEL VEHÍCULO -->
        <!-- ============================================ -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-body">
                    <!-- Título -->
                    <h2 class="card-title mb-2">{{ $vehicle->title }}</h2>
                    
                    <!-- Estado y destacado -->
                    <div class="mb-3">
                        <span class="badge bg-{{ $vehicle->status_badge }} fs-6 p-2 me-2">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                        @if($vehicle->featured)
                            <span class="badge bg-warning fs-6 p-2">
                                <i class="fas fa-star"></i> Destacado
                            </span>
                        @endif
                    </div>
                    
                    <!-- Precio -->
                    <h3 class="text-primary mb-4">{{ $vehicle->price_formatted }}</h3>
                    
                    <hr>
                    
                    <!-- Especificaciones principales -->
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
                                    <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $vehicle->color }}; border-radius: 50%; border: 1px solid #ddd; vertical-align: middle;"></span>
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
                        <h6><i class="fas fa-file-alt"></i> Descripción</h6>
                        <p class="text-justify">{{ $vehicle->description }}</p>
                    </div>
                    
                    <!-- Características -->
                    @if($vehicle->features && count($vehicle->features) > 0)
                    <div class="mb-3">
                        <h6><i class="fas fa-list"></i> Características</h6>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($vehicle->features as $feature)
                                <span class="badge bg-success p-2">
                                    <i class="fas fa-check-circle"></i> {{ $feature }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <hr>
                    
                    <!-- Botones de acción -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-lg" onclick="contactar()">
                            <i class="fas fa-phone"></i> Contactar Vendedor
                        </button>
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="fas fa-print"></i> Imprimir Ficha
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- VEHÍCULOS RELACIONADOS -->
    <!-- ============================================ -->
    @if($related->count() > 0)
    <div class="mt-5">
        <h4 class="mb-3"><i class="fas fa-truck"></i> Vehículos Relacionados</h4>
        
        <div class="row">
            @foreach($related as $rel)
            <div class="col-md-3 col-6 mb-3">
                <a href="/vehiculos/{{ $rel->slug }}" class="text-decoration-none d-block">
                    <div class="card h-100 shadow-sm border-0 hover-card" 
                         style="border-radius: 16px; overflow: hidden; transition: all 0.3s ease; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        
                        <div style="width: 100%; height: 150px; background: #ffffff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 8px;">
                            @if($rel->images && count($rel->images) > 0)
                                <img src="{{ asset('storage/vehicles/' . $rel->images[0]) }}" 
                                     alt="{{ $rel->title }}"
                                     style="max-height: 100%; max-width: 100%; object-fit: contain; object-position: center; background: #ffffff;">
                            @else
                                <i class="fas fa-truck fa-2x text-muted"></i>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h6 class="card-title text-dark fw-semibold mb-1" style="font-size: 0.9rem;">
                                {{ Str::limit($rel->title, 35) }}
                            </h6>
                            <p class="text-primary fw-bold mb-1" style="font-size: 0.95rem;">
                                {{ $rel->price_formatted }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                    {{ ucfirst($rel->type) }}
                                </span>
                                <span class="text-muted small">
                                    <i class="fas fa-calendar"></i> {{ $rel->year }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- ============================================ -->
<!-- MODAL DE CONTACTO -->
<!-- ============================================ -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-envelope"></i> Contactar Vendedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contact.vehicle', $vehicle) }}" method="POST" id="contactForm">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Tu nombre <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tu email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="3" required>Me interesa el vehículo: {{ $vehicle->title }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-paper-plane"></i> Enviar mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ============================================
// FUNCIÓN GLOBAL - CONTACTAR
// ============================================
function contactar() {
    console.log('📞 Abriendo modal de contacto');
    const modalElement = document.getElementById('contactModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    } else {
        console.error('❌ Modal no encontrado');
    }
}

// ============================================
// CAMBIAR IMAGEN PRINCIPAL
// ============================================
function changeImage(url, element) {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = url;
    }
    
    document.querySelectorAll('.cursor-pointer').forEach(el => {
        el.style.borderColor = 'transparent';
        el.style.borderWidth = '2px';
    });
    
    if (element) {
        element.style.borderColor = '#0d6efd';
        element.style.borderWidth = '2px';
    }
}

// ============================================
// ENVÍO DEL FORMULARIO DE CONTACTO
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            const url = this.action;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enviando...';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Cerrar el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Mostrar alerta
                if (data.success) {
                    showAlert('success', '✅ ' + data.message);
                } else {
                    showAlert('danger', '❌ ' + (data.message || 'Error al enviar'));
                }
                
                this.reset();
            })
            .catch(error => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                if (modal) {
                    modal.hide();
                }
                showAlert('danger', '❌ Error al enviar: ' + error.message);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});

// ============================================
// FUNCIÓN PARA MOSTRAR ALERTAS
// ============================================
function showAlert(type, message) {
    // Remover alertas anteriores
    document.querySelectorAll('.custom-alert').forEach(el => el.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `custom-alert alert alert-${type} alert-dismissible fade show`;
    alertDiv.style.cssText = `
        position: fixed; 
        top: 20px; 
        right: 20px; 
        z-index: 9999; 
        min-width: 320px; 
        max-width: 500px; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.2); 
        border-radius: 12px; 
        padding: 20px 25px;
        animation: slideInRight 0.5s ease;
    `;
    
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const color = type === 'success' ? '#28a745' : '#dc3545';
    const title = type === 'success' ? '¡Mensaje enviado!' : '¡Error!';
    
    alertDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas ${icon} fa-2x me-3" style="color: ${color};"></i>
            <div class="flex-grow-1">
                <strong class="d-block" style="font-size: 1rem;">${title}</strong>
                <span style="font-size: 0.95rem;">${message}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alertDiv.style.opacity = '0';
            alertDiv.style.transform = 'translateX(100px)';
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 500);
        }
    }, 6000);
}

// Agregar estilos de animación
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .hover-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    .hover-card .card-title {
        transition: color 0.3s ease;
    }
    .hover-card:hover .card-title {
        color: #0d6efd !important;
    }
    .text-justify {
        text-align: justify;
    }
`;
document.head.appendChild(style);
</script>

@endsection