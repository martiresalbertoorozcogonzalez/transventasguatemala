{{-- resources/views/admin/vehicles/create.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Nuevo Vehículo')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Agregar Nuevo Vehículo</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
            @csrf
            
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
                               value="{{ old('title') }}" 
                               placeholder="Ej: Camión Mercedes-Benz Actros 2023"
                               required>
                    </div>
                    @error('title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">El título debe ser descriptivo y único</small>
                </div>

                <!-- Tipo y Marca -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label fw-bold">
                        Tipo de Vehículo <span class="text-danger">*</span>
                    </label>
                    <select name="type" 
                            id="type"
                            class="form-select @error('type') is-invalid @enderror" 
                            required>
                        <option value="">Seleccionar tipo</option>
                        <option value="camion" {{ old('type') == 'camion' ? 'selected' : '' }}>🚛 Camión</option>
                        <option value="furgon" {{ old('type') == 'furgon' ? 'selected' : '' }}>🚐 Furgón</option>
                        <option value="plataforma" {{ old('type') == 'plataforma' ? 'selected' : '' }}>📦 Plataforma</option>
                        <option value="remolque" {{ old('type') == 'remolque' ? 'selected' : '' }}>🔗 Remolque</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

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
                               value="{{ old('brand') }}" 
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

                <!-- Modelo y Año -->
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
                               value="{{ old('model') }}" 
                               placeholder="Ej: Actros, Master, Cargo"
                               required>
                    </div>
                    @error('model')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

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
                                <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>
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
                        <i class="fas fa-dollar-sign text-success"></i> Precio y Condiciones
                    </h5>
                </div>

                <!-- Precio y Kilometraje -->
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
                               value="{{ old('price') }}" 
                               step="0.01"
                               placeholder="Ej: 185000.00"
                               required>
                    </div>
                    @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Precio en dólares americanos (USD)</small>
                </div>

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
                               value="{{ old('mileage') }}" 
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
                               value="{{ old('color') }}" 
                               placeholder="Ej: Blanco, Rojo, Azul">
                        <input type="color" 
                               class="form-control" 
                               style="max-width: 50px; padding: 3px; cursor: pointer;"
                               value="{{ old('color') ?: '#ffffff' }}"
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
                               value="{{ old('engine') }}" 
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
                               value="{{ old('capacity') }}" 
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
                        <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Automática" {{ old('transmission') == 'Automática' ? 'selected' : '' }}>Automática</option>
                        <option value="Semiautomática" {{ old('transmission') == 'Semiautomática' ? 'selected' : '' }}>Semiautomática</option>
                        <option value="CVT" {{ old('transmission') == 'CVT' ? 'selected' : '' }}>CVT</option>
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
                        <option value="Diésel" {{ old('fuel_type') == 'Diésel' ? 'selected' : '' }}>Diésel</option>
                        <option value="Gasolina" {{ old('fuel_type') == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                        <option value="Eléctrico" {{ old('fuel_type') == 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                        <option value="Híbrido" {{ old('fuel_type') == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                        <option value="Gas" {{ old('fuel_type') == 'Gas' ? 'selected' : '' }}>Gas (GNV/GLP)</option>
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
                        <option value="disponible" {{ old('status') == 'disponible' ? 'selected' : '' }}>✅ Disponible</option>
                        <option value="reservado" {{ old('status') == 'reservado' ? 'selected' : '' }}>🔄 Reservado</option>
                        <option value="vendido" {{ old('status') == 'vendido' ? 'selected' : '' }}>❌ Vendido</option>
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
                                       {{ old('featured') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="featured">
                                    <i class="fas fa-star {{ old('featured') ? 'text-warning' : 'text-muted' }}"></i>
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
                              placeholder="Describe el vehículo en detalle. Incluye: estado, mantenimiento, características especiales, etc."
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="text-end">
                        <small class="text-muted" id="charCount">0 caracteres</small>
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
                               value="{{ old('features_string') }}" 
                               placeholder="Ej: ABS, GPS, Aire acondicionado, Cámara de reversa, Elevador hidráulico">
                    </div>
                    @error('features_string')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Separa cada característica con una coma (,)</small>
                    
                    <!-- Vista previa de características -->
                    <div id="featuresPreview" class="mt-2 d-flex flex-wrap gap-1"></div>
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 6: IMÁGENES -->
                <!-- ============================================ -->
                <div class="col-12 mt-3">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="fas fa-images text-success"></i> Imágenes del Vehículo
                    </h5>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="card border-dashed">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                            </div>
                            <label for="images" class="form-label fw-bold">
                                Selecciona las imágenes del vehículo
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
                                Puedes seleccionar múltiples imágenes (JPG, PNG, GIF). Máximo 5MB por imagen.
                                <br>La primera imagen será la principal.
                            </small>
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Preview de imágenes -->
                    <div id="imagePreview" class="row mt-3"></div>
                </div>

                <!-- ============================================ -->
                <!-- SECCIÓN 7: BOTONES DE ACCIÓN -->
                <!-- ============================================ -->
                <div class="col-12 mt-4">
                    <hr>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Vehículo
                        </button>
                        <button type="reset" class="btn btn-warning btn-lg">
                            <i class="fas fa-undo"></i> Limpiar Formulario
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
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // 1. CONTADOR DE CARACTERES
    // ============================================
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    description.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count + ' caracteres';
        if (count > 500) {
            charCount.style.color = 'orange';
        } else {
            charCount.style.color = '';
        }
        if (count > 1000) {
            charCount.style.color = 'red';
        }
    });

    // ============================================
    // 2. PREVISUALIZACIÓN DE IMÁGENES
    // ============================================
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        const files = Array.from(this.files);
        
        if (files.length === 0) {
            preview.innerHTML = '<div class="col-12 text-muted text-center">No hay imágenes seleccionadas</div>';
            return;
        }
        
        // Mostrar cuántas imágenes se seleccionaron
        const info = document.createElement('div');
        info.className = 'col-12 mb-2';
        info.innerHTML = `<div class="alert alert-info">
            <i class="fas fa-info-circle"></i> ${files.length} imagen(es) seleccionada(s). 
            La primera será la imagen principal.
        </div>`;
        preview.appendChild(info);
        
        files.forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-4 mb-2';
                    col.innerHTML = `
                        <div class="card h-100">
                            <img src="${e.target.result}" 
                                 class="card-img-top" 
                                 style="height: 150px; object-fit: cover;">
                            <div class="card-body p-1 text-center">
                                <small class="text-muted d-block">${file.name}</small>
                                <small class="text-muted">${(file.size / 1024).toFixed(0)} KB</small>
                                ${index === 0 ? '<span class="badge bg-primary">Principal</span>' : ''}
                            </div>
                        </div>
                    `;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // ============================================
    // 3. PREVISUALIZACIÓN DE CARACTERÍSTICAS
    // ============================================
    const featuresInput = document.getElementById('features_string');
    const featuresPreview = document.getElementById('featuresPreview');
    
    featuresInput.addEventListener('input', function() {
        const features = this.value.split(',').map(f => f.trim()).filter(f => f);
        featuresPreview.innerHTML = '';
        
        features.forEach(feature => {
            const badge = document.createElement('span');
            badge.className = 'badge bg-info p-2';
            badge.innerHTML = `<i class="fas fa-check-circle"></i> ${feature}`;
            featuresPreview.appendChild(badge);
        });
    });

    // ============================================
    // 4. PREVISUALIZACIÓN DEL VEHÍCULO
    // ============================================
    window.previewVehicle = function() {
        const title = document.getElementById('title').value || 'Sin título';
        const type = document.getElementById('type').value || 'No especificado';
        const brand = document.getElementById('brand').value || 'No especificado';
        const model = document.getElementById('model').value || 'No especificado';
        const year = document.getElementById('year').value || 'No especificado';
        const price = document.getElementById('price').value || '0';
        const mileage = document.getElementById('mileage').value || 'No especificado';
        const color = document.getElementById('color').value || 'No especificado';
        const engine = document.getElementById('engine').value || 'No especificado';
        const capacity = document.getElementById('capacity').value || 'No especificado';
        const transmission = document.getElementById('transmission').value || 'No especificado';
        const fuel_type = document.getElementById('fuel_type').value || 'No especificado';
        const status = document.getElementById('status').value || 'No especificado';
        const featured = document.getElementById('featured').checked;
        const description = document.getElementById('description').value || 'Sin descripción';
        const features = document.getElementById('features_string').value || '';

        const statusLabels = {
            'disponible': '✅ Disponible',
            'reservado': '🔄 Reservado',
            'vendido': '❌ Vendido'
        };

        const typeIcons = {
            'camion': '🚛',
            'furgon': '🚐',
            'plataforma': '📦',
            'remolque': '🔗'
        };

        const modalContent = document.getElementById('previewContent');
        modalContent.innerHTML = `
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">${title}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>${typeIcons[type] || '🚗'} Tipo:</strong> ${type}</p>
                                    <p><strong>🏢 Marca:</strong> ${brand}</p>
                                    <p><strong>🚗 Modelo:</strong> ${model}</p>
                                    <p><strong>📅 Año:</strong> ${year}</p>
                                    <p><strong>💰 Precio:</strong> $${parseFloat(price).toLocaleString()}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>📊 Kilometraje:</strong> ${mileage} km</p>
                                    <p><strong>🎨 Color:</strong> ${color}</p>
                                    <p><strong>⚙️ Motor:</strong> ${engine}</p>
                                    <p><strong>📦 Capacidad:</strong> ${capacity} ton</p>
                                    <p><strong>🔧 Transmisión:</strong> ${transmission}</p>
                                    <p><strong>⛽ Combustible:</strong> ${fuel_type}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>📌 Estado:</strong> ${statusLabels[status] || status}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>⭐ Destacado:</strong> ${featured ? '✅ Sí' : '❌ No'}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h6><strong>📝 Descripción:</strong></h6>
                                    <p>${description}</p>
                                </div>
                            </div>
                            ${features ? `
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h6><strong>✨ Características:</strong></h6>
                                    <div class="d-flex flex-wrap gap-1">
                                        ${features.split(',').map(f => f.trim()).filter(f => f).map(f => 
                                            `<span class="badge bg-success">${f}</span>`
                                        ).join('')}
                                    </div>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Abrir el modal
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    };

    // ============================================
    // 5. GENERAR TÍTULO AUTOMÁTICAMENTE
    // ============================================
    function generateTitle() {
        const brand = document.getElementById('brand').value.trim();
        const model = document.getElementById('model').value.trim();
        const year = document.getElementById('year').value;
        
        if (brand && model && year) {
            const title = `${brand} ${model} ${year}`;
            const titleInput = document.getElementById('title');
            if (!titleInput.value || titleInput.value === titleInput.defaultValue) {
                titleInput.value = title;
            }
        }
    }

    document.getElementById('brand').addEventListener('change', generateTitle);
    document.getElementById('model').addEventListener('change', generateTitle);
    document.getElementById('year').addEventListener('change', generateTitle);

    // ============================================
    // 6. VALIDACIÓN DEL FORMULARIO
    // ============================================
    document.getElementById('vehicleForm').addEventListener('submit', function(e) {
        const images = document.getElementById('images');
        const requiredFields = ['title', 'type', 'brand', 'model', 'year', 'price', 'description'];
        let hasError = false;
        
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                hasError = true;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert('⚠️ Por favor completa todos los campos requeridos.');
        }
    });

    // ============================================
    // 7. RESET DEL FORMULARIO
    // ============================================
    document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('¿Estás seguro de limpiar todos los campos?')) {
            document.getElementById('vehicleForm').reset();
            document.getElementById('imagePreview').innerHTML = '';
            document.getElementById('featuresPreview').innerHTML = '';
            document.getElementById('charCount').textContent = '0 caracteres';
        }
    });
});
</script>

<style>
.border-dashed {
    border: 2px dashed #dee2e6;
    background-color: #f8f9fa;
}
.border-dashed:hover {
    border-color: #0d6efd;
    background-color: #e7f1ff;
}
</style>
@endpush
@endsection