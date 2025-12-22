<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
// Tambahkan/Ganti isi class Order dengan ini
protected $fillable = ['user_id', 'total_price', 'status', 'shipping_address', 'tracking_number', 'snap_token'];

public function report()
{
    // Satu pesanan punya satu laporan (asumsi 1 order = 1 paket laporan)
    return $this->hasOne(Report::class);
}
public function user() {
    return $this->belongsTo(User::class);
}

public function items() {
    return $this->hasMany(OrderItem::class);
}
}