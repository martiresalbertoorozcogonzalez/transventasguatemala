<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::available();

        // ✅ Filtro por tipo (categoría)
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Filtros adicionales
        if ($request->brand) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->year_from) {
            $query->where('year', '>=', $request->year_from);
        }

        if ($request->year_to) {
            $query->where('year', '<=', $request->year_to);
        }

        $vehicles = $query->latest()->paginate(12);
        
        // ✅ Vehículos recién ingresados (siempre se muestran, independientemente de la categoría)
        $recentVehicles = Vehicle::available()->latest()->limit(6)->get();
        
        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');

        return view('vehicles.index', compact('vehicles', 'recentVehicles', 'types', 'brands'));
    }

    public function show($slug)
    {
        $vehicle = Vehicle::where('slug', $slug)->firstOrFail();
        $vehicle->increment('views');
        
        $related = Vehicle::available()
            ->where('type', $vehicle->type)
            ->where('id', '!=', $vehicle->id)
            ->limit(4)
            ->get();
        
        return view('vehicles.show', compact('vehicle', 'related'));
    }

    public function filter(Request $request)
    {
        $query = Vehicle::available();

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->brand) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->year_from) {
            $query->where('year', '>=', $request->year_from);
        }

        if ($request->year_to) {
            $query->where('year', '<=', $request->year_to);
        }

        $vehicles = $query->latest()->paginate(12);
        
        if ($request->ajax()) {
            return view('components.vehicle-grid', compact('vehicles'))->render();
        }

        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');
        $recentVehicles = Vehicle::available()->latest()->limit(6)->get();

        return view('vehicles.index', compact('vehicles', 'recentVehicles', 'types', 'brands'));
    }

    public function search(Request $request)
    {
        $query = Vehicle::available();

        if ($request->q) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                  ->orWhere('model', 'like', '%' . $searchTerm . '%')
                  ->orWhere('type', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('year', 'like', '%' . $searchTerm . '%');
            });
        }

        // ✅ Si hay tipo en la búsqueda, filtrar por tipo
        if ($request->type) {
            $query->where('type', $request->type);
        }

        $vehicles = $query->latest()->paginate(12);
        
        if ($request->ajax()) {
            return view('components.vehicle-grid', compact('vehicles'))->render();
        }

        $recentVehicles = Vehicle::available()->latest()->limit(6)->get();
        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');

        return view('vehicles.index', compact('vehicles', 'recentVehicles', 'types', 'brands'));
    }
}