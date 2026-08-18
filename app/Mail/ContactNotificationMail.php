<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $vehicle;

    public function __construct(Contact $contact, Vehicle $vehicle)
    {
        $this->contact = $contact;
        $this->vehicle = $vehicle;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📩 Nuevo mensaje de contacto - ' . $this->vehicle->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}