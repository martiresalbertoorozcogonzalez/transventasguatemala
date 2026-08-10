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

{{-- Agregar en el head de layouts/app.blade.php --}}

<style>
    /* ============================================ */
    /* ESTILOS PARA BARRA DE BÚSQUEDA */
    /* ============================================ */
    
    /* Input de búsqueda - texto claro */
    #searchInput {
        background: white !important;
        color: #2d3436 !important;
        font-weight: 500;
    }
    
    #searchInput::placeholder {
        color: #a0aec0 !important;
        font-weight: 400;
    }
    
    #searchInput:focus {
        box-shadow: none !important;
        outline: none !important;
    }
    
    /* Sugerencias - resultados claros */
    #searchSuggestions {
        background: white !important;
        border-radius: 16px !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2) !important;
        border: 1px solid rgba(0,0,0,0.05) !important;
        backdrop-filter: blur(10px);
    }
    
    #searchSuggestions .suggestion-item {
        padding: 12px 20px;
        cursor: pointer;
        transition: background 0.2s;
        border-bottom: 1px solid #f1f3f5;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    #searchSuggestions .suggestion-item:hover {
        background: #f8f9fa;
    }
    
    #searchSuggestions .suggestion-item:last-child {
        border-bottom: none;
    }
    
    #searchSuggestions .suggestion-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    #searchSuggestions .suggestion-item .info {
        flex: 1;
    }
    
    #searchSuggestions .suggestion-item .info h6 {
        margin: 0;
        font-size: 0.95rem;
        color: #2d3436;
        font-weight: 600;
    }
    
    #searchSuggestions .suggestion-item .info .details {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    #searchSuggestions .suggestion-item .price {
        font-weight: 700;
        color: #0d6efd;
        font-size: 0.95rem;
    }
    
    /* Scroll personalizado para sugerencias */
    #searchSuggestions::-webkit-scrollbar {
        width: 6px;
    }
    
    #searchSuggestions::-webkit-scrollbar-track {
        background: #f1f3f5;
        border-radius: 10px;
    }
    
    #searchSuggestions::-webkit-scrollbar-thumb {
        background: #c1c7cd;
        border-radius: 10px;
    }
    
    #searchSuggestions::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
    
    /* Responsive */
    @media (max-width: 576px) {
        .search-box-wrapper .input-group {
            border-radius: 30px !important;
        }
        
        .search-box-wrapper .btn {
            padding: 0.5rem 1.2rem !important;
            font-size: 0.85rem !important;
        }
        
        #searchInput {
            font-size: 0.95rem !important;
        }
    }

    {{-- Agregar en el head de layouts/app.blade.php --}}


    /* ============================================ */
    /* ESPACIO EN EL HERO */
    /* ============================================ */
    
    .hero-section {
        position: relative;
        overflow: hidden;
        min-height: 90vh;
        display: flex;
        align-items: center;
        padding: 100px 0 80px 0; /* Más espacio arriba y abajo */
    }
    
    /* Ajuste para pantallas pequeñas */
    @media (max-width: 768px) {
        .hero-section {
            min-height: 100vh;
            padding: 80px 0 60px 0;
        }
        
        .hero-section h1 {
            font-size: 2.5rem !important;
        }
        
        .hero-section .lead {
            font-size: 1.1rem !important;
        }
        
        .hero-section .counter-box h3 {
            font-size: 1.5rem !important;
        }
    }
    
    /* Espacio entre elementos */
    .hero-section .mb-4 {
        margin-bottom: 2rem !important;
    }
    
    .hero-section .mb-5 {
        margin-bottom: 3rem !important;
    }

    {{-- Agregar en layouts/app.blade.php --}}


    /* ============================================ */
    /* EFECTO HOVER PARA TODAS LAS TARJETAS */
    /* ============================================ */
    
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: pointer;
        position: relative;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .hover-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15) !important;
        background: rgba(255, 255, 255, 1);
        border-color: rgba(13, 110, 253, 0.2);
    }
    
    /* Efecto de la imagen dentro de la tarjeta */
    .hover-card .img-container img,
    .hover-card img {
        transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    
    .hover-card:hover .img-container img,
    .hover-card:hover img {
        transform: scale(1.05);
    }
    
    /* Sombra de la tarjeta al hacer hover */
    .hover-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 20px;
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }
    
    .hover-card:hover::after {
        opacity: 1;
    }
    
    /* Efecto de elevación (sombra superior) */
    .hover-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 
                    0 10px 20px rgba(0, 0, 0, 0.05) !important;
    }



     /* ============================================ */
    /* CENTRADO PERFECTO DEL HERO */
    /* ============================================ */
    
    .hero-section {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    
    .hero-section .container {
        margin: 0 auto;
        text-align: center;
    }
    
    .hero-section .container > * {
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-section .d-flex.justify-content-center {
        display: flex !important;
        justify-content: center !important;
    }


</style>

</head>
<body>


    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Transventas Guatemala</span>
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



    {{-- public/css/app.css o en layouts/app.blade.php --}}



    
    /* ============================================ */
    /* EFECTOS GLOBALES */
    /* ============================================ */
    
    /* Scroll suave */
    html {
        scroll-behavior: smooth;
    }
    
    /* Hover cards */
    .hover-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .hover-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
    .hover-card:hover img {
        transform: scale(1.05);
    }
    
    /* Botones con gradiente */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        border: none;
        color: white;
        transition: all 0.3s;
    }
    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(13,110,253,0.4);
        color: white;
    }
    
    /* Animación de entrada */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    /* Estilo para el hero */
    .hero-section {
        position: relative;
        overflow: hidden;
        min-height: 80vh;
        display: flex;
        align-items: center;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(ellipse at 70% 50%, rgba(13,110,253,0.1) 0%, transparent 70%);
        z-index: 1;
    }
    
    /* Categorías hover */
    .hover-scale {
        transition: all 0.3s ease;
    }
    .hover-scale:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }

    
</style>

</body>
</html>