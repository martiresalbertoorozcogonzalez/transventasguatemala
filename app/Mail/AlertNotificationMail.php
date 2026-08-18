<?php

namespace App\Mail;

use App\Models\Alert;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlertNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alert;
    public $vehicles;
    public $count;

    public function __construct(Alert $alert, $vehicles)
    {
        $this->alert = $alert;
        $this->vehicles = $vehicles;
        $this->count = $vehicles->count();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Nuevos vehículos disponibles para tu alerta: ' . $this->alert->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.alert-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}