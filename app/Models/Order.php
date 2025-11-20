<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',  // Tambahkan ini
        'full_name',
        'phone',
        'address',  // Atau 'shipping_address' jika ingin konsisten
        'province_id',
        'city_id',
        'district_id',
        'postal_code',  // Tambahkan jika ingin simpan
        'courier',
        'weight',
        'subtotal',
        'shipping_cost',
        'total',  // Atau 'grand_total' jika lebih suka
        'shipping_status',  // Tambahkan jika ingin simpan
        'status',
        'payment_status',
    ];

    // Relasi tetap sama
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}