<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Vehicle $vehicle)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $isFavorited = $user->toggleFavorite($vehicle->id);

        // ✅ Redirigir de vuelta a la página anterior
        return redirect()->back()->with('success', $isFavorited ? '❤️ Agregado a favoritos' : 'Eliminado de favoritos');
    }

    public function index()
    {
        $favorites = Auth::user()->favorites()->with('vehicle')->get();
        return view('favorites.index', compact('favorites'));
    }
}