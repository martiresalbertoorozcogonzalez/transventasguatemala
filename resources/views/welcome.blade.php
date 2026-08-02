{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TransventasGuatemala')</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f5f5f5;
        }
        .navbar-brand i {
            margin-right: 10px;
        }
        .vehicle-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }
        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
        .vehicle-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .badge-status {
            font-size: 0.8rem;
            padding: 5px 10px;
        }
        .filters-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .price-text {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .feature-item {
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 2px 0;
        }
        .vehicle-gallery img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        @media (max-width: 768px) {
            .vehicle-gallery img {
                height: 250px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @include('partials.navbar')
    
    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Filtros AJAX
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'GET',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#vehicleGrid').html('<div class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
                    },
                    success: function(response) {
                        $('#vehicleGrid').html(response);
                    },
                    error: function() {
                        $('#vehicleGrid').html('<div class="alert alert-danger">Error al cargar los filtros</div>');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>