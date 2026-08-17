<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Auth::user()->alerts()->latest()->get();
        return view('alerts.index', compact('alerts'));
    }

    public function create()
    {
        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');
        return view('alerts.create', compact('types', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
            'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_to' => 'nullable|integer|min:1900|max:' . date('Y') . '|gte:year_from',
            'keyword' => 'nullable|string|max:100',
            'frequency' => 'required|in:daily,weekly',
        ]);

        $alert = Auth::user()->alerts()->create($validated);

        $matchingVehicles = $this->getMatchingVehicles($alert);

        return redirect()->route('alerts.index')
            ->with('success', '✅ Alerta creada exitosamente!')
            ->with('matching_count', $matchingVehicles->count());
    }

    // ✅ CORREGIDO: Sin authorize()
    public function edit(Alert $alert)
    {
        // Verificar que la alerta pertenece al usuario
        if ($alert->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta alerta');
        }
        
        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');
        return view('alerts.edit', compact('alert', 'types', 'brands'));
    }

    // ✅ CORREGIDO: Sin authorize()
    public function update(Request $request, Alert $alert)
    {
        // Verificar que la alerta pertenece al usuario
        if ($alert->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta alerta');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
            'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_to' => 'nullable|integer|min:1900|max:' . date('Y') . '|gte:year_from',
            'keyword' => 'nullable|string|max:100',
            'frequency' => 'required|in:daily,weekly',
        ]);

        $alert->update($validated);

        return redirect()->route('alerts.index')
            ->with('success', '✅ Alerta actualizada exitosamente');
    }

    // ✅ CORREGIDO: Sin authorize()
    public function toggle(Alert $alert)
    {
        // Verificar que la alerta pertenece al usuario
        if ($alert->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta alerta'
            ], 403);
        }

        $alert->update(['is_active' => !$alert->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $alert->is_active,
            'message' => $alert->is_active ? 'Alerta activada' : 'Alerta desactivada'
        ]);
    }

    // ✅ CORREGIDO: Sin authorize()
    public function destroy(Alert $alert)
    {
        // Verificar que la alerta pertenece al usuario
        if ($alert->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar esta alerta');
        }

        $alert->delete();

        return redirect()->route('alerts.index')
            ->with('success', '🗑️ Alerta eliminada correctamente');
    }

    private function getMatchingVehicles(Alert $alert)
    {
        $query = Vehicle::available();

        if ($alert->type) {
            $query->where('type', $alert->type);
        }

        if ($alert->brand) {
            $query->where('brand', 'like', '%' . $alert->brand . '%');
        }

        if ($alert->min_price) {
            $query->where('price', '>=', $alert->min_price);
        }

        if ($alert->max_price) {
            $query->where('price', '<=', $alert->max_price);
        }

        if ($alert->year_from) {
            $query->where('year', '>=', $alert->year_from);
        }

        if ($alert->year_to) {
            $query->where('year', '<=', $alert->year_to);
        }

        if ($alert->keyword) {
            $query->where(function($q) use ($alert) {
                $q->where('title', 'like', '%' . $alert->keyword . '%')
                  ->orWhere('brand', 'like', '%' . $alert->keyword . '%')
                  ->orWhere('model', 'like', '%' . $alert->keyword . '%')
                  ->orWhere('description', 'like', '%' . $alert->keyword . '%');
            });
        }

        return $query->get();
    }

    public static function checkAlerts()
    {
        $alerts = Alert::where('is_active', true)->get();
        $results = [];

        foreach ($alerts as $alert) {
            $controller = new self();
            $vehicles = $controller->getMatchingVehicles($alert);
            
            if ($vehicles->count() > 0) {
                $results[] = [
                    'alert' => $alert,
                    'vehicles' => $vehicles,
                    'count' => $vehicles->count()
                ];
                
                $alert->update(['last_sent_at' => now()]);
            }
        }

        return $results;
    }
}