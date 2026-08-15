<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// RUTAS PÚBLICAS
// ============================================

Route::get('/', [VehicleController::class, 'index'])->name('home');


Route::get('/vehiculos', [VehicleController::class, 'index'])->name('vehicles.index');

Route::get('/vehiculos/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');


Route::get('/filtrar', [VehicleController::class, 'filter'])->name('vehicles.filter');


Route::get('/buscar', [VehicleController::class, 'search'])->name('vehicles.search');

// ✅ RUTA DE BENEFICIOS
Route::get('/beneficios', [PageController::class, 'beneficios'])->name('pages.beneficios');

// ============================================
// RUTAS DE CONTACTO
// ============================================

Route::post('/vehiculos/{vehicle}/contactar', [ContactController::class, 'send'])->name('contact.vehicle');

// ============================================
// RUTAS DE AUTENTICACIÓN (Breeze)
// ============================================

require __DIR__.'/auth.php';

// ============================================
// RUTAS DE FAVORITOS
// ============================================

Route::middleware(['auth'])->group(function () {
    Route::post('/favorites/{vehicle}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

// ============================================
// RUTAS ADMIN
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
    
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);

    Route::post('/contacts/{contact}/responded', [AdminContactController::class, 'markAsResponded'])->name('contacts.responded');

});


Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');

    })->name('dashboard');


    
    Route::middleware(['auth'])->group(function () {
    Route::post('/favorites/{vehicle}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

});