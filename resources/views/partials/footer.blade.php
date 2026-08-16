<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5><i class="fas fa-truck"></i>TransVentas <span style="color: #64b5f6;">Guatemala</span></h5>
                <p class="text-muted">Tu plataforma de confianza para comprar y vender vehículos comerciales.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                    <li><a href="{{ route('vehicles.index') }}" class="text-white-50 text-decoration-none">Vehículos</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Síguenos</h5>
                <div class="d-flex gap-3">
                    <a href="https://www.facebook.com/TransVentasGuatemala" target="_blank" class="text-white-50">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    <a href="https://www.instagram.com/TransVentasGuatemala" target="_blank" class="text-white-50">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="https://www.tiktok.com/@TransVentasGuatemala" target="_blank" class="text-white-50">
                        <i class="fab fa-tiktok fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
        <hr class="border-light">
        <div class="text-center">
            <small>&copy; {{ date('Y') }} TransVentas <span style="color: #64b5f6;">Guatemala.</span> Todos los derechos reservados.</small>
        </div>
    </div>
</footer>