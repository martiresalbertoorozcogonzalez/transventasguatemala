{{-- resources/views/admin/test.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Test')

@section('content')
<h1>Test del Admin</h1>
<p>Si ves esto, el panel admin funciona correctamente.</p>
<a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
    Ir a Crear Vehículo
</a>
@endsection