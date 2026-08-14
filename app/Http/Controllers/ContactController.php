<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request, Vehicle $vehicle)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string|max:1000',
            ]);

            // Guardar en la base de datos
            $contact = Contact::create([
                'vehicle_id' => $vehicle->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'message' => $validated['message'],
                'status' => 'pendiente',
            ]);

            // Log para saber que llegó
            \Log::info('Nuevo mensaje de contacto:', [
                'id' => $contact->id,
                'vehiculo' => $vehicle->title,
                'nombre' => $contact->name,
                'email' => $contact->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Mensaje enviado correctamente. Te contactaremos pronto.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en contacto: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => '❌ Error al enviar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }
}