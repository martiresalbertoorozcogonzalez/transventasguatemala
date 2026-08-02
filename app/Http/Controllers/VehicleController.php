<?php

namespace App\Http\Controllers; 

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class VehicleController extends Controller
{

    public function index()
    {
            // ✅ Todos los vehículos disponibles (ordenados por fecha de creación)
        $vehicles = Vehicle::available()->latest()->paginate(12);
        
        // ✅ Vehículos RECIÉN INGRESADOS (últimos 6)
        $recentVehicles = Vehicle::available()
            ->latest()
            ->limit(6)
            ->get();
        
        // ✅ Vehículos destacados (los dejamos para otra sección si quieres)
        $featuredVehicles = Vehicle::available()
            ->where('featured', true)
            ->latest()
            ->limit(6)
            ->get();
        
        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');
        
        return view('vehicles.index', compact('vehicles', 'recentVehicles', 'featuredVehicles', 'types', 'brands'));

    }

    
    public function show($slug)
    {
        // Buscar el vehículo por slug
        $vehicle = Vehicle::where('slug', $slug)->firstOrFail();
        
        // Incrementar contador de vistas
        $vehicle->increment('views');
        
        // Vehículos relacionados (mismo tipo)
        $related = Vehicle::available()
            ->where('type', $vehicle->type)
            ->where('id', '!=', $vehicle->id)
            ->limit(4)
            ->get();
        
        // Vehículos de la misma marca
        $sameBrand = Vehicle::available()
            ->where('brand', $vehicle->brand)
            ->where('id', '!=', $vehicle->id)
            ->limit(4)
            ->get();
        
        return view('vehicles.show', compact('vehicle', 'related', 'sameBrand'));
    }

    
       // ✅ MÉTODO FILTER - AGREGAR ESTE
   public function filter(Request $request)
{
    
        $query = Vehicle::available();

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->brand) {
            $query->where('brand', $request->brand);
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

        // ✅ Mantener los vehículos recién ingresados
        $recentVehicles = Vehicle::available()->latest()->limit(6)->get();
        $featuredVehicles = Vehicle::available()->where('featured', true)->latest()->limit(6)->get();
        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');

        return view('vehicles.index', compact('vehicles', 'recentVehicles', 'featuredVehicles', 'types', 'brands'));
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

        $vehicles = $query->latest()->paginate(12);
        
        // Si es AJAX, devolver solo el grid
        if ($request->ajax()) {
            return view('components.vehicle-grid', compact('vehicles'))->render();
        }

        // Si es una búsqueda normal
        $types = Vehicle::select('type')->distinct()->pluck('type');
        $brands = Vehicle::select('brand')->distinct()->pluck('brand');
        $recentVehicles = Vehicle::available()->latest()->limit(6)->get();
        $featuredVehicles = Vehicle::available()->where('featured', true)->latest()->limit(6)->get();

    return view('vehicles.index', compact('vehicles', 'recentVehicles', 'featuredVehicles', 'types', 'brands'));

    }

    // Admin CRUD
    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'type' => 'required|in:camion,furgon,plataforma,remolque',
            'brand' => 'required|max:100',
            'model' => 'required|max:100',
            'year' => 'required|integer|min:1970|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'mileage' => 'nullable|numeric|min:0',
            'color' => 'nullable|max:50',
            'engine' => 'nullable|max:100',
            'transmission' => 'nullable|max:50',
            'fuel_type' => 'nullable|max:50',
            'capacity' => 'nullable|numeric|min:0',
            'description' => 'required',
            'status' => 'required|in:disponible,vendido,reservado',
            'featured' => 'boolean',
            'features' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $validated['slug'] = Str::slug($validated['title'] . '-' . uniqid());
        
        if ($request->has('features')) {
            $validated['features'] = array_filter($request->features);
        }

        if ($request->hasFile('images')) {
            $validated['images'] = $this->handleImageUpload($request);
        }

        $vehicle = Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehículo creado exitosamente');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'type' => 'required|in:camion,furgon,plataforma,remolque',
            'brand' => 'required|max:100',
            'model' => 'required|max:100',
            'year' => 'required|integer|min:1970|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'mileage' => 'nullable|numeric|min:0',
            'color' => 'nullable|max:50',
            'engine' => 'nullable|max:100',
            'transmission' => 'nullable|max:50',
            'fuel_type' => 'nullable|max:50',
            'capacity' => 'nullable|numeric|min:0',
            'description' => 'required',
            'status' => 'required|in:disponible,vendido,reservado',
            'featured' => 'boolean',
            'features' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->has('features')) {
            $validated['features'] = array_filter($request->features);
        }

        if ($request->hasFile('images')) {
            // Eliminar imágenes antiguas
            if ($vehicle->images) {
                foreach ($vehicle->images as $oldImage) {
                    Storage::disk('public')->delete('vehicles/' . $oldImage);
                }
            }
            $validated['images'] = $this->handleImageUpload($request);
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehículo actualizado exitosamente');
    }

    public function destroy(Vehicle $vehicle)
    {
        // Eliminar imágenes
        if ($vehicle->images) {
            foreach ($vehicle->images as $image) {
                Storage::disk('public')->delete('vehicles/' . $image);
            }
        }
        
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehículo eliminado exitosamente');
    }

    private function handleImageUpload(Request $request)
    {
        $images = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $path = storage_path('app/public/vehicles/' . $filename);
                
                // Crear directorio si no existe
                if (!file_exists(storage_path('app/public/vehicles'))) {
                    mkdir(storage_path('app/public/vehicles'), 0777, true);
                }
                
                Image::make($image)
                    ->resize(800, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($path);
                
                $images[] = $filename;
            }
        }
        
        return $images;
    }


  public function contact(Request $request, Vehicle $vehicle)
        {
            $validated = $request->validate([
                'name' => 'required|max:100',
                'email' => 'required|email',
                'phone' => 'nullable|max:20',
                'message' => 'required|max:500',
            ]);

            // Enviar email al administrador
            $data = [
                'vehicle' => $vehicle,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'No especificado',
                'message' => $validated['message'],
            ];

            // Aquí puedes enviar el email
            // Mail::to('admin@camionesventa.com')->send(new VehicleContactEmail($data));

            return back()->with('success', '¡Mensaje enviado! Te contactaremos pronto.');
        }


        /**
         * Cambiar estado del vehículo
         */
        public function changeStatus(Request $request, Vehicle $vehicle)
        {
            $request->validate([
                'status' => 'required|in:disponible,vendido,reservado'
            ]);

            $vehicle->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado',
                'status' => $request->status
            ]);
        }

        /**
         * Marcar como destacado
         */
        public function toggleFeatured(Vehicle $vehicle)
        {
            $vehicle->update(['featured' => !$vehicle->featured]);

            return response()->json([
                'success' => true,
                'featured' => $vehicle->featured,
                'message' => $vehicle->featured ? '⭐ Destacado' : 'Quitado de destacados'
            ]);
        }

        /**
         * Eliminar imagen específica
         */
        public function deleteImage(Request $request, Vehicle $vehicle)
        {
            $request->validate([
                'image' => 'required|string'
            ]);

            $image = $request->image;
            
            // Eliminar de storage
            Storage::disk('public')->delete('vehicles/' . $image);
            
            // Eliminar del array de imágenes
            $images = $vehicle->images;
            $images = array_filter($images, function($img) use ($image) {
                return $img !== $image;
            });
            
            $vehicle->update(['images' => array_values($images)]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada'
            ]);
        }
}