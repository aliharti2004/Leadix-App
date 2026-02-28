<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;
    public $url;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
        $this->url = URL::signedRoute('register', ['invitation_token' => $invitation->token]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Join ' . $this->invitation->organization->name . ' on LeadiX',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.team.invitation',
        );
    }
}
