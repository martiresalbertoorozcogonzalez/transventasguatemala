@extends('layouts.app')

@section('title', $vehicle->title)

@section('meta_description', Str::limit(strip_tags($vehicle->description), 160))

@section('content')
    <div class="container py-4">

        <!-- Breadcrumb -->
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/vehiculos">Vehículos</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ Str::limit($vehicle->title, 40) }}
                </li>
            </ol>
        </nav>

        <div class="row">

            <!-- ============================================ -->
            <!-- COLUMNA IZQUIERDA: GALERÍA DE IMÁGENES -->
            <!-- ============================================ -->
            
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        
                        @if($vehicle->images && count($vehicle->images) > 0)
                           
                            <!-- Imagen principal -->
                            
                            
                                
                                <div class="img-container-lg">
                                    <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                        alt="{{ $vehicle->title }}" 
                                        class="img-full"
                                        id="mainImage">
                                </div>
                                
                                <!-- Badge de estado -->
                                <span class="position-absolute top-0 end-0 badge bg-{{ $vehicle->status_badge }} m-3 fs-6 p-2">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                                
                                @if($vehicle->featured)
                                    <span class="position-absolute top-0 start-0 badge bg-warning m-3 fs-6 p-2">
                                        <i class="fas fa-star"></i> Destacado
                                    </span>
                                @endif
                           
                            
                            <!-- Miniaturas -->
                        
                            @if(count($vehicle->images) > 1)
                            <div class="p-3">

                                <div class="row g-2">

                                    @foreach($vehicle->images as $index => $image)
                                        <div class="col-3 col-md-2">

                                        <div class="img-container-sm">
                                            <img src="{{ asset('storage/vehicles/' . $image) }}" 
                                                alt="Imagen {{ $index + 1 }}" 
                                                class="img-full cursor-pointer"
                                                onclick="changeImage('{{ asset('storage/vehicles/' . $image) }}', this)"
                                                style="border: 2px solid {{ $index == 0 ? '#0d6efd' : 'transparent' }}; border-radius: 4px;">
                                        </div>
                                            
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                            @endif

                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                style="height: 450px; border-radius: 8px;">
                                <div class="text-center">
                                    <i class="fas fa-truck fa-6x text-muted"></i>
                                    <p class="text-muted mt-3">Sin imágenes disponibles</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Redes Sociales - Compartir -->
                
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span class="fw-bold"><i class="fas fa-share-alt"></i> Compartir:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                            target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($vehicle->title) }}" 
                            target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($vehicle->title . ' - ' . url()->current()) }}" 
                            target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($vehicle->title) }}" 
                            target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-telegram"></i> Telegram
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- COLUMNA DERECHA: INFORMACIÓN DEL VEHÍCULO -->
            <!-- ============================================ -->
            
            <div class="col-lg-5">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">

                        <!-- Título y precio -->
                        
                        <h2 class="card-title">{{ $vehicle->title }}</h2>
                        
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
                        
                        <h3 class="text-primary mb-4">{{ $vehicle->price_formatted }}</h3>
                        
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
                            <button class="btn btn-success btn-lg" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#contactModal">
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
        <!-- SECCIÓN: VEHÍCULOS RELACIONADOS -->
        <!-- ============================================ -->
 
        @if($related->count() > 0)
        <div class="mt-5">
            <h4 class="mb-3"><i class="fas fa-truck"></i> Vehículos Relacionados</h4>
            <div class="row">

                @foreach($related as $rel)
                <div class="col-md-3 col-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        @if($rel->images && count($rel->images) > 0)
                            <img src="{{ asset('storage/vehicles/' . $rel->images[0]) }}" 
                                class="card-img-top" 
                                alt="{{ $rel->title }}"
                                style="height: 150px; width: 100%; object-fit: cover; object-position: center;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                style="height: 150px; width: 100%;">
                                <i class="fas fa-truck fa-2x text-muted"></i>
                            </div>
                        @endif
                        <!-- ... resto del contenido ... -->
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
        @endif
    </div>


<!-- Modal de Contacto -->

<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-envelope"></i> Contactar Vendedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <form action="{{ url('contact.vehicle', $vehicle) }}" method="POST" id="contactForm">
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

@push('scripts')

<script>

    // Contactar vendedor
    
    function contactar() {
        const modal = new bootstrap.Modal(document.getElementById('contactModal'));
        modal.show();
    }

    // Animación de entrada

    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * (index + 1));
        });
    });

    // ============================================
    // FUNCIÓN CONTACTAR - ABRE EL MODAL
    // ============================================

    function contactar() {
        console.log('📞 Abriendo modal de contacto');
        const modal = new bootstrap.Modal(document.getElementById('contactModal'));
        modal.show();
    }

    // ============================================
    // ENVÍO DEL FORMULARIO DE CONTACTO
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');
        
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                console.log('📧 Enviando mensaje...');
                
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                
                // Mostrar loading

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enviando...';
                
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('📦 Respuesta:', data);
                    if (data.success) {
                        alert('✅ ' + data.message);
                        this.reset();
                        bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('💥 Error:', error);
                    alert('❌ Error al enviar el mensaje. Por favor, intenta de nuevo.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        }
    });
  
</script>

<style>
    .cursor-pointer {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .cursor-pointer:hover {
        transform: scale(1.05);
        opacity: 0.8;
    }
    .text-justify {
        text-align: justify;
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

@endpush

@endsection