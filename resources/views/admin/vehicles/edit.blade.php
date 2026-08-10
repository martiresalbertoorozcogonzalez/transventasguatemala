@extends('admin.layouts.admin')

@section('title', 'Editar Vehículo')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Vehículo: {{ $vehicle->title }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
            @csrf
            @method('PUT')
            
            <!-- Alertas de validación -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <h5><i class="fas fa-exclamation-circle"></i> Por favor corrige los siguientes errores:</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- ============================================ -->
                <!-- SECCIÓN 1: INFORMACIÓN BÁSICA -->
                <!-- ============================================ -->
                <div class="col-12">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="fas fa-info-circle text-primary"></i> Información Básica
                    </h5>
                </div>

                <!-- Título -->
                <div class="col-md-12 mb-3">
                    <label for="title" class="form-label fw-bold">
                        Título del Vehículo <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                        <input type="text" 
                               name="title" 
                               id="title"
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $vehicle->title) }}" 
                               placeholder="Ej: Camión Mercedes-Benz Actros 2023"
                               required>
                    </div>
                    @error('title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">El título debe ser descriptivo y único</small>
                </div>

                <!-- Tipo -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label fw-bold">
                        Tipo de Vehículo <span class="text-danger">*</span>
                    </label>
                    <select name="type" 
                            id="type"
                            class="form-select @error('type') is-invalid @enderror" 
                            required>
                        <option value="">Seleccionar tipo</option>
                        <option value="camion" {{ old('type', $vehicle->type) == 'camion' ? 'selected' : '' }}>🚛 Camión</option>
                        <option value="furgon" {{ old('type', $vehicle->type) == 'furgon' ? 'selected' : '' }}>🚐 Furgón</option>
                        <option value="plataforma" {{ old('type', $vehicle->type) == 'plataforma' ? 'selected' : '' }}>📦 Plataforma</option>
                        <option value="remolque" {{ old('type', $vehicle->type) == 'remolque' ? 'selected' : '' }}>🔗 Remolque</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Marca -->
                <div class="col-md-6 mb-3">
                    <label for="brand" class="form-label fw-bold">
                        Marca <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <input type="text" 
                               name="brand" 
                               id="brand"
                               class="form-control @error('brand') is-invalid @enderror" 
                               value="{{ old('brand', $vehicle->brand) }}" 
                               placeholder="Ej: Mercedes-Benz, Ford, Renault"
                               list="brandsList"
                               required>
                        <datalist id="brandsList">
                            <option value="Mercedes-Benz">
                            <option value="Ford">
                            <option value="Renault">
                            <option value="Volvo">
                            <option value="Scania">
                            <option value="MAN">
                            <option value="Iveco">
                            <option value="DAF">
                            <option value="Kenworth">
                            <option value="Peterbilt">
                            <option value="Freightliner">
                            <option value="International">
                            <option value="Mack">
                            <option value="Caterpillar">
                            <option value="Komatsu">
                        </datalist>
                    </div>
                    @error('brand')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Modelo -->
                <div class="col-md-6 mb-3">
                    <label for="model" class="form-label fw-bold">
                        Modelo <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-car"></i></span>
                        <input type="text" 
                               name="model" 
                               id="model"
                               class="form-control @error('model') is-invalid @enderror" 
                               value="{{ old('model', $vehicle->model) }}" 
                               placeholder="Ej: Actros, Master, Cargo"
                               required>
                    </div>
                    @error('model')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Año -->
                <div class="col-md-6 mb-3">
                    <label for="year" class="form-label fw-bold">
                        Año <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        <select name="year" 
                                id="year"
                                class="form-select @error('year') is-invalid @enderror" 
                                required>
                            <option value="">Seleccionar año</option>
                            @for($i = date('Y') + 1; $i >= 1970; $i--)
                                <option value="{{ $i }}" {{ old('year', $vehicle->year) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    @error('year')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 2: PRECIO Y CONDICIONES -->
                <!-- ============================================ -->
                <div class="col-12 mt-3">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="fas text-success"></i>(GTQ) Precio y Condiciones
                    </h5>
                </div>

                <!-- Precio -->
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label fw-bold">
                        Precio (GTQ) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Q</span>
                        <input type="number" 
                               name="price" 
                               id="price"
                               class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price', $vehicle->price) }}" 
                               step="0.01"
                               placeholder="Ej: 185000.00"
                               required>
                    </div>
                    @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Precio en Quetzales moneda Guatemalteca (GTQ)</small>
                </div>

                <!-- Kilometraje -->
                <div class="col-md-6 mb-3">
                    <label for="mileage" class="form-label fw-bold">
                        Kilometraje (km)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tachometer-alt"></i></span>
                        <input type="number" 
                               name="mileage" 
                               id="mileage"
                               class="form-control @error('mileage') is-invalid @enderror" 
                               value="{{ old('mileage', $vehicle->mileage) }}" 
                               placeholder="Ej: 15000"
                               step="1">
                        <span class="input-group-text">km</span>
                    </div>
                    @error('mileage')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 3: ESPECIFICACIONES TÉCNICAS -->
                <!-- ============================================ -->
                <div class="col-12 mt-3">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="fas fa-cogs text-warning"></i> Especificaciones Técnicas
                    </h5>
                </div>

                <!-- Color -->
                <div class="col-md-4 mb-3">
                    <label for="color" class="form-label fw-bold">Color</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-palette"></i></span>
                        <input type="text" 
                               name="color" 
                               id="color"
                               class="form-control @error('color') is-invalid @enderror" 
                               value="{{ old('color', $vehicle->color) }}" 
                               placeholder="Ej: Blanco, Rojo, Azul">
                        <input type="color" 
                               class="form-control" 
                               style="max-width: 50px; padding: 3px; cursor: pointer;"
                               value="{{ old('color', $vehicle->color) ?: '#ffffff' }}"
                               onchange="document.getElementById('color').value = this.value">
                    </div>
                    @error('color')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Motor -->
                <div class="col-md-4 mb-3">
                    <label for="engine" class="form-label fw-bold">Motor</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                        <input type="text" 
                               name="engine" 
                               id="engine"
                               class="form-control @error('engine') is-invalid @enderror" 
                               value="{{ old('engine', $vehicle->engine) }}" 
                               placeholder="Ej: 12.8L V6, 2.3L Diesel">
                    </div>
                    @error('engine')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Capacidad -->
                <div class="col-md-4 mb-3">
                    <label for="capacity" class="form-label fw-bold">Capacidad de Carga</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
                        <input type="number" 
                               name="capacity" 
                               id="capacity"
                               class="form-control @error('capacity') is-invalid @enderror" 
                               value="{{ old('capacity', $vehicle->capacity) }}" 
                               placeholder="Ej: 25.0"
                               step="0.1">
                        <span class="input-group-text">ton</span>
                    </div>
                    @error('capacity')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Transmisión -->
                <div class="col-md-4 mb-3">
                    <label for="transmission" class="form-label fw-bold">Transmisión</label>
                    <select name="transmission" 
                            id="transmission"
                            class="form-select @error('transmission') is-invalid @enderror">
                        <option value="">Seleccionar</option>
                        <option value="Manual" {{ old('transmission', $vehicle->transmission) == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Automática" {{ old('transmission', $vehicle->transmission) == 'Automática' ? 'selected' : '' }}>Automática</option>
                        <option value="Semiautomática" {{ old('transmission', $vehicle->transmission) == 'Semiautomática' ? 'selected' : '' }}>Semiautomática</option>
                        <option value="CVT" {{ old('transmission', $vehicle->transmission) == 'CVT' ? 'selected' : '' }}>CVT</option>
                    </select>
                    @error('transmission')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Combustible -->
                <div class="col-md-4 mb-3">
                    <label for="fuel_type" class="form-label fw-bold">Tipo de Combustible</label>
                    <select name="fuel_type" 
                            id="fuel_type"
                            class="form-select @error('fuel_type') is-invalid @enderror">
                        <option value="">Seleccionar</option>
                        <option value="Diésel" {{ old('fuel_type', $vehicle->fuel_type) == 'Diésel' ? 'selected' : '' }}>Diésel</option>
                        <option value="Gasolina" {{ old('fuel_type', $vehicle->fuel_type) == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                        <option value="Eléctrico" {{ old('fuel_type', $vehicle->fuel_type) == 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                        <option value="Híbrido" {{ old('fuel_type', $vehicle->fuel_type) == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                        <option value="Gas" {{ old('fuel_type', $vehicle->fuel_type) == 'Gas' ? 'selected' : '' }}>Gas (GNV/GLP)</option>
                    </select>
                    @error('fuel_type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 4: ESTADO Y DESTACADO -->
                <!-- ============================================ -->
                <div class="col-12 mt-3">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="fas fa-toggle-on text-info"></i> Estado y Visibilidad
                    </h5>
                </div>

                <!-- Estado -->
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-bold">
                        Estado <span class="text-danger">*</span>
                    </label>
                    <select name="status" 
                            id="status"
                            class="form-select @error('status') is-invalid @enderror" 
                            required>
                        <option value="disponible" {{ old('status', $vehicle->status) == 'disponible' ? 'selected' : '' }}>✅ Disponible</option>
                        <option value="reservado" {{ old('status', $vehicle->status) == 'reservado' ? 'selected' : '' }}>🔄 Reservado</option>
                        <option value="vendido" {{ old('status', $vehicle->status) == 'vendido' ? 'selected' : '' }}>❌ Vendido</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Destacado -->
                <div class="col-md-6 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input type="checkbox" 
                                       name="featured" 
                                       id="featured"
                                       class="form-check-input" 
                                       value="1"
                                       style="width: 3em; height: 1.5em;"
                                       {{ old('featured', $vehicle->featured) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="featured">
                                    <i class="fas fa-star {{ old('featured', $vehicle->featured) ? 'text-warning' : 'text-muted' }}"></i>
                                    Destacar este vehículo
                                </label>
                            </div>
                            <small class="text-muted">Los vehículos destacados aparecen en la sección principal del sitio</small>
                        </div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 5: DESCRIPCIÓN Y CARACTERÍSTICAS -->
                <!-- ============================================ -->
                <div class="col-12 mt-3">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="fas fa-file-alt text-secondary"></i> Descripción y Características
                    </h5>
                </div>

                <!-- Descripción -->
                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label fw-bold">
                        Descripción <span class="text-danger">*</span>
                    </label>
                    <textarea name="description" 
                              id="description"
                              class="form-control @error('description') is-invalid @enderror" 
                              rows="6"
                              placeholder="Describe el vehículo en detalle..."
                              required>{{ old('description', $vehicle->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="text-end">
                        <small class="text-muted" id="charCount">{{ strlen(old('description', $vehicle->description)) }} caracteres</small>
                    </div>
                </div>

                <!-- Características -->
                <div class="col-md-12 mb-3">
                    <label for="features_string" class="form-label fw-bold">Características</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-list"></i></span>
                        <input type="text" 
                               name="features_string" 
                               id="features_string"
                               class="form-control @error('features_string') is-invalid @enderror" 
                               value="{{ old('features_string', implode(', ', $vehicle->features ?? [])) }}" 
                               placeholder="Ej: ABS, GPS, Aire acondicionado, Cámara de reversa">
                    </div>
                    @error('features_string')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Separa cada característica con una coma (,)</small>
                    
                    <!-- Vista previa de características -->
                    <div id="featuresPreview" class="mt-2 d-flex flex-wrap gap-1">
                        @foreach($vehicle->features ?? [] as $feature)
                            <span class="badge bg-info p-2">
                                <i class="fas fa-check-circle"></i> {{ $feature }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 6: IMÁGENES -->
                <!-- ============================================ -->
                <div class="col-12 mt-3">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="fas fa-images text-success"></i> Imágenes del Vehículo
                    </h5>
                </div>

                <!-- Imágenes actuales -->
                @if($vehicle->images && count($vehicle->images) > 0)
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Imágenes actuales</label>
                    <div class="row g-2">
                        @foreach($vehicle->images as $index => $image)
                            <div class="col-md-2 col-3" id="image-container-{{ $index }}">
                                <div class="card">
                                    <img src="{{ asset('storage/vehicles/' . $image) }}" 
                                         class="card-img-top" 
                                         alt="Imagen {{ $index + 1 }}"
                                         style="height: 100px; object-fit: cover;">
                                    <div class="card-body p-1 text-center">
                                        <small class="text-muted">Imagen {{ $index + 1 }}</small>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm w-100 mt-1 delete-image-btn"
                                                data-image="{{ $image }}"
                                                data-vehicle-slug="{{ $vehicle->slug }}"
                                                data-index="{{ $index }}">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Subir nuevas imágenes -->
                <div class="col-md-12 mb-3">
                    <div class="card border-dashed">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                            </div>
                            <label for="images" class="form-label fw-bold">
                                Agregar nuevas imágenes
                            </label>
                            <input type="file" 
                                   name="images[]" 
                                   id="images"
                                   class="form-control @error('images') is-invalid @enderror" 
                                   multiple 
                                   accept="image/*"
                                   style="display: none;">
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('images').click()">
                                <i class="fas fa-folder-open"></i> Seleccionar Imágenes
                            </button>
                            <br>
                            <small class="text-muted">
                                Puedes seleccionar múltiples imágenes (JPG, PNG, GIF, WEBP). Máximo 5MB por imagen.
                                <br>Las nuevas imágenes se agregarán a las existentes.
                            </small>
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Preview de nuevas imágenes -->
                    <div id="imagePreview" class="row mt-3"></div>
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 7: BOTONES DE ACCIÓN -->
                <!-- ============================================ -->
                <div class="col-12 mt-4">
                    <hr>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Actualizar Vehículo
                        </button>
                        <button type="reset" class="btn btn-warning btn-lg">
                            <i class="fas fa-undo"></i> Restablecer
                        </button>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="button" class="btn btn-info btn-lg" onclick="previewVehicle()">
                            <i class="fas fa-eye"></i> Previsualizar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Previsualización -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Previsualización del Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- El contenido se genera con JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
// ============================================
// ELIMINAR IMÁGENES - VERSIÓN FINAL
// ============================================

console.log('🚀 Script iniciado');

function eliminarImagen(button, image, vehicleSlug, index) {
    console.log('📸 Eliminando imagen:', image);
    console.log('🚗 Vehículo slug:', vehicleSlug);
    
    if (!confirm('¿Estás seguro de eliminar esta imagen?')) {
        console.log('❌ Cancelado por usuario');
        return;
    }
    
    button.disabled = true;
    const originalHtml = button.innerHTML;
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    // ✅ RUTA CORRECTA - remove-image
    const url = `/admin/vehicles/${vehicleSlug}/remove-image`;
    console.log('🌐 URL:', url);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (!csrfToken) {
        alert('❌ Error de seguridad');
        button.disabled = false;
        button.innerHTML = originalHtml;
        return;
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ image: image })
    })
    .then(response => {
        console.log('📡 Status:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                console.error('❌ Respuesta:', text);
                throw new Error(`HTTP ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('📦 Respuesta:', data);
        if (data.success) {
            const container = document.getElementById(`image-container-${index}`);
            if (container) {
                container.style.transition = 'all 0.5s ease';
                container.style.opacity = '0';
                setTimeout(() => {
                    container.remove();
                    showAlert('success', '✅ Imagen eliminada correctamente');
                }, 500);
            } else {
                location.reload();
            }
        } else {
            showAlert('danger', '❌ ' + (data.message || 'Error al eliminar'));
            button.disabled = false;
            button.innerHTML = originalHtml;
        }
    })
    .catch(error => {
        console.error('💥 Error:', error);
        showAlert('danger', '❌ Error: ' + error.message);
        button.disabled = false;
        button.innerHTML = originalHtml;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ DOM cargado');
    
    const buttons = document.querySelectorAll('.delete-image-btn');
    console.log('📊 Botones encontrados:', buttons.length);
    
    buttons.forEach(function(button, i) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log(`🖱️ Click en botón ${i}`);
            
            const image = this.dataset.image;
            const vehicleSlug = this.dataset.vehicleSlug;
            const index = this.dataset.index;
            
            if (!image || !vehicleSlug) {
                showAlert('danger', '❌ Error: Faltan datos');
                return;
            }
            
            eliminarImagen(this, image, vehicleSlug, index);
        });
    });
    
    console.log('✅ Todos los botones configurados');
});

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    const container = document.querySelector('.card-body');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
    }
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

console.log('✅ Script listo y funcionando');
</script>
@endpush


@endsection