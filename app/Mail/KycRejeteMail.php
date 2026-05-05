<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KycRejeteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $motif) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Votre dossier KYC a ete rejete');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.kyc.rejete', with: [
            'user' => $this->user,
            'motif' => $this->motif,
        ]);
    }
}
