<?php

namespace App\Console\Commands;

use App\Mail\AlertNotificationMail;
use App\Models\Alert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckAlertsCommand extends Command
{
    protected $signature = 'alerts:check';
    protected $description = 'Verificar alertas y enviar notificaciones a los usuarios';

    public function handle()
    {
        $this->info('🔍 Verificando alertas...');

        $alerts = Alert::where('is_active', true)->get();
        $notificationsSent = 0;

        foreach ($alerts as $alert) {
            // Obtener vehículos que coinciden
            $controller = app(\App\Http\Controllers\AlertController::class);
            $vehicles = $controller->getMatchingVehicles($alert);

            if ($vehicles->count() > 0) {
                // Enviar correo al usuario
                try {
                    Mail::to($alert->user->email)->send(new AlertNotificationMail($alert, $vehicles));
                    $notificationsSent++;
                    $this->info("✅ Notificación enviada para: {$alert->name}");
                } catch (\Exception $e) {
                    $this->error("❌ Error al enviar notificación para {$alert->name}: " . $e->getMessage());
                }

                // Actualizar fecha de último envío
                $alert->update(['last_sent_at' => now()]);
            }
        }

        $this->info("📊 Notificaciones enviadas: {$notificationsSent}");
    }
}