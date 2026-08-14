<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('vehicle')->latest()->paginate(15);
        $pendientes = Contact::where('status', 'pendiente')->count();
        $total = Contact::count();
        
        return view('admin.contacts.index', compact('contacts', 'pendientes', 'total'));
    }

    public function show(Contact $contact)
    {
        if ($contact->status === 'pendiente') {
            $contact->update(['status' => 'leido', 'read_at' => now()]);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function markAsResponded(Contact $contact)
    {
        $contact->update(['status' => 'respondido']);
        
        return response()->json([
            'success' => true,
            'message' => 'Mensaje marcado como respondido'
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Mensaje eliminado correctamente');
    }
}