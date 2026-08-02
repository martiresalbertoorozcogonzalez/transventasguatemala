{{-- resources/views/admin/vehicles/index.blade.php --}}
{{-- VERSIÓN CORREGIDA CON IMÁGENES --}}

@extends('admin.layouts.admin')

@section('title', 'Administrar Vehículos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4><i class="fas fa-truck"></i> Lista de Vehículos</h4>
        <p class="text-muted">Gestiona todos los vehículos de tu plataforma</p>
    </div>
    <div>
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Vehículo
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Destacado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->id }}</td>
                        <td>
                            @if($vehicle->images && count($vehicle->images) > 0)
                                {{-- ✅ IMAGEN CORRECTA --}}
                                <img src="{{ asset('storage/vehicles/' . $vehicle->images[0]) }}" 
                                     alt="{{ $vehicle->title }}" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px; border-radius: 8px;">
                                    <i class="fas fa-truck text-white fa-2x"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ Str::limit($vehicle->title, 30) }}</strong>
                            <br>
                            <small class="text-muted">{{ $vehicle->brand }} {{ $vehicle->model }}</small>
                        </td>
                        <td><span class="badge bg-info">{{ ucfirst($vehicle->type) }}</span></td>
                        <td><strong class="text-primary">{{ $vehicle->price_formatted }}</strong></td>
                        <td>
                            <span class="badge bg-{{ $vehicle->status_badge }}">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input featured-toggle" 
                                       type="checkbox" 
                                       data-id="{{ $vehicle->id }}"
                                       {{ $vehicle->featured ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    <i class="fas fa-star {{ $vehicle->featured ? 'text-warning' : 'text-muted' }}"></i>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.vehicles.show', $vehicle) }}" 
                                   class="btn btn-info" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                                   class="btn btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger" 
                                        onclick="deleteVehicle({{ $vehicle->id }}, '{{ $vehicle->title }}')"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $vehicle->id }}" 
                                  action="{{ route('admin.vehicles.destroy', $vehicle) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-truck fa-4x text-muted mb-3 d-block"></i>
                            <h5>No hay vehículos registrados</h5>
                            <p class="text-muted">Comienza agregando tu primer vehículo</p>
                            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Agregar Vehículo
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $vehicles->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function deleteVehicle(id, title) {
        if (confirm(`¿Estás seguro de eliminar el vehículo "${title}"?`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    document.querySelectorAll('.featured-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            fetch(`/admin/vehicles/${id}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const label = this.nextElementSibling;
                    const icon = label.querySelector('i');
                    if (data.featured) {
                        icon.classList.add('text-warning');
                        icon.classList.remove('text-muted');
                    } else {
                        icon.classList.remove('text-warning');
                        icon.classList.add('text-muted');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection