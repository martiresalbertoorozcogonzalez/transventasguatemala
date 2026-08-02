{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p class="mb-0">
            <i class="fas fa-truck"></i> Mi Sitio - {{ date('Y') }}
        </p>
        <small class="text-muted">Todos los derechos reservados</small>
    </div>


    <div class="text-center mb-3">
       @include('partials.social-links')
   </div>

</footer>