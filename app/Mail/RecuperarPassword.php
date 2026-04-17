<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $code; // varaible para guardar el código

    public function __construct($code)
    {
        $this->code = $code; // recibimos el código cuando llamen a esta clase
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu código de recuperación - Condominio',
        );
    }

    public function content(): Content
    {
        // Le decimos qué archivo visual va a usar
        return new Content(
            view: 'emails.recovery', 
        );
    }
}