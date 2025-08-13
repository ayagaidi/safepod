<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'phonenumber',
        'address',
        'total_price',
        'order_statues_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->ordersnumber)) {
                $order->ordersnumber = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }
    
    public function orderstatues() {
        return $this->belongsTo(OrderStatues::class, 'order_statues_id');
    }
    
    public function items() {
        return $this->hasMany(Orderitems::class, 'orders_id');
    }

    public function orderitems()
    {
        return $this->hasMany(Orderitems::class, 'orders_id');
    }
}
