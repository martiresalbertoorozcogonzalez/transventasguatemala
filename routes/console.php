<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('alerts:check', function () {
    $this->info('🔍 Verificando alertas...');

    $alerts = \App\Models\Alert::where('is_active', true)->get();
    $notificationsSent = 0;

    foreach ($alerts as $alert) {
        $controller = app(\App\Http\Controllers\AlertController::class);
        $vehicles = $controller->getMatchingVehicles($alert);

        if ($vehicles->count() > 0) {
            try {
                \Illuminate\Support\Facades\Mail::to($alert->user->email)
                    ->send(new \App\Mail\AlertNotificationMail($alert, $vehicles));
                $notificationsSent++;
                $this->info("✅ Notificación enviada para: {$alert->name}");
            } catch (\Exception $e) {
                $this->error("❌ Error al enviar notificación para {$alert->name}: " . $e->getMessage());
            }

            $alert->update(['last_sent_at' => now()]);
        }
    }

    $this->info("📊 Notificaciones enviadas: {$notificationsSent}");
})->purpose('Verificar alertas y enviar notificaciones a los usuarios');