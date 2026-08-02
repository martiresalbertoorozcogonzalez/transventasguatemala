@extends('layouts.app')

@section('title', 'Camiones, Furgones y Plataformas en Venta')

@section('meta_description', 'Encuentra los mejores camiones, furgones y plataformas en venta. Precios competitivos y amplia variedad de vehículos comerciales.')

@section('content')
<div class="container py-4">
    

   <div class="bg-primary text-white rounded-4 p-4 p-md-5 mb-5 text-center" 
     style="background: linear-gradient(135deg, #1a237e 0%, #0d47a1 50%, #006064 100%);">
    <h1 class="display-5 fw-bold">
        <i class="fas fa-truck"></i> Encuentra tu Vehículo Ideal
    </h1>
    <p class="lead fs-6">Los mejores camiones, furgones y plataformas al mejor precio</p>
    <p class="mb-3 small">Más de <strong>{{ $vehicles->total() }}</strong> vehículos disponibles</p>
    
    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
      
    <!-- ✅ BARRA DE BÚSQUEDA COMPACTA -->
        <div class="position-relative" style="width: 100%; max-width: 500px;">
            <form id="searchForm" action="/buscar" method="GET" class="w-100">
                <div class="input-group" style="border-radius: 50px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    <span class="input-group-text bg-white border-0 ps-3" style="border-radius: 50px 0 0 50px;">
                        <i class="fas fa-search text-primary" style="font-size: 0.9rem;"></i>
                    </span>
                    <input type="text" 
                           name="q"
                           id="searchInput" 
                           class="form-control border-0 py-2" 
                           placeholder="🔍 ¿Qué vehículo buscas? (marca, modelo, tipo...)"
                           autocomplete="off"
                           style="font-size: 0.9rem;">
                    <button type="submit" class="btn btn-light border-0 px-4" 
                            style="border-radius: 0 50px 50px 0; background: white; font-weight: 500; color: #0d6efd;">
                        <i class="fas fa-search me-1"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Botones -->
        <div class="d-flex gap-2 flex-wrap justify-content-center">
            <a href="#vehicles" class="btn btn-light btn-sm px-3 py-1.5" style="font-size: 0.85rem;">
                <i class="fas fa-list"></i> Ver Todos
            </a>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm px-3 py-1.5" style="font-size: 0.85rem;">
                        <i class="fas fa-cog"></i> Admin
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm px-3 py-1.5" style="font-size: 0.85rem;">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            @endauth
        </div>

    </div>
    </div>

   
    <!-- ============================================ -->
    <!-- VEHÍCULOS RECIÉN INGRESADOS (NUEVA SECCIÓN) -->
    <!-- ============================================ -->
   
    @if($recentVehicles->count() > 0)
    <section class="mb-5" id="recent">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-clock text-success"></i> Recién Ingresados
            </h2>
            <span class="badge bg-success p-2">¡Nuevos!</span>
        </div>
        
        <div class="row">
            @foreach($recentVehicles as $vehicle)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-success">
                    <div class="position-relative">
                        <div class="img-container">
                            @if($vehicle->images && count($vehicle->images) > 0)
                                <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                     class="img-full" alt="{{ $vehicle->title }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px; width: 100%;">
                                    <i class="fas fa-truck fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <span class="position-absolute top-0 end-0 badge bg-success m-2 p-2">
                            <i class="fas fa-clock"></i> Nuevo
                        </span>
                        <span class="position-absolute bottom-0 start-0 badge bg-{{ $vehicle->status_badge }} m-2 p-2">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($vehicle->title, 40) }}</h5>
                        <p class="text-muted small">
                            <i class="fas fa-building"></i> {{ $vehicle->brand }}
                            <i class="fas fa-calendar ms-2"></i> {{ $vehicle->year }}
                            <i class="fas fa-clock ms-2 text-success"></i> {{ $vehicle->created_at->diffForHumans() }}
                        </p>
                        <p class="text-primary fw-bold fs-4">{{ $vehicle->price_formatted }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-info">{{ ucfirst($vehicle->type) }}</span>
                            <a href="/vehiculos/{{ $vehicle->slug }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- ============================================ -->
    <!-- TODOS LOS VEHÍCULOS -->
    <!-- ============================================ -->
   
    <section id="vehicles">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-truck"></i> Todos los Vehículos
            </h2>
            <span class="text-muted">{{ $vehicles->total() }} vehículos disponibles</span>
        </div>

        <div class="row">
   
        <!-- Filtros Sidebar -->
   
        <div class="col-lg-3 mb-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-filter"></i> Filtros
                        </h5>
                        <hr>
                        
                        <form action="/filtrar" method="GET" id="filterForm">
                            <!-- Tipo -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo</label>
                                <select name="type" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Marca -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Marca</label>
                                <select name="brand" class="form-select">
                                    <option value="">Todas</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                            {{ $brand }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Precio -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rango de Precio</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" 
                                               name="min_price" 
                                               class="form-control" 
                                               placeholder="Mín" 
                                               value="{{ request('min_price') }}"
                                               step="1000">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" 
                                               name="max_price" 
                                               class="form-control" 
                                               placeholder="Máx" 
                                               value="{{ request('max_price') }}"
                                               step="1000">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Año -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Año</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" 
                                               name="year_from" 
                                               class="form-control" 
                                               placeholder="Desde" 
                                               value="{{ request('year_from') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" 
                                               name="year_to" 
                                               class="form-control" 
                                               placeholder="Hasta" 
                                               value="{{ request('year_to') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-search"></i> Aplicar Filtros
                            </button>
                            
                            <a href="/vehiculos" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-undo"></i> Limpiar Filtros
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Lista de vehículos -->
   
            <div class="col-lg-9">
                <div id="vehicleGrid">
                    @include('components.vehicle-grid', ['vehicles' => $vehicles])
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $vehicles->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
</div>



<!-- ============================================ -->
<!-- MODAL DE RESULTADOS DE BÚSQUEDA -->
<!-- ============================================ -->

<div class="modal fade" id="searchResultModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-search"></i> Resultado de búsqueda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="searchResultContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Buscando vehículo...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Filtros en tiempo real
document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const params = new URLSearchParams(formData);
    
    // Mostrar loading
    document.getElementById('vehicleGrid').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Buscando vehículos...</p>
        </div>
    `;
    
    fetch(`/filtrar?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('vehicleGrid').innerHTML = html;
        history.pushState(null, '', `?${params.toString()}`);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('vehicleGrid').innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Error al cargar los filtros. Por favor, intenta de nuevo.
            </div>
        `;
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const suggestions = document.getElementById('searchSuggestions');
    const modal = new bootstrap.Modal(document.getElementById('searchResultModal'));
    const modalContent = document.getElementById('searchResultContent');
    
    let searchTimeout = null;
    
    // ============================================
    // BÚSQUEDA EN TIEMPO REAL (SUGERENCIAS)
    // ============================================
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            suggestions.style.display = 'none';
            return;
        }
        
        searchTimeout = setTimeout(function() {
            fetch(`/buscar?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Extraer solo los vehículos del grid
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const grid = tempDiv.querySelector('#vehicleGrid');
                
                if (grid && grid.innerHTML.trim() !== '') {
                    suggestions.innerHTML = grid.innerHTML;
                    suggestions.style.display = 'block';
                } else {
                    suggestions.innerHTML = `
                        <div class="p-3 text-center text-muted">
                            <i class="fas fa-search fa-2x d-block mb-2"></i>
                            No se encontraron vehículos para "<strong>${query}</strong>"
                        </div>
                    `;
                    suggestions.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                suggestions.innerHTML = `
                    <div class="p-3 text-center text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        Error al buscar. Intenta de nuevo.
                    </div>
                `;
                suggestions.style.display = 'block';
            });
        }, 300);
    });
    
    // Ocultar sugerencias al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.style.display = 'none';
        }
    });
    
    // ============================================
    // VER DETALLE DEL VEHÍCULO EN MODAL
    // ============================================
    function showVehicleDetail(slug) {
        modal.show();
        modalContent.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2">Cargando detalles del vehículo...</p>
            </div>
        `;
        
        fetch(`/vehiculos/${slug}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Extraer solo el contenido principal
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const content = tempDiv.querySelector('.container.py-4');
            
            if (content) {
                modalContent.innerHTML = content.innerHTML;
            } else {
                modalContent.innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x d-block mb-3"></i>
                        <h5>No se pudo cargar el vehículo</h5>
                        <p>Intenta de nuevo más tarde</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            modalContent.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x d-block mb-3"></i>
                    <h5>Error al cargar el vehículo</h5>
                    <p>${error.message}</p>
                </div>
            `;
        });
    }
    
    // Delegar eventos en las sugerencias
    suggestions.addEventListener('click', function(e) {
        const link = e.target.closest('a[href^="/vehiculos/"]');
        if (link) {
            e.preventDefault();
            const slug = link.getAttribute('href').replace('/vehiculos/', '');
            suggestions.style.display = 'none';
            searchInput.value = '';
            showVehicleDetail(slug);
        }
    });
    
    // ============================================
    // BÚSQUEDA CON BOTÓN O ENTER
    // ============================================
    function performSearch() {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            alert('Escribe al menos 2 caracteres para buscar');
            return;
        }
        
        fetch(`/buscar?q=${encodeURIComponent(query)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const grid = tempDiv.querySelector('#vehicleGrid');
            
            if (grid && grid.innerHTML.trim() !== '') {
                // Mostrar los resultados en el modal
                modal.show();
                modalContent.innerHTML = `
                    <div class="mb-3">
                        <h5>Resultados para: <strong>"${query}"</strong></h5>
                        <p class="text-muted small">Haz clic en cualquier vehículo para ver más detalles</p>
                    </div>
                    ${grid.innerHTML}
                `;
                
                // Agregar eventos a los enlaces de los resultados
                modalContent.querySelectorAll('a[href^="/vehiculos/"]').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const slug = this.getAttribute('href').replace('/vehiculos/', '');
                        modal.hide();
                        setTimeout(() => {
                            showVehicleDetail(slug);
                        }, 300);
                    });
                });
            } else {
                alert(`No se encontraron vehículos para "${query}"`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al buscar. Intenta de nuevo.');
        });
    }
    
    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });
});       

</script>
@endpush

@endsection