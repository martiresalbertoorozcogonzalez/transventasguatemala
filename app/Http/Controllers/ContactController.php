<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Vehicle;
use App\Mail\ContactNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

            $contact = Contact::create([
                'vehicle_id' => $vehicle->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'message' => $validated['message'],
                'status' => 'pendiente',
            ]);

            try {
                Mail::to('admin@camionesventa.com')->send(new ContactNotificationMail($contact, $vehicle));
            } catch (\Exception $e) {
                \Log::error('Error al enviar correo de contacto: ' . $e->getMessage());
            }

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

    // ✅ CHAT EN EL DETALLE DEL VEHÍCULO - VERSIÓN FUNCIONAL
    public function getConversation(Request $request, $vehicleId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes iniciar sesión'
                ], 401);
            }
            
            $vehicle = Vehicle::find($vehicleId);
            
            if (!$vehicle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vehículo no encontrado'
                ], 404);
            }
            
            $contact = Contact::where('vehicle_id', $vehicle->id)
                ->where('email', $user->email)
                ->with(['responses.user'])
                ->first();
            
            if (!$contact) {
                return response()->json([
                    'success' => true,
                    'has_conversation' => false,
                    'message' => 'No hay conversación aún'
                ]);
            }
            
            $conversation = $contact->conversation;
            
            return response()->json([
                'success' => true,
                'has_conversation' => true,
                'contact_id' => $contact->id,
                'conversation' => $conversation,
                'status' => $contact->status,
                'created_at' => $contact->created_at->format('d/m/Y H:i')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en getConversation: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar la conversación'
            ], 500);
        }
    }

    public function sendMessageFromDetail(Request $request, $vehicleId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes iniciar sesión'
                ], 401);
            }
            
            $request->validate([
                'message' => 'required|string|min:3|max:1000'
            ]);
            
            $vehicle = Vehicle::find($vehicleId);
            
            if (!$vehicle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vehículo no encontrado'
                ], 404);
            }
            
            $contact = Contact::where('vehicle_id', $vehicle->id)
                ->where('email', $user->email)
                ->first();
            
            if ($contact) {
                if ($contact->status == 'pendiente' || $contact->status == 'leido') {
                    $contact->update([
                        'message' => $request->message,
                        'status' => 'pendiente'
                    ]);
                } else {
                    $contact = Contact::create([
                        'vehicle_id' => $vehicle->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone ?? null,
                        'message' => $request->message,
                        'status' => 'pendiente'
                    ]);
                }
            } else {
                $contact = Contact::create([
                    'vehicle_id' => $vehicle->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? null,
                    'message' => $request->message,
                    'status' => 'pendiente'
                ]);
            }
            
            try {
                Mail::to('admin@camionesventa.com')->send(new ContactNotificationMail($contact, $vehicle));
            } catch (\Exception $e) {
                \Log::error('Error al enviar correo: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => '✅ Mensaje enviado. El admin te responderá pronto.',
                'contact_id' => $contact->id
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en sendMessageFromDetail: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje'
            ], 500);
        }
    }
}