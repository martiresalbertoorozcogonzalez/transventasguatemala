<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Iniciando creación de vehículos...');

        $vehicles = [
            // ============================================
            // CAMIONES
            // ============================================
            [
                'title' => 'Camión Mercedes-Benz Actros 2023',
                'type' => 'camion',
                'brand' => 'Mercedes-Benz',
                'model' => 'Actros',
                'year' => 2023,
                'price' => 185000.00,
                'mileage' => 15000,
                'color' => 'Blanco',
                'engine' => '12.8L V6',
                'transmission' => 'Automática',
                'fuel_type' => 'Diésel',
                'capacity' => 25,
                'description' => 'Camión Mercedes-Benz Actros modelo 2023 en excelente estado. Motor 12.8L V6, transmisión automática, capacidad de carga 25 toneladas. Ideal para transporte de larga distancia.',
                'features' => ['ABS', 'Aire acondicionado', 'GPS', 'Cámara de reversa', 'Sistema de asistencia'],
                'status' => 'disponible',
                'featured' => true,
            ],
            [
                'title' => 'Camión Volvo FH 2022',
                'type' => 'camion',
                'brand' => 'Volvo',
                'model' => 'FH',
                'year' => 2022,
                'price' => 165000.00,
                'mileage' => 25000,
                'color' => 'Rojo',
                'engine' => '13.0L V6',
                'transmission' => 'Automática',
                'fuel_type' => 'Diésel',
                'capacity' => 22,
                'description' => 'Camión Volvo FH 2022, potente y eficiente. Motor 13.0L V6, transmisión automática, capacidad de carga 22 toneladas. Excelente para carretera.',
                'features' => ['ABS', 'Aire acondicionado', 'GPS', 'Sistema de frenos', 'Asiento neumático'],
                'status' => 'disponible',
                'featured' => true,
            ],
            [
                'title' => 'Camión Scania R500 2021',
                'type' => 'camion',
                'brand' => 'Scania',
                'model' => 'R500',
                'year' => 2021,
                'price' => 145000.00,
                'mileage' => 35000,
                'color' => 'Azul',
                'engine' => '12.7L V8',
                'transmission' => 'Manual',
                'fuel_type' => 'Diésel',
                'capacity' => 20,
                'description' => 'Camión Scania R500 2021, robusto y confiable. Motor 12.7L V8, transmisión manual, capacidad de carga 20 toneladas. Ideal para trabajos pesados.',
                'features' => ['ABS', 'GPS', 'Sistema de climatización', 'Retarder'],
                'status' => 'disponible',
                'featured' => false,
            ],
            [
                'title' => 'Camión Freightliner Century 2001',
                'type' => 'camion',
                'brand' => 'Freightliner',
                'model' => 'Century',
                'year' => 2001,
                'price' => 25000.00,
                'mileage' => 350000,
                'color' => 'Blanco',
                'engine' => 'Detroit 12.7',
                'transmission' => 'Manual',
                'fuel_type' => 'Diésel',
                'capacity' => 18,
                'description' => 'Camión Freightliner Century 2001, económico y funcional. Motor Detroit 12.7, transmisión manual, capacidad de carga 18 toneladas. Ideal para trabajo local.',
                'features' => ['ABS', 'Sistema de frenos de motor', 'Cabina durmiente'],
                'status' => 'disponible',
                'featured' => false,
            ],
            [
                'title' => 'Camión International ProStar 2020',
                'type' => 'camion',
                'brand' => 'International',
                'model' => 'ProStar',
                'year' => 2020,
                'price' => 95000.00,
                'mileage' => 85000,
                'color' => 'Negro',
                'engine' => '12.4L V6',
                'transmission' => 'Automática',
                'fuel_type' => 'Diésel',
                'capacity' => 20,
                'description' => 'Camión International ProStar 2020, vehículo vendido. Mantenimiento al día, excelente estado.',
                'features' => ['ABS', 'GPS', 'Climatizador', 'Cámara de reversa'],
                'status' => 'vendido',
                'featured' => false,
            ],

            // ============================================
            // FURGONES
            // ============================================
            [
                'title' => 'Furgón Renault Master 2023',
                'type' => 'furgon',
                'brand' => 'Renault',
                'model' => 'Master',
                'year' => 2023,
                'price' => 48000.00,
                'mileage' => 5000,
                'color' => 'Blanco',
                'engine' => '2.3L Diesel',
                'transmission' => 'Manual',
                'fuel_type' => 'Diésel',
                'capacity' => 4.5,
                'description' => 'Furgón Renault Master 2023, completamente nuevo. Motor 2.3L diésel, transmisión manual, capacidad de carga 4.5 toneladas. Perfecto para entregas urbanas.',
                'features' => ['Elevador trasero', 'Estanterías', 'Climatizador', 'Cámara de reversa'],
                'status' => 'disponible',
                'featured' => true,
            ],
            [
                'title' => 'Furgón Mercedes-Benz Sprinter 2022',
                'type' => 'furgon',
                'brand' => 'Mercedes-Benz',
                'model' => 'Sprinter',
                'year' => 2022,
                'price' => 52000.00,
                'mileage' => 12000,
                'color' => 'Gris',
                'engine' => '3.0L V6',
                'transmission' => 'Automática',
                'fuel_type' => 'Diésel',
                'capacity' => 5.0,
                'description' => 'Furgón Mercedes-Benz Sprinter 2022, versátil y confiable. Motor 3.0L V6, transmisión automática, capacidad de carga 5 toneladas. Ideal para mensajería y logística.',
                'features' => ['GPS', 'Cámara de reversa', 'Sistema de climatización', 'Puertas traseras dobles'],
                'status' => 'disponible',
                'featured' => false,
            ],
            [
                'title' => 'Furgón Ford Transit 2021',
                'type' => 'furgon',
                'brand' => 'Ford',
                'model' => 'Transit',
                'year' => 2021,
                'price' => 38000.00,
                'mileage' => 28000,
                'color' => 'Azul',
                'engine' => '2.2L Diesel',
                'transmission' => 'Manual',
                'fuel_type' => 'Diésel',
                'capacity' => 4.0,
                'description' => 'Furgón Ford Transit 2021, práctico y eficiente. Motor 2.2L diésel, transmisión manual, capacidad de carga 4 toneladas. Excelente para reparto.',
                'features' => ['ABS', 'Aire acondicionado', 'Sistema de entrega', 'Estanterías'],
                'status' => 'disponible',
                'featured' => false,
            ],
            [
                'title' => 'Furgón Fuso Canter 2020',
                'type' => 'furgon',
                'brand' => 'Fuso',
                'model' => 'Canter',
                'year' => 2020,
                'price' => 28000.00,
                'mileage' => 45000,
                'color' => 'Blanco',
                'engine' => '3.0L Diesel',
                'transmission' => 'Manual',
                'fuel_type' => 'Diésel',
                'capacity' => 3.5,
                'description' => 'Furgón Fuso Canter 2020, vehículo vendido. Motor 3.0L diésel, capacidad de carga 3.5 toneladas.',
                'features' => ['ABS', 'Aire acondicionado', 'Elevador trasero'],
                'status' => 'vendido',
                'featured' => false,
            ],

            // ============================================
            // PLATAFORMAS
            // ============================================
            [
                'title' => 'Plataforma Ford Cargo 2023',
                'type' => 'plataforma',
                'brand' => 'Ford',
                'model' => 'Cargo',
                'year' => 2023,
                'price' => 85000.00,
                'mileage' => 8000,
                'color' => 'Rojo',
                'engine' => '7.3L V8',
                'transmission' => 'Automática',
                'fuel_type' => 'Diésel',
                'capacity' => 18,
                'description' => 'Plataforma Ford Cargo 2023, robusta y confiable. Motor 7.3L V8, transmisión automática, capacidad de carga 18 toneladas. Ideal para construcción y transporte de materiales.',
                'features' => ['Sistema hidráulico', 'Luces LED', 'Sistema de anclaje', 'ABS'],
                'status' => 'disponible',
                'featured' => true,
            ],
            [
                'title' => 'Plataforma Mercedes-Benz Atego 2022',
                'type' => 'plataforma',
                'brand' => 'Mercedes-Benz',
                'model' => 'Atego',
                'year' => 2022,
                'price' => 72000.00,
                'mileage' => 15000,
                'color' => 'Blanco',
                'engine' => '6.4L V6',
                'transmission' => 'Manual',
                'fuel_type' => 'Diésel',
                'capacity' => 15,
                'description' => 'Plataforma Mercedes-Benz Atego 2022, versátil y eficiente. Motor 6.4L V6, transmisión manual, capacidad de carga 15 toneladas. Excelente para todo tipo de carga.',
                'features' => ['ABS', 'Sistema hidráulico', 'Climatizador', 'Luces de trabajo'],
                'status' => 'disponible',
                'featured' => false,
            ],
            [
                'title' => 'Plataforma Scania P410 2021',
                'type' => 'plataforma',
                'brand' => 'Scania',
                'model' => 'P410',
                'year' => 2021,
                'price' => 68000.00,
                'mileage' => 32000,
                'color' => 'Amarillo',
                'engine' => '10.5L V6',
                'transmission' => 'Automática',
                'fuel_type' => 'Diésel',
                'capacity' => 16,
                'description' => 'Plataforma Scania P410 2021, potente y duradera. Motor 10.5L V6, transmisión automática, capacidad de carga 16 toneladas. Ideal para trabajos pesados.',
                'features' => ['Sistema hidráulico', 'ABS', 'Asiento neumático', 'Luces LED'],
                'status' => 'disponible',
                'featured' => false,
            ],

            // ============================================
            // REMOLQUES
            // ============================================
            [
                'title' => 'Remolque Fruehauf XL 2023',
                'type' => 'remolque',
                'brand' => 'Fruehauf',
                'model' => 'XL',
                'year' => 2023,
                'price' => 45000.00,
                'mileage' => 2000,
                'color' => 'Gris',
                'engine' => null,
                'transmission' => null,
                'fuel_type' => null,
                'capacity' => 30,
                'description' => 'Remolque Fruehauf XL 2023, completamente nuevo. Capacidad de carga 30 toneladas, ideal para transporte de carga pesada y larga distancia.',
                'features' => ['Sistema de frenos ABS', 'Luces LED', 'Eje tandem', 'Sistema de suspensión neumática'],
                'status' => 'disponible',
                'featured' => true,
            ],
            [
                'title' => 'Remolque Utility 2022',
                'type' => 'remolque',
                'brand' => 'Utility',
                'model' => 'Trailer',
                'year' => 2022,
                'price' => 38000.00,
                'mileage' => 15000,
                'color' => 'Blanco',
                'engine' => null,
                'transmission' => null,
                'fuel_type' => null,
                'capacity' => 25,
                'description' => 'Remolque Utility 2022, construido con materiales de alta calidad. Capacidad de carga 25 toneladas, perfecto para transporte de mercancías.',
                'features' => ['ABS', 'Sistema de suspensión', 'Luces LED', 'Eje tandem'],
                'status' => 'disponible',
                'featured' => false,
            ],
            [
                'title' => 'Remolque Hyundai 2021',
                'type' => 'remolque',
                'brand' => 'Hyundai',
                'model' => 'HD Trailer',
                'year' => 2021,
                'price' => 32000.00,
                'mileage' => 25000,
                'color' => 'Rojo',
                'engine' => null,
                'transmission' => null,
                'fuel_type' => null,
                'capacity' => 22,
                'description' => 'Remolque Hyundai 2021, resistente y confiable. Capacidad de carga 22 toneladas, ideal para transporte regional.',
                'features' => ['Sistema de frenos', 'Luces LED', 'Eje simple', 'Suspensión de muelles'],
                'status' => 'disponible',
                'featured' => false,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            $vehicle['slug'] = Str::slug($vehicle['title'] . '-' . uniqid());
            Vehicle::create($vehicle);
        }

        $this->command->info('✅ ' . count($vehicles) . ' vehículos creados exitosamente');
        $this->command->info('');
        $this->command->info('📊 Resumen:');
        $this->command->info('   🚛 Camiones: ' . Vehicle::where('type', 'camion')->count());
        $this->command->info('   🚐 Furgones: ' . Vehicle::where('type', 'furgon')->count());
        $this->command->info('   📦 Plataformas: ' . Vehicle::where('type', 'plataforma')->count());
        $this->command->info('   🔗 Remolques: ' . Vehicle::where('type', 'remolque')->count());
        $this->command->info('   ✅ Disponibles: ' . Vehicle::where('status', 'disponible')->count());
        $this->command->info('   ❌ Vendidos: ' . Vehicle::where('status', 'vendido')->count());
    }
}