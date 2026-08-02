<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Directiva para verificar si es admin
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->is_admin;
        });
    }
}