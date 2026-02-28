<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ContactCreatedNotification extends Notification
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
            'title' => 'New Contact Added 👤',
            'message' => "New contact: {$this->contact->name}" . ($this->contact->company ? " at {$this->contact->company}" : ''),
            'contact_id' => $this->contact->id,
            'type' => 'contact_created',
            'icon' => 'user-plus'
        ];
    }
}
