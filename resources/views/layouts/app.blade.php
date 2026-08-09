<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transventas Guatemala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta name="description" content="@yield('meta_description', 'Camiones, furgones y plataformas en venta. Encuentra el vehículo comercial que necesitas al mejor precio.')">
    <meta property="og:title" content="@yield('title', 'Camiones en Venta')">
    <meta property="og:description" content="@yield('meta_description', 'Vehículos comerciales en venta')">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">


    
    <!-- FUNCIÓN GLOBAL changeImage -->
       
    <script>
        function changeImage(url, element) {
            console.log('📸 changeImage ejecutada');
            console.log('📸 Nueva URL:', url);
            
            // Cambiar la imagen principal
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = url;
                console.log('✅ Imagen cambiada');
            } else {
                console.warn('⚠️ No se encontró #mainImage');
            }
            
            // Quitar borde de todas las miniaturas
            document.querySelectorAll('.thumbnail-img, .cursor-pointer, .miniatura').forEach(el => {
                el.style.border = '2px solid transparent';
                el.style.borderColor = 'transparent';
                el.style.borderWidth = '2px';
            });
            
            // Agregar borde a la seleccionada
            if (element) {
                element.style.border = '2px solid #0d6efd';
                element.style.borderColor = '#0d6efd';
                element.style.borderWidth = '2px';
            }
        }
        
        console.log('✅ Función changeImage cargada globalmente');
    </script>

@yield('meta')

</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">TransventasGuatemala</span>
            <div>
                @auth
                    <span class="text-white me-2">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger btn-sm">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Registro</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <div class="container py-4">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<style>
    /* ============================================ */
    /* ESTILOS PARA IMÁGENES - VERSIÓN COMPLETA */
    /* ============================================ */
    
    /* Contenedor de imagen en el grid */
    .img-container {
        width: 100%;
        height: 200px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    
    /* Contenedor de imagen en el detalle */
    .img-container-lg {
        width: 100%;
        height: 450px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
        position: relative;
    }
    
    /* Contenedor de miniaturas */
    .img-container-sm {
        width: 100%;
        height: 80px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 4px;
        position: relative;
    }
    
    /* La imagen dentro del contenedor */
    .img-full {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        object-position: center;
        background-color: #f8f9fa;
    }
    
    /* Imágenes en vehículos relacionados */
    .img-related {
        width: 100%;
        height: 150px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .img-related img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        object-position: center;
    }

     /* Estilo para el badge "Nuevo" */
    .badge-new {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>

</body>
</html>