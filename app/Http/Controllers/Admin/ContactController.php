<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\MessageResponse;
use App\Mail\MessageResponseMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with(['vehicle', 'responses'])->latest()->paginate(15);
        $pendientes = Contact::where('status', 'pendiente')->count();
        $total = Contact::count();
        $respondidos = Contact::where('status', 'respondido')->count();
        
        return view('admin.contacts.index', compact('contacts', 'pendientes', 'total', 'respondidos'));
    }

    public function show(Contact $contact)
    {
        if ($contact->status === 'pendiente') {
            $contact->update(['status' => 'leido', 'read_at' => now()]);
        }
        
        $responses = $contact->responses()->with('user')->latest()->get();
        
        return view('admin.contacts.show', compact('contact', 'responses'));
    }

    public function markAsResponded(Contact $contact)
    {
        $contact->update(['status' => 'respondido']);
        
        return response()->json([
            'success' => true,
            'message' => 'Mensaje marcado como respondido'
        ]);
    }

    public function sendResponse(Request $request, Contact $contact)
    {
        $request->validate([
            'message' => 'required|string|min:3|max:1000'
        ]);

        $response = MessageResponse::create([
            'contact_id' => $contact->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        $contact->update(['status' => 'respondido']);

        // ✅ Enviar correo al usuario
        try {
            Mail::to($contact->email)->send(new MessageResponseMail($contact, $response));
            \Log::info('Correo de respuesta enviado a: ' . $contact->email);
        } catch (\Exception $e) {
            \Log::error('Error al enviar correo de respuesta: ' . $e->getMessage());
        }

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', '✅ Respuesta enviada correctamente. El usuario recibirá un correo.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', '🗑️ Mensaje eliminado correctamente');
    }
}