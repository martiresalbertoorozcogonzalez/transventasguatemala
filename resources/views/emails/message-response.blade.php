<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta a tu mensaje</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 40%, #0d1b2a 100%); padding: 30px; text-align: center; color: #ffffff; }
        .header img { max-height: 60px; margin-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .header h1 span { color: #64b5f6; }
        .content { padding: 30px; }
        .content h2 { color: #1a1a3e; margin-top: 0; }
        .message-box { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 15px 0; border: 1px solid #e9ecef; }
        .message-box p { margin: 0; line-height: 1.6; }
        .vehicle-info { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #0d6efd; margin-bottom: 20px; }
        .vehicle-info a { color: #0d6efd; text-decoration: none; font-weight: 600; }
        .btn { display: inline-block; padding: 10px 25px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: #ffffff; text-decoration: none; border-radius: 30px; font-weight: 600; margin-top: 10px; }
        .footer { padding: 20px; text-align: center; color: #6c757d; font-size: 12px; border-top: 1px solid #e9ecef; }
        .footer a { color: #0d6efd; text-decoration: none; }
        .response-box { background: #e8f5e9; padding: 20px; border-radius: 8px; margin: 15px 0; border: 1px solid #c8e6c9; }
        .response-box p { margin: 0; line-height: 1.6; color: #1b5e20; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" alt="TransVentas Guatemala">
            <h1>Trans<span>Ventas</span> Guatemala</h1>
            <p style="margin: 0; opacity: 0.8;">Tu plataforma de confianza</p>
        </div>
        <div class="content">
            <h2>📩 Respuesta a tu mensaje</h2>
            <p>Hola <strong>{{ $contact->name }}</strong>,</p>
            <p>Has recibido una respuesta a tu mensaje sobre el vehículo:</p>
            <div class="vehicle-info">
                <strong>🚗 Vehículo:</strong>
                <a href="{{ route('vehicles.show', $contact->vehicle->slug) }}">
                    {{ $contact->vehicle->title }}
                </a>
            </div>
            <h4>📝 Tu mensaje original:</h4>
            <div class="message-box">
                <p>{{ $contact->message }}</p>
            </div>
            <h4>💬 Respuesta de TransVentas:</h4>
            <div class="response-box">
                <p>{{ $response->message }}</p>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('vehicles.show', $contact->vehicle->slug) }}" class="btn">Ver Vehículo</a>
            </div>
            <div style="text-align: center; margin-top: 10px;">
                <small style="color: #6c757d;">¿Tienes más preguntas? Puedes responder a este correo o contactarnos nuevamente desde el vehículo.</small>
            </div>
        </div>
        <div class="footer">
            <p>Este correo fue enviado en respuesta a tu mensaje en <a href="{{ route('home') }}">TransVentas Guatemala</a>.</p>
            <p>© {{ date('Y') }} TransVentas Guatemala. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>