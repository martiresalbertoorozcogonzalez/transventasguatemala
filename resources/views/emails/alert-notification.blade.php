<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevos vehículos disponibles</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 40%, #0d1b2a 100%); padding: 30px; text-align: center; color: #ffffff; }
        .header img { max-height: 60px; margin-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .header h1 span { color: #64b5f6; }
        .content { padding: 30px; }
        .content h2 { color: #1a1a3e; margin-top: 0; }
        .alert-info { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 20px; }
        .alert-info strong { color: #1a1a3e; }
        .vehicle-item { border: 1px solid #e9ecef; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
        .vehicle-item:hover { border-color: #0d6efd; }
        .vehicle-item .title { font-size: 18px; font-weight: 600; color: #1a1a3e; margin-bottom: 5px; }
        .vehicle-item .details { color: #6c757d; font-size: 14px; margin-bottom: 5px; }
        .vehicle-item .price { font-size: 20px; font-weight: 700; color: #0d6efd; }
        .btn { display: inline-block; padding: 10px 25px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: #ffffff; text-decoration: none; border-radius: 30px; font-weight: 600; margin-top: 10px; }
        .footer { padding: 20px; text-align: center; color: #6c757d; font-size: 12px; border-top: 1px solid #e9ecef; }
        .footer a { color: #0d6efd; text-decoration: none; }
        .badge { display: inline-block; padding: 4px 12px; background: #28a745; color: #ffffff; border-radius: 20px; font-size: 12px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" alt="TransVentas Guatemala">
            <h1>Transventas</span> Guatemala</h1>
            <p style="margin: 0; opacity: 0.8;">Tu plataforma de confianza</p>
        </div>
        <div class="content">
            <h2>🔔 ¡Nuevos vehículos disponibles!</h2>
            <p>Hola <strong>{{ $alert->user->name }}</strong>,</p>
            <p>Hay <strong>{{ $count }}</strong> vehículo(s) nuevo(s) que coinciden con tu alerta:</p>
            <div class="alert-info">
                <strong>📌 {{ $alert->name }}</strong>
                <br>
                <small style="color: #6c757d;">{{ $alert->criteria_description }}</small>
            </div>
            @foreach($vehicles as $vehicle)
            <div class="vehicle-item">
                <div class="title">{{ $vehicle->title }}</div>
                <div class="details">
                    <span class="badge">{{ ucfirst($vehicle->type) }}</span>
                    {{ $vehicle->brand }} {{ $vehicle->model }} · {{ $vehicle->year }}
                    @if($vehicle->mileage) · {{ number_format($vehicle->mileage) }} km @endif
                </div>
                <div class="price">{{ $vehicle->price_formatted }}</div>
                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn">Ver Detalles</a>
            </div>
            @endforeach
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('alerts.index') }}" style="color: #0d6efd; text-decoration: none;">Gestionar mis alertas →</a>
            </div>
        </div>
        <div class="footer">
            <p>Este correo fue enviado automáticamente porque tienes una alerta activa en <a href="{{ route('home') }}">TransVentas Guatemala</a>.</p>
            <p>© {{ date('Y') }} TransVentas Guatemala. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>