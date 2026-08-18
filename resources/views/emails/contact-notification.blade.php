<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 40%, #0d1b2a 100%); padding: 30px; text-align: center; color: #ffffff; }
        .header img { max-height: 60px; margin-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .header h1 span { color: #64b5f6; }
        .content { padding: 30px; }
        .content h2 { color: #1a1a3e; margin-top: 0; }
        .vehicle-info { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #0d6efd; margin-bottom: 20px; }
        .vehicle-info a { color: #0d6efd; text-decoration: none; font-weight: 600; }
        .message-box { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 15px 0; border: 1px solid #e9ecef; }
        .message-box p { margin: 0; line-height: 1.6; }
        .btn { display: inline-block; padding: 10px 25px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: #ffffff; text-decoration: none; border-radius: 30px; font-weight: 600; margin-top: 10px; }
        .footer { padding: 20px; text-align: center; color: #6c757d; font-size: 12px; border-top: 1px solid #e9ecef; }
        .contact-details { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/LogoTransventasGuatemala.png') }}" alt="TransVentas Guatemala">
            <h1>Transventas</span> Guatemala</h1>
            <p style="margin: 0; opacity: 0.8;">Tu pagina de confianza</p>
        </div>
        <div class="content">
            <h2>📩 Nuevo mensaje de contacto</h2>
            <p>Has recibido un nuevo mensaje de contacto en TransVentas Guatemala.</p>
            <div class="vehicle-info">
                <strong>🚗 Vehículo:</strong>
                <a href="{{ route('vehicles.show', $vehicle) }}">{{ $vehicle->title }}</a>
            </div>
            <h4 style="margin-top: 20px;">👤 Datos del contacto</h4>
            <div class="contact-details">
                <p><strong>Nombre:</strong> {{ $contact->name }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                @if($contact->phone) <p><strong>Teléfono:</strong> {{ $contact->phone }}</p> @endif
                <p><strong>Fecha:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <h4>💬 Mensaje</h4>
            <div class="message-box">
                <p>{{ $contact->message }}</p>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('admin.contacts.index') }}" class="btn">Responder desde el Panel Admin</a>
            </div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} TransVentas Guatemala. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>