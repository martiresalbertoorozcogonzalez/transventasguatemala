<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\UserMessageNotification;
use App\Mail\ContactNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserMessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $messages = Contact::where('email', $user->email)
            ->with(['vehicle', 'responses'])
            ->latest()
            ->paginate(10);
        
        UserMessageNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        $unreadCount = $user->unreadMessageNotifications()->count();
        
        return view('user.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(Contact $contact)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($contact->email !== $user->email) {
            abort(403, 'No tienes permiso para ver este mensaje');
        }
        
        UserMessageNotification::where('user_id', $user->id)
            ->where('contact_id', $contact->id)
            ->update(['is_read' => true]);
        
        $conversation = $contact->conversation;
        $vehicle = $contact->vehicle;
        
        return view('user.messages.show', compact('contact', 'conversation', 'vehicle'));
    }

    public function sendMessage(Request $request, Contact $contact)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión'
            ], 401);
        }
        
        if ($contact->email !== $user->email) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para enviar mensajes en esta conversación'
            ], 403);
        }
        
        $request->validate([
            'message' => 'required|string|min:3|max:1000'
        ]);

        if ($contact->status == 'respondido') {
            $newContact = Contact::create([
                'vehicle_id' => $contact->vehicle_id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? null,
                'message' => $request->message,
                'status' => 'pendiente'
            ]);
            
            try {
                Mail::to('admin@camionesventa.com')->send(new ContactNotificationMail($newContact, $contact->vehicle));
            } catch (\Exception $e) {
                \Log::error('Error al enviar correo: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => '✅ Mensaje enviado. El admin te responderá pronto.',
                'new_conversation' => true,
                'contact_id' => $newContact->id
            ]);
        }
        
        $contact->update([
            'message' => $request->message,
            'status' => 'pendiente'
        ]);
        
        try {
            Mail::to('admin@camionesventa.com')->send(new ContactNotificationMail($contact, $contact->vehicle));
        } catch (\Exception $e) {
            \Log::error('Error al enviar correo: ' . $e->getMessage());
        }
        
        return response()->json([
            'success' => true,
            'message' => '✅ Mensaje enviado. El admin te responderá pronto.',
            'new_conversation' => false
        ]);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['count' => 0]);
        }
        
        $count = $user->unreadMessageNotifications()->count();
        return response()->json(['count' => $count]);
    }
}