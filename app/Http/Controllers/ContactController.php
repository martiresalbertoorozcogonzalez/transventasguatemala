<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request, Vehicle $vehicle)
    {
        try {
            // Validar los datos
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string|max:1000',
            ]);

            // Datos para el correo
            $data = [
                'vehicle' => $vehicle,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'No especificado',
                'message' => $validated['message'],
            ];

            // Guardar el mensaje en la base de datos (opcional)
            // \App\Models\Contact::create($data);

            // Enviar correo (descomentar cuando tengas Mail configurado)
            // Mail::to('admin@camionesventa.com')->send(new \App\Mail\ContactMail($data));

            // Log del mensaje
            \Log::info('Nuevo mensaje de contacto:', $data);

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente. Te contactaremos pronto.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en contacto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }
}