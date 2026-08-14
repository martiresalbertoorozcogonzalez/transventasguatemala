@extends('admin.layouts.admin')

@section('title', 'Mensajes de Contacto')

@section('content')
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Mensajes</h5>
                <h2 class="mb-0">{{ $total }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Pendientes</h5>
                <h2 class="mb-0">{{ $pendientes }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-envelope"></i> Todos los Mensajes</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehículo</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr class="{{ $contact->status == 'pendiente' ? 'table-danger' : '' }}">
                        <td>{{ $contact->id }}</td>
                        <td>
                            <a href="{{ route('vehicles.show', $contact->vehicle->slug) }}" target="_blank">
                                {{ Str::limit($contact->vehicle->title, 30) }}
                            </a>
                        </td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>
                            @if($contact->status == 'pendiente')
                                <span class="badge bg-danger">🔴 Pendiente</span>
                            @elseif($contact->status == 'leido')
                                <span class="badge bg-warning">🟡 Leído</span>
                            @else
                                <span class="badge bg-success">🟢 Respondido</span>
                            @endif
                        </td>
                        <td>{{ $contact->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este mensaje?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $contacts->links() }}
        </div>
    </div>
</div>
@endsection