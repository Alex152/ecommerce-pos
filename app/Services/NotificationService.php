<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\OrderShipped;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InventoryAlert;

class NotificationService
{
    public function sendOrderNotification(User $user, array $orderData): void
    {
        Notification::send($user, new OrderShipped($orderData));
    }

    public function sendInventoryAlert(array $products): void
    {
        $admins = User::role('admin')->get();
        Notification::send($admins, new InventoryAlert($products));
    }
}