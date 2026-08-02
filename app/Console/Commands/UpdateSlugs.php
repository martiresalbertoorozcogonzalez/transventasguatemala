<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateSlugs extends Command
{
    protected $signature = 'vehicles:update-slugs';
    protected $description = 'Actualizar slugs de los vehículos';

    public function handle()
    {
        $vehicles = Vehicle::all();
        
        foreach ($vehicles as $vehicle) {
            if (empty($vehicle->slug)) {
                $vehicle->slug = Str::slug($vehicle->title . '-' . $vehicle->id);
                $vehicle->save();
                $this->info('Slug actualizado: ' . $vehicle->slug);
            }
        }
        
        $this->info('✅ Slugs actualizados correctamente');
    }
}
