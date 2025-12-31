<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    // Kita terima data Order yang baru dibuat
    public function __construct($order)
    {
        $this->order = $order;
    }

    // Tentukan jalur pengiriman: 'database' agar tersimpan di DB
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Format data yang akan disimpan di database
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'tracking_number' => $this->order->tracking_number,
            'user_name' => $this->order->user->name,
            'total_price' => $this->order->total_price,
            'message' => 'Pesanan baru ' . $this->order->tracking_number . ' dari ' . $this->order->user->name,
            'link' => route('admin.orders.show', $this->order->id), // Link langsung ke detail order
            'type' => 'new_order' // Penanda jenis notifikasi
        ];
    }
}