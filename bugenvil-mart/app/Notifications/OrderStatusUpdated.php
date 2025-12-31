<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Simpan di database
    }

    public function toArray(object $notifiable): array
    {
        // Pesan disesuaikan dengan status
        $statusMessage = match($this->order->status) {
            'packing' => 'sedang dikemas.',
            'shipping' => 'sedang dalam perjalanan!',
            'completed' => 'telah selesai. Terima kasih!',
            'cancelled' => 'dibatalkan.',
            default => 'statusnya diperbarui.',
        };

        // Jika ada resi, tampilkan
        $resiMessage = $this->order->resi ? " (Resi: {$this->order->resi})" : "";

        return [
            'order_id' => $this->order->id,
            'title' => 'Update Pesanan',
            'message' => "Pesanan #{$this->order->tracking_number} {$statusMessage}{$resiMessage}",
            'link' => route('orders.show', $this->order->id),
            'type' => 'order_status'
        ];
    }
}