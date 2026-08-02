<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:vehicles,title',
            'type' => 'required|in:camion,furgon,plataforma,remolque',
            'brand' => 'required|max:100',
            'model' => 'required|max:100',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'mileage' => 'nullable|numeric|min:0',
            'color' => 'nullable|max:50',
            'engine' => 'nullable|max:100',
            'transmission' => 'nullable|max:50',
            'fuel_type' => 'nullable|max:50',
            'capacity' => 'nullable|numeric|min:0',
            'description' => 'required|min:20',
            'status' => 'required|in:disponible,vendido,reservado',
            'featured' => 'nullable|boolean',
            'features_string' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        try {
            $features = [];
            if ($request->has('features_string') && $request->features_string) {
                $features = array_map('trim', explode(',', $request->features_string));
                $features = array_filter($features);
            }

            $data = $validated;
            $data['slug'] = Str::slug($validated['title'] . '-' . uniqid());
            $data['features'] = $features;
            $data['featured'] = $request->has('featured');
            unset($data['features_string']);

            if ($request->hasFile('images')) {
                $data['images'] = $this->handleImageUpload($request);
            }

            $vehicle = Vehicle::create($data);

            return redirect()->route('admin.vehicles.index')
                ->with('success', '✅ Vehículo "' . $vehicle->title . '" creado exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '❌ Error al crear: ' . $e->getMessage());
        }
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:vehicles,title,' . $vehicle->id,
            'type' => 'required|in:camion,furgon,plataforma,remolque',
            'brand' => 'required|max:100',
            'model' => 'required|max:100',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'mileage' => 'nullable|numeric|min:0',
            'color' => 'nullable|max:50',
            'engine' => 'nullable|max:100',
            'transmission' => 'nullable|max:50',
            'fuel_type' => 'nullable|max:50',
            'capacity' => 'nullable|numeric|min:0',
            'description' => 'required|min:20',
            'status' => 'required|in:disponible,vendido,reservado',
            'featured' => 'nullable|boolean',
            'features_string' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        try {
            $features = [];
            if ($request->has('features_string') && $request->features_string) {
                $features = array_map('trim', explode(',', $request->features_string));
                $features = array_filter($features);
            }

            $data = $validated;
            $data['features'] = $features;
            $data['featured'] = $request->has('featured');
            unset($data['features_string']);

            if ($request->hasFile('images')) {
                if ($vehicle->images) {
                    foreach ($vehicle->images as $oldImage) {
                        Storage::disk('public')->delete('vehicles/' . $oldImage);
                    }
                }
                $data['images'] = $this->handleImageUpload($request);
            }

            $vehicle->update($data);

            return redirect()->route('admin.vehicles.index')
                ->with('success', '✅ Vehículo "' . $vehicle->title . '" actualizado.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '❌ Error al actualizar: ' . $e->getMessage());
        }
    }


    public function destroy(Vehicle $vehicle)
    {
        try {
            if ($vehicle->images) {
                foreach ($vehicle->images as $image) {
                    Storage::disk('public')->delete('vehicles/' . $image);
                }
            }
            
            $vehicle->delete();

            return redirect()->route('admin.vehicles.index')
                ->with('success', '🗑️ Vehículo eliminado.');

        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al eliminar: ' . $e->getMessage());
        }
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function changeStatus(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'status' => 'required|in:disponible,vendido,reservado'
        ]);

        $vehicle->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado'
        ]);
    }

    public function toggleFeatured(Vehicle $vehicle)
    {
        $vehicle->update(['featured' => !$vehicle->featured]);

        return response()->json([
            'success' => true,
            'featured' => $vehicle->featured
        ]);
    }

    /**
     * ✅ SUBIR IMÁGENES - Método que funciona en TODAS las versiones
     * Sin dependencias externas
     */
    private function handleImageUpload(Request $request)
    {
        $images = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $path = storage_path('app/public/vehicles/' . $filename);
                
                if (!file_exists(storage_path('app/public/vehicles'))) {
                    mkdir(storage_path('app/public/vehicles'), 0777, true);
                }
                
                // ✅ Mover el archivo directamente
                move_uploaded_file($image->getPathname(), $path);
                
                $images[] = $filename;
            }
        }
        
        return $images;
    }


 
    public function deleteImage(Request $request, Vehicle $vehicle)
{
    try {
        \Log::info('=== DELETE IMAGE ===');
        \Log::info('Vehículo ID: ' . $vehicle->id);
        \Log::info('Vehículo Slug: ' . $vehicle->slug);
        \Log::info('Imágenes actuales:', $vehicle->images ?? []);
        
        $imageName = $request->input('image');
        \Log::info('Imagen a eliminar: ' . $imageName);
        
        if (!$imageName) {
            return response()->json([
                'success' => false,
                'message' => 'No se especificó la imagen'
            ], 400);
        }
        
        // Verificar que la imagen existe
        if (!$vehicle->images || !in_array($imageName, $vehicle->images)) {
            return response()->json([
                'success' => false,
                'message' => 'La imagen no existe en este vehículo'
            ], 404);
        }
        
        // Eliminar archivo físico
        $path = 'vehicles/' . $imageName;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            \Log::info('Archivo eliminado: ' . $path);
        }
        
        // Eliminar del array
        $images = array_values(array_filter($vehicle->images, function($img) use ($imageName) {
            return $img !== $imageName;
        }));
        
        $vehicle->images = $images;
        $vehicle->save();
        
        \Log::info('Imágenes restantes: ' . count($images));

        return response()->json([
            'success' => true,
            'message' => '✅ Imagen eliminada correctamente',
            'images' => $images
        ]);

    } catch (\Exception $e) {
        \Log::error('Error deleteImage: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => '❌ Error: ' . $e->getMessage()
        ], 500);
    }
}


}