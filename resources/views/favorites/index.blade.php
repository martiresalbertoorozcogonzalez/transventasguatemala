@extends('layouts.app')

@section('title', 'Mis Favoritos')

@section('content')


<script>

// ============================================
// TOGGLE FAVORITOS
// ============================================
function toggleFavorite(vehicleId, element) {
    const url = `/favorites/${vehicleId}/toggle`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // Mostrar loading
    if (element) {
        element.disabled = true;
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
            return;
        }
        
        if (data.success) {
            // Actualizar el botón
            const btn = element;
            const icon = btn.querySelector('i');
            const text = btn.querySelector('#favoriteText') || btn.querySelector('span');
            const count = document.getElementById('favoriteCount');
            
            if (data.isFavorited) {
                btn.className = 'btn btn-danger w-100';
                if (text) text.textContent = 'Eliminar de favoritos';
                if (icon) icon.classList.remove('text-muted');
                if (icon) icon.classList.add('text-white');
            } else {
                btn.className = 'btn btn-outline-danger w-100';
                if (text) text.textContent = 'Agregar a favoritos';
                if (icon) icon.classList.remove('text-white');
                if (icon) icon.classList.add('text-danger');
            }
            
            if (count) {
                count.textContent = data.count;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    })
    .finally(() => {
        if (element) {
            element.disabled = false;
        }
    });
}

</script>


<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-heart text-danger"></i> Mis Vehículos Favoritos</h2>
    
    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($favorite->vehicle->images && count($favorite->vehicle->images) > 0)
                        <img src="{{ asset('storage/vehicles/' . $favorite->vehicle->images[0]) }}" 
                             class="card-img-top" alt="{{ $favorite->vehicle->title }}"
                             style="height: 180px; object-fit: cover; object-position: center;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 180px;">
                            <i class="fas fa-truck fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($favorite->vehicle->title, 35) }}</h6>
                        <p class="text-primary fw-bold">{{ $favorite->vehicle->price_formatted }}</p>
                        <a href="{{ route('vehicles.show', $favorite->vehicle) }}" class="btn btn-primary btn-sm w-100">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-heart fa-4x text-muted mb-3"></i>
            <h4>No tienes vehículos favoritos</h4>
            <p class="text-muted">Explora y agrega tus vehículos favoritos ❤️</p>
            <a href="{{ route('vehicles.index') }}" class="btn btn-primary">
                <i class="fas fa-search"></i> Ver Vehículos
            </a>
        </div>
    @endif
</div>



@endsection

