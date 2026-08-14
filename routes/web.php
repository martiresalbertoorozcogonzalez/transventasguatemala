<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// RUTAS PÚBLICAS - SIN AUTENTICACIÓN
// ============================================

Route::get('/', [VehicleController::class, 'index'])->name('home');

// ✅ RUTAS PÚBLICAS - NO REQUIEREN LOGIN
Route::get('/vehiculos', [VehicleController::class, 'index'])->name('vehicles.index');

Route::get('/vehiculos/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

// ✅ RUTA DE FILTRO - PÚBLICA
Route::get('/filtrar', [VehicleController::class, 'filter'])->name('vehicles.filter');

// ✅ RUTA DE BÚSQUEDA - PÚBLICA
Route::get('/buscar', [VehicleController::class, 'search'])->name('vehicles.search');

// Ruta de contacto por vehículo
Route::post('/contact.vehicle/{vehicle}', [ContactController::class, 'send'])->name('contact.vehicle');

// ============================================
// RUTAS DE AUTENTICACIÓN (BREEZE)
// ============================================

require __DIR__.'/auth.php';

// ============================================
// RUTAS ADMIN - SOLO PARA ADMINISTRADORES
// ============================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('vehicles', AdminVehicleController::class);
    
    Route::delete('vehicles/{vehicle}/image', [AdminVehicleController::class, 'deleteImage'])->name('vehicles.delete-image');
    Route::post('vehicles/{vehicle}/delete-image', [AdminVehicleController::class, 'deleteImage'])->name('vehicles.delete-image.post');
    Route::post('vehicles/{vehicle}/status', [AdminVehicleController::class, 'changeStatus'])->name('vehicles.status');
    Route::post('vehicles/{vehicle}/toggle-featured', [AdminVehicleController::class, 'toggleFeatured'])->name('vehicles.toggle-featured');
});

// ============================================
// RUTAS DE FAVORITOS - REQUIEREN LOGIN
// ============================================

Route::middleware(['auth'])->group(function () {
    Route::post('/favorites/{vehicle}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

// ============================================
// RUTA DASHBOARD (REDIRECCIÓN)
// ============================================

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->name('dashboard');


// Rutas admin para mensajes

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);
    Route::post('/contacts/{contact}/responded', [AdminContactController::class, 'markAsResponded'])->name('contacts.responded');
});