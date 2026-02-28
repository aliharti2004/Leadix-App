<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ContactUpdatedNotification extends Notification
{
    use Queueable;

    protected $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Contact Updated ✏️',
            'message' => "Contact updated: {$this->contact->name}",
            'contact_id' => $this->contact->id,
            'type' => 'contact_updated',
            'icon' => 'pencil'
        ];
    }
}
