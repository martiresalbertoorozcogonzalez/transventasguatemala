<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\MessageResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $response;

    public function __construct(Contact $contact, MessageResponse $response)
    {
        $this->contact = $contact;
        $this->response = $response;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📩 Respuesta a tu mensaje - TransVentas Guatemala',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.message-response',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}