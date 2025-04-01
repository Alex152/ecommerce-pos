<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InventoryAlert extends Notification
{
    use Queueable;

    public function __construct(public array $products) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ Low Stock Alert')
            ->markdown('emails.inventory-alert', [
                'products' => $this->products,
            ]);
    }
}
