@extends('admin.layouts.admin')

@section('title', 'Detalle del Mensaje')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-envelope"></i> Detalle del Mensaje</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $contact->id }}</td>
                    </tr>
                    <tr>
                        <th>Vehículo</th>
                        <td>
                            <a href="{{ route('vehicles.show', $contact->vehicle->slug) }}" target="_blank">
                                {{ $contact->vehicle->title }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td>{{ $contact->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $contact->phone ?? 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($contact->status == 'pendiente')
                                <span class="badge bg-danger">🔴 Pendiente</span>
                            @elseif($contact->status == 'leido')
                                <span class="badge bg-warning">🟡 Leído</span>
                            @else
                                <span class="badge bg-success">🟢 Respondido</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-comment"></i> Mensaje</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $contact->message }}</p>
                    </div>
                </div>
                
                <div class="mt-3">
                    <button class="btn btn-success" onclick="marcarRespondido({{ $contact->id }})">
                        <i class="fas fa-check"></i> Marcar como Respondido
                    </button>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function marcarRespondido(id) {
    if (confirm('¿Marcar este mensaje como respondido?')) {
        fetch(`/admin/contacts/${id}/responded`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    }
}
</script>
@endpush
@endsection